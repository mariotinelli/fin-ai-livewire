<?php

declare(strict_types = 1);

use App\Customs\CustomDispatcher;
use App\Enums\Queues;
use App\Models\User;
use App\Notifications\NewPasswordNotification;
use App\Providers\AppServiceProvider;
use App\Providers\QueueServiceProvider;
use App\Support\QueueNames;
use Illuminate\Bus\Dispatcher;
use Illuminate\Bus\Queueable;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\DevCommands;
use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\Attributes\MaxExceptions;
use Illuminate\Queue\Attributes\Queue as QueueAttribute;
use Illuminate\Queue\Events\JobExceptionOccurred;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\WorkerOptions;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Exceptions;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Testing\Fakes\QueueFake;

it('aligns the native worker with every published application queue', function (string $environment, string $prefix): void {
    app()->detectEnvironment(fn (): string => $environment);
    config()->set('queue.prefix.value', $prefix);
    new AppServiceProvider(app())->boot();

    $command    = collect(DevCommands::commands())->firstWhere('name', 'queue');
    $consumed   = explode(',', str($command['command'])->after('--queue=')->before(' ')->toString());
    $fake       = new QueueFake(app());
    $dispatcher = new CustomDispatcher(app(), new Dispatcher(app(), fn (): QueueFake => $fake));

    foreach (Queues::cases() as $logicalQueue) {
        $job = new #[QueueAttribute(Queues::HighPriority)] class () {
            use Queueable;
        };
        $job->onQueue($logicalQueue);
        $dispatcher->dispatchToQueue($job);
        $dispatcher->dispatchToQueue($job);

        $expected = $prefix === '' ? $logicalQueue->value : "{$prefix}_{$environment}_{$logicalQueue->value}";
        $fake->assertPushedOn($expected, $job::class);
        expect($consumed)->toContain($expected);
    }
})->with(['production', 'prod', 'qa', 'homolog', 'hml', 'local', 'testing'])->with(['', 'alpha']);

it('aligns local producers and consumers with the optional environment prefix', function (?string $prefix, string $namespace): void {
    $originalEnv     = $_ENV['QUEUE_PREFIX'] ?? null;
    $originalServer  = $_SERVER['QUEUE_PREFIX'] ?? null;
    $originalProcess = getenv('QUEUE_PREFIX');
    unset($_ENV['QUEUE_PREFIX'], $_SERVER['QUEUE_PREFIX']);
    putenv('QUEUE_PREFIX');

    try {
        if ($prefix !== null) {
            $_ENV['QUEUE_PREFIX']    = $prefix;
            $_SERVER['QUEUE_PREFIX'] = $prefix;
        }

        app()->detectEnvironment(fn (): string => 'local');
        config()->set('queue', require base_path('config/queue.php'));
        config()->set('app.sail.enabled', false);

        expect(config('queue.prefix.value'))->toBe($prefix);

        new QueueServiceProvider(app())->boot();
        new AppServiceProvider(app())->boot();

        $command    = collect(DevCommands::commands())->firstWhere('name', 'queue');
        $fake       = new QueueFake(app());
        $dispatcher = new CustomDispatcher(app(), new Dispatcher(app(), fn (): QueueFake => $fake));

        foreach (Queues::cases() as $logicalQueue) {
            $job = new class () {
                use Queueable;
            };
            $job->onQueue($logicalQueue);
            $dispatcher->dispatchToQueue($job);

            $expected = $namespace . $logicalQueue->value;
            $fake->assertPushedOn($expected, $job::class);
        }

        expect($command['command'])->toContain("--queue={$namespace}low_priority,{$namespace}high_priority,{$namespace}long_timeout");
        $fake->assertCount(3);
    } finally {
        unset($_ENV['QUEUE_PREFIX'], $_SERVER['QUEUE_PREFIX']);

        if ($originalEnv !== null) {
            $_ENV['QUEUE_PREFIX'] = $originalEnv;
        }

        if ($originalServer !== null) {
            $_SERVER['QUEUE_PREFIX'] = $originalServer;
        }

        putenv($originalProcess === false ? 'QUEUE_PREFIX' : 'QUEUE_PREFIX=' . $originalProcess);
    }
})->with([
    'absent variable' => [null, ''],
    'empty variable'  => ['', ''],
    'explicit prefix' => ['alpha', 'alpha_local_'],
]);

it('preserves an already decorated dispatcher and rejects invalid dispatchers', function (): void {
    $provider  = new QueueServiceProvider(app());
    $method    = new ReflectionMethod($provider, 'decorateDispatcher');
    $decorated = new CustomDispatcher(app(), new Dispatcher(app()));

    expect($method->invoke($provider, $decorated, app()))->toBe($decorated)
        ->and(fn (): mixed => $method->invoke($provider, new stdClass(), app()))
        ->toThrow(RuntimeException::class, 'Queue dispatcher precisa ser');
});

it('paces queued notifications without their own middleware and survives repeated releases', function (): void {
    $this->travelTo(now()->startOfSecond());
    Event::fake([NotificationSent::class]);
    $user = User::factory()->create();
    publishProviderTestNotification($user);
    publishProviderTestNotification($user);
    processProviderTestJob('low_priority');
    processProviderTestJob('low_priority');
    Event::assertDispatchedTimes(NotificationSent::class, 1);
    $this->assertDatabaseCount('jobs', 1);

    foreach (range(1, 4) as $attempt) {
        $this->travel(1)->seconds();
        publishProviderTestNotification($user, queue: 'high_priority');
        processProviderTestJob('high_priority');
        processProviderTestJob('low_priority');
    }

    expect(DB::table('jobs')->sole()->attempts)->toBe(5);
    Event::assertDispatchedTimes(NotificationSent::class, 5);
    $this->travel(1)->seconds();
    processProviderTestJob('low_priority');
    Event::assertDispatchedTimes(NotificationSent::class, 6);
    $this->assertDatabaseCount('jobs', 0);
});

it('keeps non-mail notifications and synchronous delivery outside central pacing', function (): void {
    $this->freezeTime();
    Event::fake([NotificationSent::class]);
    $user = User::factory()->create();
    publishProviderTestNotification($user, ['database']);
    $payload = json_decode(DB::table('jobs')->sole()->payload, true, flags: JSON_THROW_ON_ERROR);
    expect($payload['retryUntil'])->toBeNull();
    expect($payload['maxExceptions'])->toBeNull();
    processProviderTestJob('low_priority');
    publishProviderTestNotification($user, ['database']);
    processProviderTestJob('low_priority');

    foreach (range(1, 2) as $attempt) {
        $user->notify(new QueueProviderTestNotification(['mail'])->onConnection('sync')->onQueue('low_priority'));
    }

    Event::assertDispatchedTimes(NotificationSent::class, 4);
    $this->assertDatabaseCount('jobs', 0);
});

it('defers delivery through native worker backoff when the limiter cache is unavailable', function (): void {
    $this->freezeTime();
    Event::fake([NotificationSent::class, JobExceptionOccurred::class]);
    Exceptions::fake();
    $user = User::factory()->create();
    publishProviderTestNotification($user);
    RateLimiter::shouldReceive('limiter')->with('outgoing-mail')->once()->andReturn(fn (): Limit => Limit::perSecond(1));
    RateLimiter::shouldReceive('tooManyAttempts')->once()->andThrow(new RuntimeException('Limiter unavailable'));

    expect(fn () => processProviderTestJob('low_priority'))->toThrow(RuntimeException::class, 'Limiter unavailable');

    Event::assertNotDispatched(NotificationSent::class);
    Event::assertDispatched(JobExceptionOccurred::class);
    $record = DB::table('jobs')->sole();
    expect($record->available_at)->toBeGreaterThan(now()->timestamp);
    expect($record->reserved_at)->toBeNull();
});

it('does not duplicate the application middleware or change explicit delivery deadlines', function (): void {
    $this->freezeTime();
    $user         = User::factory()->create();
    $notification = new NewPasswordNotification('reset');
    $user->notify($notification->onConnection('database'));
    $payload = json_decode(DB::table('jobs')->sole()->payload, true, flags: JSON_THROW_ON_ERROR);
    $job     = unserialize(Crypt::decrypt($payload['data']['command']));

    expect($job->middleware)->toHaveCount(2);
    expect($payload['retryUntil'])->toBeNull();
    expect($payload['maxTries'])->toBe(0);
    expect($payload['maxExceptions'])->toBe(3);
});

it('preserves additional middleware and explicit retry policies', function (): void {
    $this->freezeTime();
    config(['queue.connections.database.connection' => config('database.default')]);
    $user = User::factory()->create();
    $user->notify(new QueueProviderDeadlineNotification(['mail'])
        ->onConnection('database')->onQueue('low_priority')
        ->through([new WithoutOverlapping('external-service')]));
    $payload = json_decode(DB::table('jobs')->sole()->payload, true, flags: JSON_THROW_ON_ERROR);
    $job     = unserialize($payload['data']['command']);

    expect($job->middleware)->toHaveCount(3);
    expect($job->middleware[0])->toBeInstanceOf(WithoutOverlapping::class);
    expect($payload['retryUntil'])->toBe(now()->addMinutes(10)->timestamp);
    expect($payload['maxExceptions'])->toBe(7);
});

it('does not add mail pacing to unrelated queued jobs', function (): void {
    config(['queue.connections.database.connection' => config('database.default')]);
    Queue::connection('database')->push(new QueueProviderOtherJob(), queue: 'high_priority');
    $payload = json_decode(DB::table('jobs')->sole()->payload, true, flags: JSON_THROW_ON_ERROR);
    expect($payload['data']['command'])->toContain('NON_SENSITIVE_JOB_SENTINEL_RSP174');
    $job = unserialize($payload['data']['command']);

    expect($job->middleware)->toBe([]);
    expect($payload['retryUntil'])->toBeNull();
    expect($payload['maxExceptions'])->toBeNull();
});

function publishProviderTestNotification(User $user, array $channels = ['mail'], string $queue = 'low_priority'): void
{
    config(['queue.connections.database.connection' => config('database.default')]);
    $user->notify(new QueueProviderTestNotification($channels)->onConnection('database')->onQueue($queue));
}

function processProviderTestJob(string $queue): void
{
    $job = Queue::connection('database')->pop(QueueNames::resolve($queue));
    expect($job)->not->toBeNull();
    app('queue.worker')->process('database', $job, new WorkerOptions(backoff: 1, maxTries: 1));
}

class QueueProviderTestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public array $channels)
    {
    }

    public function via(User $notifiable): array
    {
        return $this->channels;
    }

    public function toMail(User $notifiable): MailMessage
    {
        return new MailMessage()->subject('Pacing test')->line('Queued delivery');
    }

    public function toDatabase(User $notifiable): array
    {
        return ['message' => 'Queued delivery'];
    }
}

#[MaxExceptions(7)]
class QueueProviderDeadlineNotification extends QueueProviderTestNotification
{
    public function retryUntil(): Carbon
    {
        return now()->addMinutes(10);
    }
}

class QueueProviderOtherJob implements ShouldQueue
{
    use Queueable;

    public string $marker = 'NON_SENSITIVE_JOB_SENTINEL_RSP174';

    public function handle(): void
    {
    }
}
