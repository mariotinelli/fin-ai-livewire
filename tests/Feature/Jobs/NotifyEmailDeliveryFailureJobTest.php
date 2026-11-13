<?php

declare(strict_types = 1);

use App\Jobs\NotifyEmailDeliveryFailureJob;
use App\Models\User;
use App\Notifications\EmailDeliveryFailedNotification;
use App\Support\Alerts\DiscordAlert;
use App\Support\Alerts\DiscordAlertDeliveryException;
use App\Support\QueueNames;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Transport\ArrayTransport;
use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\WorkerOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Str;
use Symfony\Component\Mailer\Envelope;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mime\RawMessage;

beforeEach(function (): void {
    Http::preventStrayRequests();
    config(['alerts.discord.enabled' => false]);
});

it('deduplicates the internal and Discord channels and sends only safe technical data', function (): void {
    $requester = User::factory()->create(['email' => 'PRIVATE_EMAIL_SENTINEL@example.com']);
    $admin     = User::factory()->admin()->create();
    $id        = failureAlertRecord($requester->id);
    $url       = enableFailureAlertDiscord();
    Http::fake([$url => Http::response([], 204)]);
    $job = new NotifyEmailDeliveryFailureJob($id);

    $job->handle(app(DiscordAlert::class));
    $job->handle(app(DiscordAlert::class));

    expect($requester->notifications()->count())->toBe(1);
    expect($admin->notifications()->count())->toBe(0);
    expect(DB::table('email_notifications')->sole()->notified_at)->not->toBeNull();
    expect(DB::table('email_notifications')->sole()->discord_notified_at)->not->toBeNull();
    Http::assertSentCount(1);
    Http::assertSent(function ($request) use ($id): bool {
        $payload = json_encode($request->data(), JSON_THROW_ON_ERROR);
        expect($payload)->toContain($id)->not->toContain('PRIVATE_EMAIL_SENTINEL', 'SECRET_FAILURE_SENTINEL', 'WEBHOOK_SECRET_SENTINEL');

        return true;
    });
});

it('falls back to active administrators when the requester is absent or deactivated', function (bool $deactivated): void {
    $admin        = User::factory()->admin()->create();
    $deletedAdmin = User::factory()->admin()->create();
    $deletedAdmin->delete();

    $requester = User::factory()->user()->create();
    $id        = failureAlertRecord($deactivated ? $requester->id : null);

    if ($deactivated) {
        $requester->delete();
    }

    config(['alerts.discord.enabled' => false]);

    new NotifyEmailDeliveryFailureJob($id)->handle(app(DiscordAlert::class));

    expect($admin->notifications()->count())->toBe(1);
    expect($requester->notifications()->count())->toBe(0);
    expect($deletedAdmin->notifications()->count())->toBe(0);
    expect(DB::table('email_notifications')->sole()->discord_notified_at)->toBeNull();
    Http::assertNothingSent();
})->with([false, true]);

it('does not alert for a pending recovered skipped uncertain or missing record', function (string $state): void {
    $admin = User::factory()->admin()->create();
    $id    = failureAlertRecord(null, $state);

    if ($state === 'missing') {
        DB::table('email_notifications')->delete();
    }

    $url = enableFailureAlertDiscord();
    Http::fake([$url => Http::response([], 204)]);

    new NotifyEmailDeliveryFailureJob($id)->handle(app(DiscordAlert::class));

    expect($admin->notifications()->count())->toBe(0);
    Http::assertNothingSent();
})->with(['pending', 'accepted', 'skipped', 'uncertain', 'missing']);

it('keeps the internal notice and original failure when Discord fails and retries without duplicate notices', function (): void {
    $this->travelTo(now()->startOfSecond());
    $requester = User::factory()->create();
    $id        = failureAlertRecord($requester->id);
    $url       = enableFailureAlertDiscord();
    Http::fake([$url => Http::sequence()->push([], 500)->push([], 204)]);
    config(['queue.connections.database.connection' => config('database.default')]);
    NotifyEmailDeliveryFailureJob::dispatch($id)->onConnection('database');

    try {
        processFailureAlertJob('high_priority');
        $this->fail('Expected a sanitized delivery error.');
    } catch (DiscordAlertDeliveryException $discordAlertDeliveryException) {
        expect($discordAlertDeliveryException->getMessage())->not->toContain($url, 'WEBHOOK_SECRET_SENTINEL');
        expect($discordAlertDeliveryException->getPrevious())->toBeNull();
        expect($discordAlertDeliveryException->getCode())->toBe(500);
    }

    $record = DB::table('email_notifications')->sole();
    expect($record->failed_at)->not->toBeNull();
    expect($record->accepted_at)->toBeNull();
    expect($record->notified_at)->not->toBeNull();
    expect($record->discord_notified_at)->toBeNull();
    expect($requester->notifications()->count())->toBe(1);
    expect(Queue::connection('database')->size(QueueNames::resolve('low_priority')))->toBe(0);
    $this->travel(10)->seconds();
    processFailureAlertJob('high_priority');
    expect($requester->notifications()->count())->toBe(1);
    expect(DB::table('email_notifications')->sole()->discord_notified_at)->not->toBeNull();
    Http::assertSentCount(2);
    $this->assertDatabaseCount('jobs', 0);
});

it('dispatches one separate job after a confirmed terminal failure and preserves requester correlation', function (): void {
    $actor = User::factory()->create();
    Auth::login($actor);
    config(['queue.connections.database.connection' => config('database.default')]);
    $user = User::factory()->create();
    $user->notify(new FailureAlertTestMail()->onConnection('database')->onQueue('low_priority'));

    $original  = Queue::connection('database')->pop(QueueNames::resolve('low_priority'));
    $exception = new RuntimeException('SECRET_FAILURE_SENTINEL');

    $original->fail($exception);
    Event::dispatch(new JobFailed('database', $original, $exception));

    expect(DB::table('email_notifications')->sole()->requester_id)->toBe($actor->id);
    expect(DB::table('email_notifications')->sole()->failed_at)->not->toBeNull();
    expect(Queue::connection('database')->size(QueueNames::resolve('high_priority')))->toBe(1);
    expect($actor->notifications()->count())->toBe(0);
    config(['alerts.discord.enabled' => false]);
    processFailureAlertJob('high_priority');
    expect($actor->notifications()->count())->toBe(1);
    $this->assertDatabaseCount('jobs', 0);
});

it('does not alert when a transient transport failure recovers', function (): void {
    $this->travelTo(now()->startOfSecond());
    $url = enableFailureAlertDiscord();
    Http::fake([$url => Http::response([], 204)]);
    $transport = new FailureAlertTestTransport();
    Mail::extend('failure-alert-test', fn (): FailureAlertTestTransport => $transport);
    config(['mail.default' => 'failure-alert-test', 'mail.mailers.failure-alert-test' => ['transport' => 'failure-alert-test'], 'queue.connections.database.connection' => config('database.default')]);
    User::factory()->admin()->create();
    User::factory()->create()->notify(new FailureAlertTestMail()->onConnection('database')->onQueue('low_priority'));

    processFailureAlertJob('low_priority');
    $this->travel(10)->seconds();
    processFailureAlertJob('low_priority');

    expect($transport->calls)->toBe(2);
    expect(DB::table('email_notifications')->sole()->accepted_at)->not->toBeNull();
    expect(DB::table('email_notifications')->sole()->notified_at)->toBeNull();
    $this->assertDatabaseCount('notifications', 0);
    $this->assertDatabaseCount('jobs', 0);
    Http::assertNothingSent();
});

it('does not expose webhook credentials when logging an exhausted alert', function (): void {
    $url = enableFailureAlertDiscord();
    $log = Log::spy();
    new NotifyEmailDeliveryFailureJob((string) Str::uuid())->failed(new RuntimeException('POST ' . $url));

    $log->shouldHaveReceived('error')->once()->with(Mockery::type('string'), Mockery::on(function (array $context) use ($url): bool {
        expect(json_encode($context, JSON_THROW_ON_ERROR))->not->toContain($url, 'WEBHOOK_SECRET_SENTINEL');
        expect($context['exception'])->toBe(RuntimeException::class);

        return true;
    }));
});

it('rolls back internal notices and their deduplication marker together', function (): void {
    $requester    = User::factory()->create();
    $id           = failureAlertRecord($requester->id);
    $failureState = new class () {
        public bool $enabled = true;
    };
    Event::listen(NotificationSent::class, function (NotificationSent $event) use ($failureState): void {
        if ($failureState->enabled && $event->notification instanceof EmailDeliveryFailedNotification) {
            throw new RuntimeException('Notification storage hook failed');
        }
    });
    $job = new NotifyEmailDeliveryFailureJob($id);

    expect(fn () => $job->handle(app(DiscordAlert::class)))->toThrow(RuntimeException::class);

    expect($requester->notifications()->count())->toBe(0);
    expect(DB::table('email_notifications')->sole()->notified_at)->toBeNull();
    expect(DB::table('email_notifications')->sole()->failed_at)->not->toBeNull();

    $failureState->enabled = false;
    $job->handle(app(DiscordAlert::class));
    expect($requester->notifications()->count())->toBe(1);
    expect(DB::table('email_notifications')->sole()->notified_at)->not->toBeNull();
});

it('does not publish an alert for a rolled back failure transition', function (): void {
    Bus::fake([NotifyEmailDeliveryFailureJob::class]);
    config(['queue.connections.database.connection' => config('database.default')]);
    User::factory()->create()->notify(new FailureAlertTestMail()->onConnection('database')->onQueue('low_priority'));
    $original = Queue::connection('database')->pop(QueueNames::resolve('low_priority'));

    expect(fn () => DB::transaction(function () use ($original): void {
        $original->fail(new RuntimeException('Transport failed'));
        Bus::assertNotDispatched(NotifyEmailDeliveryFailureJob::class);

        throw new RuntimeException('Rollback failure');
    }))->toThrow(RuntimeException::class, 'Rollback failure');

    expect(DB::table('email_notifications')->sole()->failed_at)->toBeNull();
    Bus::assertNotDispatched(NotifyEmailDeliveryFailureJob::class);
});

it('preserves terminal failure if publishing the separate alert job fails', function (): void {
    config(['queue.connections.database.connection' => config('database.default')]);
    User::factory()->create()->notify(new FailureAlertTestMail()->onConnection('database')->onQueue('low_priority'));
    $original = Queue::connection('database')->pop(QueueNames::resolve('low_priority'));
    Bus::partialMock()->shouldReceive('dispatch')->with(Mockery::type(NotifyEmailDeliveryFailureJob::class))->once()
        ->andThrow(new RuntimeException('WEBHOOK_SECRET_SENTINEL'));
    $log = Log::spy();

    $original->fail(new RuntimeException('Transport failed'));

    expect(DB::table('email_notifications')->sole()->failed_at)->not->toBeNull();
    expect(DB::table('email_notifications')->sole()->notified_at)->toBeNull();
    $this->assertDatabaseCount('jobs', 0);
    $log->shouldHaveReceived('error')->once()->with(Mockery::type('string'), Mockery::on(function (array $context): bool {
        expect(json_encode($context, JSON_THROW_ON_ERROR))->not->toContain('WEBHOOK_SECRET_SENTINEL');

        return true;
    }));
});

function failureAlertRecord(?int $requester = null, string $state = 'failed'): string
{
    $id = (string) Str::uuid();
    DB::table('email_notifications')->insert([
        'id'                => $id, 'notification_id' => (string) Str::uuid(), 'notification_type' => FailureAlertTestMail::class,
        'environment'       => 'testing', 'connection' => 'database', 'queue' => 'low_priority',
        'attempt_count'     => 3, 'requester_id' => $requester,
        'failed_at'         => $state === 'failed' ? now() : null,
        'accepted_at'       => $state === 'accepted' ? now() : null,
        'skipped_at'        => $state === 'skipped' ? now() : null,
        'uncertain_at'      => $state === 'uncertain' ? now() : null,
        'completed_at'      => $state === 'pending' ? null : now(),
        'last_failure_type' => 'SECRET_FAILURE_SENTINEL', 'created_at' => now(), 'updated_at' => now(),
    ]);

    return $id;
}

function enableFailureAlertDiscord(): string
{
    $url = 'https://discord.test/api/webhooks/123/WEBHOOK_SECRET_SENTINEL';
    config(['alerts.discord.enabled' => true, 'alerts.discord.webhook_url' => $url, 'alerts.discord.retry_times' => 1, 'alerts.discord.retry_sleep_ms' => 0]);

    return $url;
}

function processFailureAlertJob(string $queue): void
{
    $job = Queue::connection('database')->pop(QueueNames::resolve($queue));
    expect($job)->not->toBeNull();
    app('queue.worker')->setCache(Cache::store())->process('database', $job, new WorkerOptions(backoff: 1, maxTries: 1));
}

class FailureAlertTestMail extends Notification implements ShouldQueue, ShouldBeEncrypted
{
    use Queueable;

    public function via(User $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(User $notifiable): MailMessage
    {
        return new MailMessage()->subject('Test')->line('PRIVATE_BODY_SENTINEL');
    }
}

class FailureAlertTestTransport extends ArrayTransport
{
    public int $calls = 0;

    public function send(RawMessage $message, ?Envelope $envelope = null): ?SentMessage
    {
        if (++$this->calls === 1) {
            throw new TransportException('Temporary transport failure');
        }

        return parent::send($message, $envelope);
    }
}
