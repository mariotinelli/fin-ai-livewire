<?php

declare(strict_types = 1);

use App\Actions\SystemErrorAlert\UpsertSystemErrorAlert;
use App\Enums\SystemErrorAlertSeverities;
use App\Enums\SystemErrorAlertStatuses;
use App\Models\SystemErrorAlert;
use Carbon\CarbonImmutable;
use Illuminate\Database\QueryException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Process\Process;

it('creates a new system error alert when fingerprint does not exist', function (): void {
    $attributes = [
        'fingerprint'     => 'abc123',
        'severity'        => SystemErrorAlertSeverities::Critical,
        'environment'     => 'testing',
        'exception_class' => 'RuntimeException',
        'message'         => 'Falha crítica no módulo de faturamento.',
        'file'            => 'app/Services/BillingService.php',
        'line'            => 42,
        'route_name'      => 'dashboard',
        'request_method'  => 'GET',
        'request_url'     => 'http://inova.ai.test/dashboard',
        'request_id'      => 'req-123',
        'user_id'         => null,
        'context'         => ['ip' => '127.0.0.1'],
        'trace'           => '#0 test',
        'occurred_at'     => now(),
    ];

    $systemErrorAlert = app(UpsertSystemErrorAlert::class)->handle($attributes);

    expect($systemErrorAlert->status)->toBe(SystemErrorAlertStatuses::Open)
        ->and($systemErrorAlert->occurrences)->toBe(1)
        ->and($systemErrorAlert->environment)->toBe('testing');

    expect(SystemErrorAlert::query()->whereKey($systemErrorAlert->id)->exists())->toBeTrue();
});

it('updates existing system error alert and increments occurrences', function (): void {
    $alert = SystemErrorAlert::factory()->create([
        'fingerprint' => 'same-fingerprint',
        'environment' => 'testing',
        'occurrences' => 3,
        'status'      => SystemErrorAlertStatuses::Open,
    ]);

    app(UpsertSystemErrorAlert::class)->handle([
        'fingerprint'     => 'same-fingerprint',
        'severity'        => SystemErrorAlertSeverities::Emergency,
        'environment'     => 'testing',
        'exception_class' => 'RuntimeException',
        'message'         => 'Novo erro grave.',
        'file'            => 'app/Services/NewService.php',
        'line'            => 99,
        'route_name'      => 'admin.management.settings.index',
        'request_method'  => 'POST',
        'request_url'     => 'http://inova.ai.test/admin/gestao/configuracoes',
        'request_id'      => 'req-999',
        'user_id'         => null,
        'context'         => ['payload' => 'x'],
        'trace'           => '#0 updated',
        'occurred_at'     => now(),
    ]);

    $alert->refresh();

    expect($alert->occurrences)->toBe(4)
        ->and($alert->severity)->toBe(SystemErrorAlertSeverities::Emergency)
        ->and($alert->message)->toBe('Novo erro grave.')
        ->and($alert->route_name)->toBe('admin.management.settings.index');
});

it('keeps environments separate for the same fingerprint', function (): void {
    $attributes = systemErrorAlertAttributes(['fingerprint' => 'shared-fingerprint']);

    $first  = app(UpsertSystemErrorAlert::class)->handle($attributes);
    $second = app(UpsertSystemErrorAlert::class)->handle([...$attributes, 'environment' => 'production']);

    expect($second->id)->not->toBe($first->id);
    expect($first->occurrences)->toBe(1);
    expect($second->occurrences)->toBe(1);
});

it('reopens resolved alerts while preserving acknowledged alerts and notification history', function (SystemErrorAlertStatuses $status, SystemErrorAlertStatuses $expected): void {
    $alert = SystemErrorAlert::factory()->create([
        'status'           => $status,
        'occurrences'      => 2,
        'last_notified_at' => now()->setDate(2026, 1, 2)->startOfDay(),
        'last_seen_at'     => now()->setDate(2026, 1, 3)->startOfDay(),
    ]);

    $result = app(UpsertSystemErrorAlert::class)->handle(systemErrorAlertAttributes([
        'fingerprint' => $alert->fingerprint,
        'environment' => $alert->environment,
        'occurred_at' => now()->setDate(2026, 1, 1)->startOfDay(),
    ]));

    expect($result->status)->toBe($expected)
        ->and($result->occurrences)->toBe(3)
        ->and($result->last_notified_at->toDateTimeString())->toBe('2026-01-02 00:00:00');
})->with([
    'resolved even for a delayed occurrence' => [SystemErrorAlertStatuses::Resolved, SystemErrorAlertStatuses::Open],
    'acknowledged'                           => [SystemErrorAlertStatuses::Acknowledged, SystemErrorAlertStatuses::Acknowledged],
    'open'                                   => [SystemErrorAlertStatuses::Open, SystemErrorAlertStatuses::Open],
]);

it('preserves the occurrence time bounds and latest details when events arrive out of order', function (): void {
    $attributes = systemErrorAlertAttributes(['fingerprint' => 'out-of-order']);
    $action     = app(UpsertSystemErrorAlert::class);
    $alert      = $action->handle([...$attributes, 'occurred_at' => now()->setDate(2026, 1, 2)->startOfDay()]);
    $action->handle([...$attributes, 'message' => 'Última ocorrência', 'occurred_at' => now()->setDate(2026, 1, 3)->startOfDay()]);

    $result = $action->handle([...$attributes, 'message' => 'Ocorrência atrasada', 'occurred_at' => CarbonImmutable::parse('2026-01-01 00:00:00')]);

    expect($result->id)->toBe($alert->id)
        ->and($result->occurrences)->toBe(3)
        ->and($result->first_seen_at->toDateTimeString())->toBe('2026-01-01 00:00:00')
        ->and($result->last_seen_at->toDateTimeString())->toBe('2026-01-03 00:00:00')
        ->and($result->message)->toBe('Última ocorrência');
});

it('rolls back metadata and counter when persisting an occurrence fails', function (): void {
    $attributes = systemErrorAlertAttributes(['fingerprint' => 'rollback']);
    $alert      = app(UpsertSystemErrorAlert::class)->handle($attributes);
    $original   = $alert->refresh()->getRawOriginal();

    expect(fn () => app(UpsertSystemErrorAlert::class)->handle([
        ...$attributes,
        'user_id' => 999999,
        'message' => 'Não deve persistir',
    ]))->toThrow(QueryException::class);

    expect($alert->refresh()->getRawOriginal())->toBe($original);
});

it('keeps occurrences inside the caller transaction', function (bool $existing): void {
    $attributes = systemErrorAlertAttributes(['fingerprint' => 'outer-rollback']);
    $action     = app(UpsertSystemErrorAlert::class);

    if ($existing) {
        $action->handle($attributes);
    }

    expect(function () use ($action, $attributes): void {
        DB::transaction(function () use ($action, $attributes): void {
            $action->handle([...$attributes, 'message' => 'Não deve persistir']);

            throw new RuntimeException('Caller failed');
        });
    })->toThrow(RuntimeException::class, 'Caller failed');

    $this->assertDatabaseCount('system_error_alerts', $existing ? 1 : 0);

    if ($existing) {
        $this->assertDatabaseHas('system_error_alerts', [
            'fingerprint' => 'outer-rollback',
            'occurrences' => 1,
            'message'     => $attributes['message'],
        ]);
    }
})->with(['new group' => false, 'existing group' => true]);

it('counts every simultaneous occurrence in one group', function (bool $existing): void {
    $originalConnection = DB::getDefaultConnection();
    $originalAudit      = config('audit.enabled');
    $directory          = sys_get_temp_dir() . '/rsp35-' . bin2hex(random_bytes(8));
    mkdir($directory);
    $connection           = config('database.connections.' . $originalConnection);
    $connection['prefix'] = 'r35_' . bin2hex(random_bytes(4)) . '_';
    $connection['url']    = null;

    if ($connection['driver'] === 'sqlite') {
        $connection['database']     = $directory . '/database.sqlite';
        $connection['busy_timeout'] = 10000;
        touch($connection['database']);
    }

    config(['database.connections.alert_concurrency' => $connection, 'audit.enabled' => false]);
    DB::setDefaultConnection('alert_concurrency');
    Schema::clearResolvedInstance('db.schema');
    $barrier = fopen($directory . '/barrier', 'c+');
    flock($barrier, LOCK_EX);
    $processes = [];

    try {
        Schema::create('users', function (Blueprint $table): void {
            $table->id();
        });
        (require database_path('migrations/2026_03_10_010000_create_system_error_alerts_table.php'))->up();
        (require database_path('migrations/2026_09_09_154656_consolidate_system_error_alerts.php'))->up();
        $attributes = systemErrorAlertAttributes(['fingerprint' => 'concurrent']);

        if ($existing) {
            SystemErrorAlert::factory()->create([
                'fingerprint'   => 'concurrent',
                'environment'   => 'testing',
                'occurrences'   => 3,
                'first_seen_at' => now()->setDate(2026, 1, 1)->startOfDay(),
                'last_seen_at'  => now()->setDate(2026, 1, 1)->startOfDay(),
            ]);
        }

        for ($worker = 0; $worker < 8; $worker++) {
            $process = new Process(
                [PHP_BINARY, __DIR__ . '/upsert-concurrency-worker.php'],
                base_path(),
                ['APP_ENV' => 'testing', 'APP_CONFIG_CACHE' => $directory . '/config.php'],
                json_encode([
                    'directory'  => $directory,
                    'connection' => $connection,
                    'attributes' => [...$attributes, 'occurred_at' => sprintf('2026-01-02 00:00:0%d', $worker)],
                ], JSON_THROW_ON_ERROR),
                45,
            );
            $process->start();
            $processes[] = $process;
        }

        foreach ($processes as $process) {
            while ($process->isRunning() && !str_contains($process->getOutput(), "ready\n")) {
                $process->checkTimeout();
                usleep(1000);
            }

            expect($process->getOutput())->toContain("ready\n", $process->getErrorOutput());
        }

        flock($barrier, LOCK_UN);

        foreach ($processes as $process) {
            expect($process->wait())->toBe(0, $process->getErrorOutput() . $process->getOutput());
        }

        $this->assertDatabaseCount('system_error_alerts', 1);
        $alert = SystemErrorAlert::query()->sole();
        expect($alert->occurrences)->toBe($existing ? 43 : 40)
            ->and($alert->first_seen_at->toDateTimeString())->toBe($existing ? '2026-01-01 00:00:00' : '2026-01-02 00:00:00')
            ->and($alert->last_seen_at->toDateTimeString())->toBe('2026-01-02 00:00:07');

        foreach ($processes as $process) {
            expect(trim(substr($process->getOutput(), strlen("ready\n"))))->toBe((string) $alert->id);
        }
    } finally {
        flock($barrier, LOCK_UN);
        fclose($barrier);

        foreach ($processes as $process) {
            $process->stop();
        }

        Schema::dropIfExists('system_error_alerts');
        Schema::dropIfExists('users');
        DB::purge('alert_concurrency');
        DB::setDefaultConnection($originalConnection);
        Schema::clearResolvedInstance('db.schema');
        config(['audit.enabled' => $originalAudit]);
        new Filesystem()->deleteDirectory($directory);
    }
})->with(['new group' => false, 'existing group' => true]);

/**
 * @param array<string, mixed> $overrides
 * @return array<string, mixed>
 */
function systemErrorAlertAttributes(array $overrides = []): array
{
    $alert = SystemErrorAlert::factory()->make();

    return [
        ...$alert->only([
            'fingerprint', 'severity', 'environment', 'exception_class', 'message',
            'file', 'line', 'route_name', 'request_method', 'request_url', 'request_id',
            'user_id', 'context', 'trace',
        ]),
        'occurred_at' => now()->startOfSecond(),
        'environment' => 'testing',
        ...$overrides,
    ];
}
