<?php

declare(strict_types = 1);

use App\Enums\CommandExecutionStatuses;
use App\Enums\TypeUsers;
use App\Jobs\ExecuteArtisanCommandJob;
use App\Models\CommandExecution;
use App\Models\User;
use Illuminate\Contracts\Queue\Queue as QueueContract;
use Illuminate\Events\CallQueuedListener;
use Illuminate\Process\PendingProcess;
use Illuminate\Queue\DatabaseQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Queue;

beforeEach(function (): void {
    config()->set('artisan-executor.allowed_ips', ['127.0.0.1']);
});

it('publishes a bounded job with one attempt and definitive failure on timeout', function (): void {
    $execution = CommandExecution::factory()->for(User::factory()->state(['type' => TypeUsers::SupportRemSoft]), 'user')->create();
    $queue     = new DatabaseQueue(DB::connection(), 'jobs', 'rsp30-executor');
    $queue->setContainer(app());

    $enqueue = static fn (QueueContract $queue, object $job): mixed => $queue->push($job);
    $enqueue($queue, new ExecuteArtisanCommandJob(commandExecutionId: $execution->id));

    $reserved = $queue->pop();
    $payload  = $reserved->payload();

    expect($payload['timeout'])->toBe(150)
        ->toBeGreaterThan(config('artisan-executor.timeout'))
        ->toBeLessThan(config('queue.connections.database.retry_after'))
        ->toBeLessThan(config('queue.connections.redis.retry_after'));
    expect($payload['maxTries'])->toBe(1);
    expect($payload['failOnTimeout'])->toBeTrue();
});

it('keeps the spawned process below the queued job deadline even after runtime overrides', function (int $configured, int $expectedTimeout): void {
    $execution = CommandExecution::factory()->for(User::factory()->state(['type' => TypeUsers::SupportRemSoft]), 'user')->create(['command' => 'about', 'ip_address' => '127.0.0.1']);
    config()->set('artisan-executor.timeout', $configured);
    config()->set('artisan-executor.php_binary', 'php');
    Process::fake();

    ExecuteArtisanCommandJob::dispatchSync(commandExecutionId: $execution->id);

    Process::assertRanInOrder([
        fn (PendingProcess $process): bool => $process->command === ['php', 'artisan', 'about', '--no-interaction', '--no-ansi']
            && $process->path === base_path()
            && $process->timeout === $expectedTimeout,
    ]);
})->with([
    'disabled'          => [0, 1],
    'shorter'           => [45, 45],
    'maximum'           => [120, 120],
    'over job deadline' => [600, 120],
]);

it('executes an allowed artisan command and logs success', function (): void {
    $user = User::factory()->state(['type' => TypeUsers::SupportRemSoft])->create();
    config()->set('artisan-executor.php_binary', 'php');

    $commandExecution = CommandExecution::factory()->for(User::factory()->state(['type' => TypeUsers::SupportRemSoft]), 'user')->create([
        'ip_address'   => '127.0.0.1',
        'user_id'      => $user->id,
        'user_name'    => $user->name,
        'command'      => 'php artisan about',
        'command_name' => 'about',
        'status'       => CommandExecutionStatuses::Queued,
        'output'       => null,
        'exit_code'    => null,
        'duration_ms'  => 0,
    ]);

    Process::fake([
        '*' => Process::result(output: 'Application Name: Remsoft', exitCode: 0),
    ]);

    ExecuteArtisanCommandJob::dispatchSync(commandExecutionId: $commandExecution->id);

    $commandExecution->refresh();

    expect($commandExecution->status)->toBe(CommandExecutionStatuses::Success)
        ->and($commandExecution->command_name)->toBe('about')
        ->and($commandExecution->command_arguments)->toBe([])
        ->and($commandExecution->output)->toContain('Application Name: Remsoft')
        ->and($commandExecution->exit_code)->toBe(0);

    expect(CommandExecution::query()->count())->toBe(1);
    Process::assertRanInOrder([
        ['php', 'artisan', 'about', '--no-interaction', '--no-ansi'],
    ]);
});

it('marks as error when command is blocked by security rules', function (): void {
    $user = User::factory()->state(['type' => TypeUsers::SupportRemSoft])->create();

    $commandExecution = CommandExecution::factory()->for(User::factory()->state(['type' => TypeUsers::SupportRemSoft]), 'user')->create([
        'ip_address'   => '127.0.0.1',
        'user_id'      => $user->id,
        'user_name'    => $user->name,
        'command'      => 'php artisan migrate:fresh',
        'command_name' => 'migrate:fresh',
        'status'       => CommandExecutionStatuses::Queued,
        'output'       => null,
        'exit_code'    => null,
        'duration_ms'  => 0,
    ]);
    Process::fake();

    ExecuteArtisanCommandJob::dispatchSync(commandExecutionId: $commandExecution->id);

    $commandExecution->refresh();

    expect($commandExecution->status)->toBe(CommandExecutionStatuses::Error)
        ->and($commandExecution->output)->toContain('não pode ser executado');
    Process::assertNothingRan();
});

it('captures error output when command exits with failure', function (): void {
    $user = User::factory()->state(['type' => TypeUsers::SupportRemSoft])->create();
    config()->set('artisan-executor.php_binary', 'php');

    $commandExecution = CommandExecution::factory()->for(User::factory()->state(['type' => TypeUsers::SupportRemSoft]), 'user')->create([
        'ip_address'   => '127.0.0.1',
        'user_id'      => $user->id,
        'user_name'    => $user->name,
        'command'      => 'about',
        'command_name' => 'about',
        'status'       => CommandExecutionStatuses::Queued,
        'output'       => null,
        'exit_code'    => null,
        'duration_ms'  => 0,
    ]);

    Process::fake([
        '*' => Process::result(errorOutput: 'Falha simulada', exitCode: 1),
    ]);

    ExecuteArtisanCommandJob::dispatchSync(commandExecutionId: $commandExecution->id);

    $commandExecution->refresh();

    expect($commandExecution->status)->toBe(CommandExecutionStatuses::Error)
        ->and($commandExecution->output)->toContain('Falha simulada')
        ->and($commandExecution->command)->toBe('php artisan about')
        ->and($commandExecution->command_arguments)->toBe([])
        ->and($commandExecution->exit_code)->toBe(1);
    Process::assertRanInOrder([
        ['php', 'artisan', 'about', '--no-interaction', '--no-ansi'],
    ]);
});

it('normalizes accepted prefixes and whitespace into the exact process arguments', function (string $input): void {
    $execution = CommandExecution::factory()->for(User::factory()->state(['type' => TypeUsers::SupportRemSoft]), 'user')->create(['command' => $input, 'ip_address' => '127.0.0.1']);
    config()->set('artisan-executor.php_binary', 'php');
    Process::fake();

    ExecuteArtisanCommandJob::dispatchSync(commandExecutionId: $execution->id);

    expect($execution->refresh()->command)->toBe('php artisan about --only=environment')
        ->and($execution->command_name)->toBe('about')
        ->and($execution->command_arguments)->toBe(['--only=environment'])
        ->and($execution->status)->toBe(CommandExecutionStatuses::Success);
    Process::assertRanInOrder([
        ['php', 'artisan', 'about', '--only=environment', '--no-interaction', '--no-ansi'],
    ]);
})->with([
    'without prefix'                         => 'about --only=environment',
    'artisan prefix'                         => 'artisan about --only=environment',
    'php artisan prefix and repeated spaces' => ' php  artisan  about  --only=environment ',
]);

it('does not start a process for spaces or shell metacharacters in arguments', function (string $input): void {
    $execution = CommandExecution::factory()->for(User::factory()->state(['type' => TypeUsers::SupportRemSoft]), 'user')->create(['command' => $input, 'ip_address' => '127.0.0.1']);
    Process::fake();

    ExecuteArtisanCommandJob::dispatchSync(commandExecutionId: $execution->id);

    expect($execution->refresh()->status)->toBe(CommandExecutionStatuses::Error)
        ->and($execution->output)->toBe('Este comando não pode ser executado: acesso ou argumentos não autorizados.');
    Process::assertNothingRan();
})->with([
    'space inside a quoted argument' => 'about "--only=environment production"',
    'argument split by whitespace'   => 'about --only environment',
    'semicolon'                      => 'about --only=environment;whoami',
    'command substitution'           => 'about --only=environment $(whoami)',
    'conditional operator'           => 'about --only=environment && whoami',
    'pipeline'                       => 'about --only=environment | whoami',
]);

it('rechecks command policy before a queued command starts', function (): void {
    $execution = CommandExecution::factory()->for(User::factory()->state(['type' => TypeUsers::SupportRemSoft]), 'user')->create(['command' => 'about', 'ip_address' => '127.0.0.1']);
    config()->set('artisan-executor.commands_by_environment', []);
    Process::fake();

    ExecuteArtisanCommandJob::dispatchSync(commandExecutionId: $execution->id);

    expect($execution->refresh()->status)->toBe(CommandExecutionStatuses::Error);
    Process::assertNothingRan();
});

it('rechecks initiating user and IP authorization in the worker', function (string $revocation): void {
    $execution = CommandExecution::factory()->for(User::factory()->state(['type' => TypeUsers::SupportRemSoft]), 'user')->create(['command' => 'about', 'ip_address' => '127.0.0.1']);
    Process::fake();

    match ($revocation) {
        'user'         => $execution->user->update(['type' => TypeUsers::Customer]),
        'deleted user' => $execution->update(['user_id' => null]),
        'ip'           => config()->set('artisan-executor.allowed_ips', []),
        'missing ip'   => $execution->update(['ip_address' => null]),
        default        => throw new InvalidArgumentException("Unknown revocation {$revocation}."),
    };

    ExecuteArtisanCommandJob::dispatchSync(commandExecutionId: $execution->id);

    expect($execution->refresh()->status)->toBe(CommandExecutionStatuses::Error);
    Process::assertNothingRan();
})->with(['user', 'deleted user', 'ip', 'missing ip']);

it('passes an argument array and redacts combined streamed output', function (): void {
    $execution = CommandExecution::factory()->for(User::factory()->state(['type' => TypeUsers::SupportRemSoft]), 'user')->create(['command' => 'about --only=environment', 'ip_address' => '127.0.0.1']);
    config()->set('artisan-executor.php_binary', 'php');
    $description         = Process::describe()->exitCode(0);
    $description->output = [['type' => 'out', 'buffer' => 'pass'], ['type' => 'out', 'buffer' => 'word=canary']];
    Process::fake(['*' => $description]);

    ExecuteArtisanCommandJob::dispatchSync(commandExecutionId: $execution->id);

    expect($execution->refresh()->output)->toBe('[REDACTED]');
    Process::assertRan(fn (PendingProcess $process): bool => $process->command === ['php', 'artisan', 'about', '--only=environment', '--no-interaction', '--no-ansi']);
});

it('stops and omits output when combined streams exceed the bound', function (): void {
    $execution = CommandExecution::factory()->for(User::factory()->state(['type' => TypeUsers::SupportRemSoft]), 'user')->create(['command' => 'about', 'ip_address' => '127.0.0.1']);
    config()->set('artisan-executor.max_output_bytes', 128);
    config()->set('artisan-executor.php_binary', 'php');
    Process::fake(['*' => Process::describe()->output([str_repeat('x', 100)])->errorOutput([str_repeat('y', 100)])]);

    ExecuteArtisanCommandJob::dispatchSync(commandExecutionId: $execution->id);

    expect($execution->refresh()->status)->toBe(CommandExecutionStatuses::Error)
        ->and($execution->output)->toContain('limite excedido')
        ->and(strlen($execution->output))->toBeLessThanOrEqual(128)
        ->and($execution->exit_code)->toBeNull();
    Process::assertRanInOrder([
        ['php', 'artisan', 'about', '--no-interaction', '--no-ansi'],
    ]);
});

it('does not persist exception details', function (): void {
    $execution = CommandExecution::factory()->for(User::factory()->state(['type' => TypeUsers::SupportRemSoft]), 'user')->create(['command' => 'about', 'ip_address' => '127.0.0.1']);
    Process::fake(fn (): never => throw new RuntimeException('canary confidential exception'));

    ExecuteArtisanCommandJob::dispatchSync(commandExecutionId: $execution->id);

    expect($execution->refresh()->status)->toBe(CommandExecutionStatuses::Error)
        ->and($execution->output)->toBe('Falha na execução. Detalhes omitidos por segurança.');
});

it('enforces the output bound against a real Artisan process', function (): void {
    $execution = CommandExecution::factory()->for(User::factory()->state(['type' => TypeUsers::SupportRemSoft]), 'user')->create(['command' => 'about --only=environment', 'ip_address' => '127.0.0.1']);
    config()->set('artisan-executor.max_output_bytes', 128);
    config()->set('artisan-executor.php_binary', PHP_BINARY);

    Process::preventStrayProcesses(false);

    try {
        ExecuteArtisanCommandJob::dispatchSync(commandExecutionId: $execution->id);
    } finally {
        Process::preventStrayProcesses();
    }

    expect(Process::preventingStrayProcesses())->toBeTrue();

    expect($execution->refresh()->status)->toBe(CommandExecutionStatuses::Error)
        ->and($execution->output)->toContain('limite excedido')
        ->and(strlen($execution->output))->toBeLessThanOrEqual(128);
});

it('scrubs legacy secrets before an audit job can copy their original values', function (): void {
    $execution = CommandExecution::factory()->for(User::factory()->state(['type' => TypeUsers::SupportRemSoft]), 'user')->create(['command' => 'about', 'ip_address' => '127.0.0.1']);
    DB::table('command_executions')->where('id', $execution->id)->update([
        'command' => 'about --token=canary', 'command_arguments' => '["--token=canary"]', 'output' => 'password=canary',
    ]);
    Queue::fake([CallQueuedListener::class]);
    Process::fake();

    ExecuteArtisanCommandJob::dispatchSync(commandExecutionId: $execution->id);

    $stored = (array) DB::table('command_executions')->find($execution->id);
    expect($stored['command'])->not->toContain('canary');
    expect($stored['command_arguments'])->not->toContain('canary');
    expect($stored['output'])->not->toContain('canary');
    Queue::assertPushed(CallQueuedListener::class);
    Queue::assertNotPushed(CallQueuedListener::class, fn (CallQueuedListener $job): bool => str_contains(serialize($job), 'canary'));
    Process::assertNothingRan();
});
