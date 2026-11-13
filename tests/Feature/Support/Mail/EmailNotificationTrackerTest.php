<?php

declare(strict_types = 1);

use App\Jobs\NotifyEmailDeliveryFailureJob;
use App\Models\User;
use App\Support\QueueNames;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Events\NotificationSending;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\Events\JobQueueing;
use Illuminate\Queue\WorkerOptions;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Exceptions;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;

it('records confirmed publication and transport acceptance without recording secrets', function (string $mode): void {
    $this->freezeTime();
    $user = User::factory()->create(['email' => 'private-recipient@example.com']);
    publishTrackerMail($user, $mode);
    $record = DB::table('email_notifications')->sole();
    expect($record->queued_at)->not->toBeNull();
    expect($record->attempt_count)->toBe(0);
    expect($record->accepted_at)->toBeNull();

    processTrackerMail();

    $record = DB::table('email_notifications')->sole();
    expect($record->attempt_count)->toBe(1);
    expect($record->accepted_at)->not->toBeNull();
    expect($record->completed_at)->toBe($record->accepted_at);
    expect($record->failed_at)->toBeNull();
    expect(json_encode($record, JSON_THROW_ON_ERROR))->not->toContain('private-recipient@example.com', 'secret-token-sentinel', 'message-body-sentinel');
    Mail::raw('Unrelated message', fn ($message) => $message->to('other@example.com')->subject('Unrelated'));
    expect(DB::table('email_notifications')->sole()->attempt_count)->toBe(1);
})->with(['mail-message', 'mailable', 'nested-skip']);

it('does not confirm publication when enqueueing fails', function (): void {
    $user = User::factory()->create();
    Event::listen(JobQueueing::class, fn (): never => throw new RuntimeException('Queue unavailable'));

    expect(fn () => publishTrackerMail($user))->toThrow(RuntimeException::class, 'Queue unavailable');

    $record = DB::table('email_notifications')->sole();
    expect($record->queued_at)->toBeNull();
    expect($record->attempt_count)->toBe(0);
    $this->assertDatabaseCount('jobs', 0);
});

it('publishes after commit and leaves no record or job on rollback', function (): void {
    $user = User::factory()->create();
    expect(fn () => DB::transaction(function () use ($user): void {
        publishTrackerMail($user, afterCommit: true);
        expect(DB::table('email_notifications')->sole()->queued_at)->toBeNull();
        $this->assertDatabaseCount('jobs', 0);

        throw new RuntimeException('Rollback');
    }))->toThrow(RuntimeException::class, 'Rollback');
    $this->assertDatabaseCount('email_notifications', 0);
    DB::transaction(function () use ($user): void {
        publishTrackerMail($user, afterCommit: true);
        expect(DB::table('email_notifications')->sole()->queued_at)->toBeNull();
    });
    expect(DB::table('email_notifications')->sole()->queued_at)->not->toBeNull();
});

it('does not count pacing releases as transport attempts', function (): void {
    $this->travelTo(now()->startOfSecond());
    $user = User::factory()->create();
    publishTrackerMail($user);
    publishTrackerMail($user);
    processTrackerMail();
    processTrackerMail();

    $records = DB::table('email_notifications')->orderBy('attempt_count')->get();
    expect($records->pluck('attempt_count')->all())->toBe([0, 1]);
    expect($records->first()->completed_at)->toBeNull();
    $this->travel(1)->seconds();
    processTrackerMail();
    expect(DB::table('email_notifications')->whereNotNull('accepted_at')->count())->toBe(2);
    expect((int) DB::table('email_notifications')->sum('attempt_count'))->toBe(2);
});

it('records skipped channels without a transport attempt', function (string $mode): void {
    $user = User::factory()->create();

    if ($mode === 'notification-cancelled') {
        Event::listen(NotificationSending::class, fn (): bool => false);
    }

    if ($mode === 'message-cancelled') {
        Event::listen(MessageSending::class, fn (): bool => false);
    }

    publishTrackerMail($user, $mode);

    processTrackerMail();

    $record = DB::table('email_notifications')->sole();
    expect($record->attempt_count)->toBe(0);
    expect($record->skipped_at)->not->toBeNull();
    expect($record->accepted_at)->toBeNull();
    expect($record->failed_at)->toBeNull();
})->with(['skip', 'notification-cancelled', 'message-cancelled']);

it('records rendering failure without claiming a transport attempt', function (string $mode): void {
    Exceptions::fake();
    $user = User::factory()->create();
    publishTrackerMail($user, $mode);

    expect(fn () => processTrackerMail())->toThrow(RuntimeException::class);

    $record = DB::table('email_notifications')->sole();
    expect($record->attempt_count)->toBe(0);
    expect($record->last_failed_at)->not->toBeNull();
    expect($record->last_failure_type)->toBe(RuntimeException::class);
    expect($record->completed_at)->toBeNull();
    expect(json_encode($record, JSON_THROW_ON_ERROR))->not->toContain('secret-token-sentinel');
})->with(['render-error', 'nested-raw-error']);

it('counts real transport failures and records terminal queue failure', function (): void {
    Bus::fake([NotifyEmailDeliveryFailureJob::class]);
    $this->travelTo(now()->startOfSecond());
    Exceptions::fake();
    Mail::extend('tracker-failure', fn (): TrackerFailureTransport => new TrackerFailureTransport());
    config(['mail.mailers.tracker-failure' => ['transport' => 'tracker-failure']]);
    $user = User::factory()->create();
    publishTrackerMail($user, 'transport-error');

    foreach (range(1, 3) as $attempt) {
        processTrackerMail();
        expect(DB::table('email_notifications')->sole()->attempt_count)->toBe($attempt);
        $this->travel(30)->seconds();
    }

    $record = DB::table('email_notifications')->sole();
    expect($record->failed_at)->not->toBeNull();
    expect($record->completed_at)->toBe($record->failed_at);
    expect($record->accepted_at)->toBeNull();
    expect(json_encode($record, JSON_THROW_ON_ERROR))->not->toContain('secret-token-sentinel');
    $this->assertDatabaseCount('jobs', 0);
});

it('preserves technical acceptance if a later notification hook fails', function (): void {
    $this->travelTo(now()->startOfSecond());
    Exceptions::fake();
    $user = User::factory()->create();
    publishTrackerMail($user, 'after-error');

    processTrackerMail();

    $record = DB::table('email_notifications')->sole();
    expect($record->attempt_count)->toBe(1);
    expect($record->accepted_at)->not->toBeNull();
    expect($record->failed_at)->toBeNull();
    expect($record->last_failure_type)->toBeNull();
    $this->assertDatabaseCount('jobs', 0);
});

it('does not track synchronous notifications or other channels', function (): void {
    $user = User::factory()->create();
    $user->notify(new TrackerTestNotification('mail-message')->onConnection('sync')->onQueue('low_priority'));
    publishTrackerMail($user, 'database');
    processTrackerMail();

    $this->assertDatabaseCount('email_notifications', 0);
});

function publishTrackerMail(User $user, string $mode = 'mail-message', bool $afterCommit = false): void
{
    config(['queue.connections.database.connection' => config('database.default')]);
    $notification = new TrackerTestNotification($mode)->onConnection('database')->onQueue('low_priority');

    if ($afterCommit) {
        $notification->afterCommit();
    }

    $user->notify($notification);
}

function processTrackerMail(): void
{
    $job = Queue::connection('database')->pop(QueueNames::resolve('low_priority'));
    expect($job)->not->toBeNull();
    app('queue.worker')->setCache(Cache::store())->process('database', $job, new WorkerOptions(backoff: 1, maxTries: 1));
}

class TrackerTestNotification extends Notification implements ShouldQueue, ShouldBeEncrypted
{
    use Queueable;

    public string $token = 'secret-token-sentinel';

    public function __construct(public string $mode)
    {
    }

    public function via(User $notifiable): array
    {
        return $this->mode === 'database' ? ['database'] : ['mail'];
    }

    public function shouldSend(User $notifiable, string $channel): bool
    {
        return $this->mode !== 'skip';
    }

    public function toMail(User $notifiable): MailMessage | Mailable
    {
        if ($this->mode === 'nested-skip') {
            $notifiable->notifyNow(new self('skip'));
        }

        if ($this->mode === 'nested-raw-error') {
            Mail::raw('Unrelated mail', fn ($message) => $message->to('other@example.com')->subject('Unrelated'));
        }

        if (in_array($this->mode, ['render-error', 'nested-raw-error'], true)) {
            throw new RuntimeException('secret-token-sentinel');
        }

        if ($this->mode === 'mailable') {
            return new Mailable()->html('message-body-sentinel')->subject('Test')->to($notifiable->email);
        }

        $message = new MailMessage()->subject('Test')->line('message-body-sentinel');

        return $this->mode === 'transport-error' ? $message->mailer('tracker-failure') : $message;
    }

    public function toDatabase(User $notifiable): array
    {
        return ['message' => 'Other channel'];
    }

    public function afterSending(object $notifiable, string $channel, mixed $response): void
    {
        if ($this->mode === 'after-error') {
            throw new RuntimeException('secret-token-sentinel');
        }
    }
}

class TrackerFailureTransport extends AbstractTransport
{
    protected function doSend(SentMessage $message): void
    {
        throw new TransportException('secret-token-sentinel');
    }

    public function __toString(): string
    {
        return 'tracker-failure';
    }
}
