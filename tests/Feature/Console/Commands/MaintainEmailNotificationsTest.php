<?php

declare(strict_types = 1);

use App\Jobs\NotifyEmailDeliveryFailureJob;
use App\Models\User;
use App\Notifications\EmailDeliveryFailedNotification;
use App\Support\QueueNames;
use Illuminate\Queue\Events\JobQueueing;
use Illuminate\Queue\WorkerOptions;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Str;

beforeEach(function (): void {
    $this->travelTo(now()->startOfSecond());
    Http::preventStrayRequests();
    config(['mail.tracking_retention_days' => 30, 'alerts.discord.enabled' => false, 'queue.connections.database.connection' => config('database.default')]);
});

it('marks stale unconfirmed publication without requeueing the original mail and protects active records', function (): void {
    $stale   = maintenanceEmail(['queued_at' => null, 'created_at' => now()->subMinutes(6)]);
    $fresh   = maintenanceEmail(['queued_at' => null]);
    $queued  = maintenanceEmail(['created_at' => now()->subDay()]);
    $active  = maintenanceEmail(['queued_at' => null, 'created_at' => now()->subHour(), 'processing_started_at' => now()]);
    $unknown = maintenanceEmail(['queued_at' => null, 'created_at' => now()->subHour(), 'processing_started_at' => now()->subMinutes(3), 'attempt_count' => 1]);
    $foreign = maintenanceEmail(['environment' => 'production', 'queued_at' => null, 'created_at' => now()->subHour()]);

    $this->artisan('email:maintain-notifications')->assertSuccessful();

    expect(DB::table('email_notifications')->where('id', $stale)->first()->failed_at)->not->toBeNull();
    expect(DB::table('email_notifications')->where('id', $unknown)->first()->uncertain_at)->not->toBeNull();

    foreach ([$fresh, $queued, $active, $foreign] as $id) {
        expect(DB::table('email_notifications')->where('id', $id)->first()->completed_at)->toBeNull();
    }

    $payload = json_decode(DB::table('jobs')->sole()->payload, true, flags: JSON_THROW_ON_ERROR);
    expect($payload['data']['commandName'])->toBe(NotifyEmailDeliveryFailureJob::class);
    Http::assertNothingSent();
});

it('recovers pending channels without duplicate pending jobs or completed internal and Discord notices', function (bool $internalDone): void {
    $actor = User::factory()->user()->create();
    $id    = maintenanceEmail(['failed_at' => now()->subHour(), 'completed_at' => now()->subHour(), 'requester_id' => $actor->id, 'notified_at' => $internalDone ? now() : null]);

    if ($internalDone) {
        Notification::sendNow($actor, new EmailDeliveryFailedNotification($id));
    }

    $url = 'https://discord.test/api/webhooks/123/MAINTENANCE_SECRET_SENTINEL';
    config(['alerts.discord.enabled' => true, 'alerts.discord.webhook_url' => $url, 'alerts.discord.retry_times' => 1]);
    Http::fake([$url => Http::response([], 204)]);

    $this->artisan('email:maintain-notifications')->assertSuccessful();
    $this->artisan('email:maintain-notifications')->assertSuccessful();
    $this->assertDatabaseCount('jobs', 1);
    $job = Queue::connection('database')->pop(QueueNames::resolve('high_priority'));
    app('queue.worker')->setCache(Cache::store())->process('database', $job, new WorkerOptions(maxTries: 1));
    $this->artisan('email:maintain-notifications')->assertSuccessful();

    expect($actor->notifications()->count())->toBe(1);
    expect(DB::table('email_notifications')->where('id', $id)->first()->notified_at)->not->toBeNull();
    expect(DB::table('email_notifications')->where('id', $id)->first()->discord_notified_at)->not->toBeNull();
    Http::assertSentCount(1);
    $this->assertDatabaseCount('jobs', 0);
})->with([false, true]);

it('retains active uncertain pending-alert and recently changed records while deleting only eligible history', function (): void {
    $old       = now()->subDays(31);
    $base      = ['created_at' => $old, 'updated_at' => $old, 'completed_at' => $old];
    $accepted  = maintenanceEmail([...$base, 'accepted_at' => $old]);
    $skipped   = maintenanceEmail([...$base, 'skipped_at' => $old]);
    $notified  = maintenanceEmail([...$base, 'failed_at' => $old, 'notified_at' => $old]);
    $pending   = maintenanceEmail([...$base, 'failed_at' => $old]);
    $active    = maintenanceEmail([...$base, 'completed_at' => null]);
    $uncertain = maintenanceEmail([...$base, 'uncertain_at' => $old]);
    $recent    = maintenanceEmail([...$base, 'accepted_at' => $old, 'updated_at' => now()]);
    $foreign   = maintenanceEmail([...$base, 'accepted_at' => $old, 'environment' => 'production']);
    $boundary  = maintenanceEmail([...$base, 'accepted_at' => $old, 'completed_at' => now()->subDays(30)]);

    $this->artisan('email:maintain-notifications')->assertSuccessful();

    foreach ([$accepted, $skipped, $notified] as $id) {
        expect(DB::table('email_notifications')->where('id', $id)->exists())->toBeFalse();
    }

    foreach ([$pending, $active, $uncertain, $recent, $foreign, $boundary] as $id) {
        expect(DB::table('email_notifications')->where('id', $id)->exists())->toBeTrue();
    }
});

it('preserves missing Discord confirmation while enabled even if its webhook is not configured', function (): void {
    $old = now()->subDays(31);
    $id  = maintenanceEmail(['created_at' => $old, 'updated_at' => $old, 'completed_at' => $old, 'failed_at' => $old, 'notified_at' => $old]);
    config(['alerts.discord.enabled' => true, 'alerts.discord.webhook_url' => '']);

    $this->artisan('email:maintain-notifications')->assertSuccessful();

    expect(DB::table('email_notifications')->where('id', $id)->exists())->toBeTrue();
    $this->assertDatabaseCount('jobs', 1);
    Http::assertNothingSent();
});

it('respects configurable retention and processes history across multiple batches', function (): void {
    config(['mail.tracking_retention_days' => 7]);
    $old = now()->subDays(8);

    foreach (range(1, 101) as $index) {
        maintenanceEmail(['created_at' => $old, 'updated_at' => $old, 'completed_at' => $old, 'accepted_at' => $old]);
    }

    $recent = maintenanceEmail(['created_at' => now()->subDays(6), 'updated_at' => now()->subDays(6), 'completed_at' => now()->subDays(6), 'accepted_at' => now()->subDays(6)]);

    $this->artisan('email:maintain-notifications')->assertSuccessful();
    $this->assertDatabaseCount('email_notifications', 1);
    $this->artisan('email:maintain-notifications')->assertSuccessful();
    expect(DB::table('email_notifications')->sole()->id)->toBe($recent);
});

it('recovers pending alerts beyond the first batch without requiring earlier markers to change', function (): void {
    Bus::fake([NotifyEmailDeliveryFailureJob::class]);

    foreach (range(1, 101) as $index) {
        maintenanceEmail(['failed_at' => now(), 'completed_at' => now()]);
    }

    $this->artisan('email:maintain-notifications')->assertSuccessful();

    Bus::assertDispatchedTimes(NotifyEmailDeliveryFailureJob::class, 101);
    expect(DB::table('email_notifications')->whereNull('notified_at')->count())->toBe(101);
});

it('continues the batch after one publication fails and logs no raw exception message', function (): void {
    $bad  = maintenanceEmail(['failed_at' => now(), 'completed_at' => now()]);
    $good = maintenanceEmail(['failed_at' => now(), 'completed_at' => now()]);
    Event::listen(JobQueueing::class, function (JobQueueing $event) use ($bad): void {
        if ($event->job instanceof NotifyEmailDeliveryFailureJob && $event->job->emailNotificationId === $bad) {
            throw new RuntimeException('MAINTENANCE_SECRET_SENTINEL');
        }
    });
    $log = Log::spy();

    $this->artisan('email:maintain-notifications')->assertFailed();

    $payload = json_decode(DB::table('jobs')->sole()->payload, true, flags: JSON_THROW_ON_ERROR);
    $job     = unserialize(Crypt::decrypt($payload['data']['command']));
    expect($job->emailNotificationId)->toBe($good);
    expect(DB::table('email_notifications')->where('id', $bad)->first()->failed_at)->not->toBeNull();
    $log->shouldHaveReceived('warning')->once()->with(Mockery::type('string'), Mockery::on(function (array $context): bool {
        expect(json_encode($context, JSON_THROW_ON_ERROR))->not->toContain('MAINTENANCE_SECRET_SENTINEL');

        return true;
    }));
});

it('does no work when another maintenance execution owns the native lock', function (): void {
    $id   = maintenanceEmail(['queued_at' => null, 'created_at' => now()->subHour()]);
    $lock = Cache::lock('email-maintenance:' . app()->environment(), 3600);
    expect($lock->get())->toBeTrue();

    try {
        $this->artisan('email:maintain-notifications')->assertSuccessful();
        expect(DB::table('email_notifications')->where('id', $id)->first()->completed_at)->toBeNull();
        $this->assertDatabaseCount('jobs', 0);
    } finally {
        $lock->release();
    }

    $this->artisan('email:maintain-notifications')->assertSuccessful();
    expect(DB::table('email_notifications')->where('id', $id)->first()->failed_at)->not->toBeNull();
});

it('rejects invalid retention without mutating records', function (): void {
    config(['mail.tracking_retention_days' => 0]);
    $id = maintenanceEmail(['queued_at' => null, 'created_at' => now()->subHour()]);

    $this->artisan('email:maintain-notifications')->assertFailed();

    expect(DB::table('email_notifications')->where('id', $id)->first()->completed_at)->toBeNull();
    $this->assertDatabaseCount('jobs', 0);
});

function maintenanceEmail(array $attributes = []): string
{
    $id = (string) Str::uuid();
    DB::table('email_notifications')->insert([
        'id'          => $id, 'notification_id' => (string) Str::uuid(), 'notification_type' => 'MaintenanceFixture',
        'environment' => 'testing', 'connection' => 'database', 'queue' => 'low_priority',
        'queued_at'   => now(), 'created_at' => now(), 'updated_at' => now(), ...$attributes,
    ]);

    return $id;
}
