<?php

declare(strict_types = 1);

use App\Customs\CustomDispatcher;
use App\Enums\Queues;
use App\Support\QueueNames;
use Illuminate\Bus\Dispatcher;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\Queue;
use Illuminate\Queue\Attributes\Delay;
use Illuminate\Queue\Attributes\Queue as QueueAttribute;
use Mockery\MockInterface;

/** @return Queue&MockInterface */
function makeQueueMock(): Queue
{
    $queue = Mockery::mock(Queue::class);

    if (!$queue instanceof Queue) {
        throw new RuntimeException('Queue mock has an invalid type.');
    }

    return $queue;
}

function makeCustomDispatcher(Queue $queue): CustomDispatcher
{
    $dispatcher = new Dispatcher(app(), fn (): Queue => $queue);

    return new CustomDispatcher(app(), $dispatcher);
}

it('throws when queue is empty outside local', function (): void {
    app()->detectEnvironment(fn (): string => 'production');

    $command = new class () {
        public ?string $queue = null;
    };

    $queue = makeQueueMock();

    expect(fn (): mixed => makeCustomDispatcher($queue)->dispatchToQueue($command))
        ->toThrow(InvalidArgumentException::class, 'A fila não pode estar vazia. Você deve especificar uma fila nomeada.');
});

it('throws when queue is forbidden outside local', function (): void {
    app()->detectEnvironment(fn (): string => 'production');

    $command = new class ('default') {
        public function __construct(public ?string $queue)
        {
        }
    };

    $queue = makeQueueMock();

    expect(fn (): mixed => makeCustomDispatcher($queue)->dispatchToQueue($command))
        ->toThrow(InvalidArgumentException::class, "A fila 'default' não é permitida. Você deve especificar uma fila nomeada para todos os jobs.");
});

it('dispatches without prefix when queue should not be prefixed', function (): void {
    app()->detectEnvironment(fn (): string => 'production');
    config()->set('queue.prefix.allowed_queues', ['reports']);
    config()->set('queue.prefix.excluded_queues', ['emails']);
    config()->set('queue.prefix.value', 'app');

    $command = new class ('emails') {
        public function __construct(public ?string $queue)
        {
        }
    };

    $queue = makeQueueMock();
    $queue->shouldReceive('push')
        ->once()
        ->with($command, '', 'emails')
        ->andReturn('queued-no-prefix');

    $result = makeCustomDispatcher($queue)->dispatchToQueue($command);

    expect($result)->toBe('queued-no-prefix')
        ->and($command->queue)->toBe('emails');
});

it('prefixes queue and dispatches when queue is allowed', function (): void {
    app()->detectEnvironment(fn (): string => 'production');
    config()->set('queue.prefix.allowed_queues', ['emails']);
    config()->set('queue.prefix.excluded_queues', []);
    config()->set('queue.prefix.value', 'app');

    $command = new class ('emails') {
        public function __construct(public ?string $queue)
        {
        }
    };

    $queue = makeQueueMock();
    $queue->shouldReceive('push')
        ->once()
        ->with($command, '', 'app_production_emails')
        ->andReturn('queued-prefixed');

    $result = makeCustomDispatcher($queue)->dispatchToQueue($command);

    expect($result)->toBe('queued-prefixed')
        ->and($command->queue)->toBe('app_production_emails');
});

it('prefixes jobs with queue attribute enum and keeps prefixed queue on push', function (): void {
    app()->detectEnvironment(fn (): string => 'production');
    config()->set('queue.prefix.allowed_queues', ['high_priority']);
    config()->set('queue.prefix.excluded_queues', []);
    config()->set('queue.prefix.value', 'app');

    $command = new #[QueueAttribute(Queues::HighPriority)] class () {
        use Queueable;
    };

    $queue = makeQueueMock();
    $queue->shouldReceive('push')
        ->once()
        ->with($command, '', 'app_production_high_priority')
        ->andReturn('queued-prefixed-attribute');

    $result = makeCustomDispatcher($queue)->dispatchToQueue($command);

    expect($result)->toBe('queued-prefixed-attribute')
        ->and($command->queue)->toBe('app_production_high_priority');
});

it('dispatches with the original queue name when the prefix is empty', function (): void {
    app()->detectEnvironment(fn (): string => 'production');
    config()->set('queue.prefix.allowed_queues', ['*']);
    config()->set('queue.prefix.excluded_queues', []);
    config()->set('queue.prefix.value');

    $command = new class ('emails') {
        public function __construct(public ?string $queue)
        {
        }
    };

    $queue = makeQueueMock();
    $queue->shouldReceive('push')
        ->once()
        ->with($command, '', 'emails')
        ->andReturn('queued-without-prefix');

    $result = makeCustomDispatcher($queue)->dispatchToQueue($command);

    expect($result)->toBe('queued-without-prefix')
        ->and($command->queue)->toBe('emails');
});

it('evaluates shouldBePrefixed for empty, excluded and not allowed queues', function (): void {
    config()->set('queue.prefix.allowed_queues', ['reports']);
    config()->set('queue.prefix.excluded_queues', ['emails']);

    expect(QueueNames::shouldBePrefixed(null))->toBeFalse()
        ->and(QueueNames::shouldBePrefixed('emails'))->toBeFalse()
        ->and(QueueNames::shouldBePrefixed('invoices'))->toBeFalse();
});

it('uses queue later when prefixed queue and delay attribute are present', function (): void {
    app()->detectEnvironment(fn (): string => 'production');
    config()->set('queue.prefix.allowed_queues', ['emails']);
    config()->set('queue.prefix.excluded_queues', []);
    config()->set('queue.prefix.value', 'app');

    $command = new #[QueueAttribute('emails')] #[Delay(30)] class () {
        use Queueable;
    };

    $queue = makeQueueMock();
    $queue->shouldReceive('later')
        ->once()
        ->with(30, $command, '', 'app_production_emails')
        ->andReturn('queued-later');

    $result = makeCustomDispatcher($queue)->dispatchToQueue($command);

    expect($result)->toBe('queued-later')
        ->and($command->queue)->toBe('app_production_emails');
});

it('resolves queue name from pure enum using enum name branch', function (): void {
    enum TestQueueEnum
    {
        case Reports;
    }

    app()->detectEnvironment(fn (): string => 'production');
    config()->set('queue.prefix.allowed_queues', ['Reports']);
    config()->set('queue.prefix.excluded_queues', []);
    config()->set('queue.prefix.value', 'app');

    $command = new #[QueueAttribute(TestQueueEnum::Reports)] class () {
        use Queueable;
    };

    $queue = makeQueueMock();
    $queue->shouldReceive('push')
        ->once()
        ->with($command, '', 'app_production_Reports')
        ->andReturn('queued-enum-name');

    $result = makeCustomDispatcher($queue)->dispatchToQueue($command);

    expect($result)->toBe('queued-enum-name');
});

it('isolates queues on the local environment', function (): void {
    app()->detectEnvironment(fn (): string => 'local');

    $command = new class ('emails') {
        public function __construct(public ?string $queue)
        {
        }
    };

    $queue = makeQueueMock();
    $queue->shouldReceive('push')
        ->once()
        ->with($command, '', 'rsp-tests_local_emails')
        ->andReturn('queued-local');

    $result = makeCustomDispatcher($queue)->dispatchToQueue($command);

    expect($result)->toBe('queued-local');
});

it('returns null queue name for non object command via reflection', function (): void {
    $dispatcher = makeCustomDispatcher(makeQueueMock());
    $method     = new ReflectionMethod($dispatcher, 'resolveQueueName');

    expect($method->invoke($dispatcher, 'not-an-object'))->toBeNull();
});

it('resolves queue name from backed enum property value branch', function (): void {
    $dispatcher = makeCustomDispatcher(makeQueueMock());
    $method     = new ReflectionMethod($dispatcher, 'resolveQueueName');

    $command = new class () {
        public mixed $queue;

        public function __construct()
        {
            $this->queue = Queues::HighPriority;
        }
    };

    expect($method->invoke($dispatcher, $command))->toBe('high_priority');
});

it('rejects invalid queue values before publishing', function (mixed $value): void {
    $command = new class ($value) {
        public function __construct(public mixed $queue)
        {
        }
    };
    $queue = makeQueueMock();
    $queue->shouldNotReceive('push');
    $queue->shouldNotReceive('later');

    expect(fn (): mixed => makeCustomDispatcher($queue)->dispatchToQueue($command))
        ->toThrow(InvalidArgumentException::class, 'A fila não pode estar vazia');
})->with(['', '   ', 42, false]);

it('preserves a property delay while resolving a queue attribute', function (): void {
    $command = new #[QueueAttribute(Queues::LowPriority)] class () {
        use Queueable;
    };
    $command->delay(15);

    $queue = makeQueueMock();
    $queue->shouldReceive('later')->once()
        ->with(15, $command, '', 'rsp-tests_testing_low_priority')
        ->andReturn('delayed');

    expect(makeCustomDispatcher($queue)->dispatchToQueue($command))->toBe('delayed');
});

it('preserves mapped handlers for every native immediate dispatch entry point', function (string $method): void {
    $command = new stdClass();
    $handler = new class () {
        public int $calls = 0;

        public function handle(object $command): string
        {
            $this->calls++;

            return 'mapped handler';
        }
    };
    app()->instance($handler::class, $handler);
    $original = new Dispatcher(app());
    $original->map([$command::class => $handler::class]);

    $decorated = new CustomDispatcher(app(), $original);

    expect($decorated->{$method}($command))->toBe('mapped handler')
        ->and($handler->calls)->toBe(1);
})->with(['dispatch', 'dispatchSync', 'dispatchNow']);

it('keeps pipeline order and does not multiply middleware when decorating twice', function (): void {
    $command = new class () {
        public array $trace = [];

        public function handle(): string
        {
            $this->trace[] = 'handled';

            return 'done';
        }
    };
    $first = function (object $job, Closure $next): mixed {
        $job->trace[] = 'first before';
        $result       = $next($job);
        $job->trace[] = 'first after';

        return $result;
    };
    $second = function (object $job, Closure $next): mixed {
        $job->trace[] = 'second before';
        $result       = $next($job);
        $job->trace[] = 'second after';

        return $result;
    };
    $original = new Dispatcher(app());
    $original->pipeThrough([$first, $second]);

    $once  = new CustomDispatcher(app(), $original);
    $twice = new CustomDispatcher(app(), $once);

    expect($twice->dispatchSync($command))->toBe('done');
    expect($command->trace)->toBe(['first before', 'second before', 'handled', 'second after', 'first after']);

    $command->trace = [];
    $original->dispatchSync($command);
    expect($command->trace)->toBe(['first before', 'second before', 'handled', 'second after', 'first after']);
});

it('keeps an earlier middleware rejection instead of bypassing it', function (): void {
    $original = new Dispatcher(app());
    $original->pipeThrough([function (object $command, Closure $next): never {
        throw new RuntimeException('blocked by existing middleware');
    }]);
    $decorated = new CustomDispatcher(app(), $original);

    expect(fn (): mixed => $decorated->dispatchSync(new stdClass()))->toThrow(RuntimeException::class, 'blocked by existing middleware');
});

it('keeps the original queue resolver and concrete queue object', function (): void {
    $command = new class () {
        use Queueable;
    };
    $command->onQueue(Queues::LowPriority)->onConnection('special-connection');
    $queue = makeQueueMock();
    $queue->shouldReceive('push')->once()->with($command, '', 'rsp-tests_testing_low_priority')->andReturn('original queue');
    $resolved = [];
    $original = new Dispatcher(app(), function (?string $connection) use ($queue, &$resolved): mixed {
        $resolved[] = $connection;

        return $queue;
    });

    expect(new CustomDispatcher(app(), $original)->dispatchToQueue($command))->toBe('original queue');
    expect($resolved)->toBe(['special-connection']);
});
