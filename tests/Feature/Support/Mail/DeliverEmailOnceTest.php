<?php

declare(strict_types = 1);

use App\Jobs\NotifyEmailDeliveryFailureJob;
use App\Models\User;
use App\Support\Mail\DeliverEmailOnce;
use App\Support\QueueNames;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\Attributes\Backoff;
use Illuminate\Queue\Attributes\MaxExceptions;
use Illuminate\Queue\MaxAttemptsExceededException;
use Illuminate\Queue\WorkerOptions;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Exceptions;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;

it('never resends an accepted message when a later hook fails or the payload is replayed', function (): void {
    $this->freezeTime();
    Exceptions::fake();
    $transport = useDeliveryTestTransport();
    $payload   = publishDeliveryTestMail(afterError: true);

    processDeliveryTestMail();

    expect($transport->calls)->toBe(1);
    $record = DB::table('email_notifications')->sole();
    expect($record->accepted_at)->not->toBeNull();
    expect($record->failed_at)->toBeNull();
    $this->assertDatabaseCount('jobs', 0);
    Queue::connection('database')->pushRaw($payload, QueueNames::resolve('low_priority'));
    $this->travel(1)->seconds();
    processDeliveryTestMail();
    expect($transport->calls)->toBe(1);
    expect(DB::table('email_notifications')->sole()->attempt_count)->toBe(1);
    $this->assertDatabaseCount('jobs', 0);
});

it('retries a transient failure after the configured backoff and then accepts the message', function (): void {
    $this->freezeTime();
    Exceptions::fake();
    $transport = useDeliveryTestTransport(1);
    publishDeliveryTestMail();

    processDeliveryTestMail();

    expect($transport->calls)->toBe(1);
    expect(DB::table('jobs')->sole()->available_at)->toBe(now()->addSeconds(10)->timestamp);
    expect(DB::table('email_notifications')->sole()->processing_started_at)->toBeNull();
    $this->travel(10)->seconds();
    processDeliveryTestMail();
    expect($transport->calls)->toBe(2);
    expect(DB::table('email_notifications')->sole()->attempt_count)->toBe(2);
    expect(DB::table('email_notifications')->sole()->accepted_at)->not->toBeNull();
    $this->assertDatabaseCount('jobs', 0);
});

it('waits for the native reservation and limits real attempts independently of queue attempts', function (): void {
    Bus::fake([NotifyEmailDeliveryFailureJob::class]);
    $this->travelTo(now()->startOfSecond());
    Exceptions::fake();
    $transport  = useDeliveryTestTransport(10);
    $payload    = publishDeliveryTestMail();
    $data       = json_decode($payload, true, flags: JSON_THROW_ON_ERROR);
    $command    = unserialize(Crypt::decrypt($data['data']['command']));
    $middleware = $command->middleware['email-delivery'];
    expect($middleware)->toBeInstanceOf(DeliverEmailOnce::class);
    $lock = Cache::lock($middleware->getLockKey($command), 120);
    expect($lock->get())->toBeTrue();

    try {
        foreach (range(1, 5) as $attempt) {
            processDeliveryTestMail();
            $this->travel(1)->seconds();
        }

        expect($transport->calls)->toBe(0);
        expect(DB::table('email_notifications')->sole()->attempt_count)->toBe(0);
    } finally {
        $lock->release();
    }

    foreach ([10, 30, null] as $index => $delay) {
        processDeliveryTestMail();
        expect($transport->calls)->toBe($index + 1);

        if ($delay !== null) {
            expect(DB::table('jobs')->sole()->available_at)->toBe(now()->addSeconds($delay)->timestamp);
            $this->travel($delay)->seconds();
        }
    }

    $record = DB::table('email_notifications')->sole();
    expect($record->attempt_count)->toBe(3);
    expect($record->failed_at)->not->toBeNull();
    expect($record->accepted_at)->toBeNull();
    expect($record->processing_started_at)->toBeNull();
    $this->assertDatabaseCount('jobs', 0);
});

it('keeps an interrupted delivery uncertain instead of replaying it or claiming success', function (bool $expired): void {
    Exceptions::fake();
    $transport = useDeliveryTestTransport();
    $payload   = publishDeliveryTestMail();
    DB::table('email_notifications')->update(['processing_started_at' => now()->subMinutes(3), 'attempt_count' => 1]);

    if ($expired) {
        $data               = json_decode($payload, true, flags: JSON_THROW_ON_ERROR);
        $data['retryUntil'] = now()->subSecond()->timestamp;
        DB::table('jobs')->update(['payload' => json_encode($data, JSON_THROW_ON_ERROR)]);
        expect(fn () => processDeliveryTestMail())->toThrow(MaxAttemptsExceededException::class);
    } else {
        processDeliveryTestMail();
    }

    $record = DB::table('email_notifications')->sole();
    expect($transport->calls)->toBe(0);
    expect($record->uncertain_at)->not->toBeNull();
    expect($record->accepted_at)->toBeNull();
    expect($record->failed_at)->toBeNull();
    Queue::connection('database')->pushRaw($payload, QueueNames::resolve('low_priority'));
    processDeliveryTestMail();
    expect($transport->calls)->toBe(0);
    $this->assertDatabaseCount('jobs', 0);
})->with(['orphaned processing' => [false], 'expired retry deadline' => [true]]);

it('fails closed when the tracking record is missing', function (): void {
    Exceptions::fake();
    $transport = useDeliveryTestTransport();
    publishDeliveryTestMail();
    DB::table('email_notifications')->delete();

    expect(fn () => processDeliveryTestMail())->toThrow(RuntimeException::class);

    expect($transport->calls)->toBe(0);
    $this->assertDatabaseCount('jobs', 1);
});

it('does not call the transport when an existing record already exhausted its real attempts', function (): void {
    Bus::fake([NotifyEmailDeliveryFailureJob::class]);
    $transport = useDeliveryTestTransport();
    publishDeliveryTestMail();
    DB::table('email_notifications')->update(['attempt_count' => 3]);

    processDeliveryTestMail();

    expect($transport->calls)->toBe(0);
    expect(DB::table('email_notifications')->sole()->failed_at)->not->toBeNull();
    $this->assertDatabaseCount('jobs', 0);
});

function useDeliveryTestTransport(int $failures = 0): DeliveryTestTransport
{
    $transport = new DeliveryTestTransport($failures);
    Mail::extend('delivery-test', fn (): DeliveryTestTransport => $transport);
    config(['mail.mailers.delivery-test' => ['transport' => 'delivery-test']]);

    return $transport;
}

function publishDeliveryTestMail(bool $afterError = false): string
{
    config(['queue.connections.database.connection' => config('database.default')]);
    User::factory()->create()->notify(new DeliveryTestNotification($afterError)->onConnection('database')->onQueue('low_priority'));

    return DB::table('jobs')->sole()->payload;
}

function processDeliveryTestMail(): void
{
    $job = Queue::connection('database')->pop(QueueNames::resolve('low_priority'));
    expect($job)->not->toBeNull();
    app('queue.worker')->setCache(Cache::store())->process('database', $job, new WorkerOptions(backoff: 1, maxTries: 1));
}

#[Backoff([10, 30, 60])]
#[MaxExceptions(9)]
class DeliveryTestNotification extends Notification implements ShouldQueue, ShouldBeEncrypted
{
    use Queueable;

    public function __construct(public bool $afterError)
    {
    }

    public function via(User $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(User $notifiable): MailMessage
    {
        return new MailMessage()->mailer('delivery-test')->subject('Delivery test')->line('Message');
    }

    public function afterSending(object $notifiable, string $channel, mixed $response): void
    {
        if ($this->afterError) {
            throw new RuntimeException('Post-acceptance hook failed');
        }
    }
}

class DeliveryTestTransport extends AbstractTransport
{
    public int $calls = 0;

    public function __construct(private readonly int $failures)
    {
        parent::__construct();
    }

    protected function doSend(SentMessage $message): void
    {
        $this->calls++;

        if ($this->calls <= $this->failures) {
            throw new TransportException('Temporary transport failure');
        }
    }

    public function __toString(): string
    {
        return 'delivery-test';
    }
}
