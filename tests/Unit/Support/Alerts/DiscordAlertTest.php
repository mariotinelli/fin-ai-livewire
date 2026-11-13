<?php

declare(strict_types = 1);

use App\Enums\Queues;
use App\Enums\SystemErrorAlertSeverities;
use App\Jobs\SendDiscordCriticalAlertJob;
use App\Models\SystemErrorAlert;
use App\Support\Alerts\DiscordAlert;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Request;
use Illuminate\Routing\RouteCollection;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Request as RequestFacade;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Process\Exception\ProcessTimedOutException;
use Symfony\Component\Process\Process;

it('sends payload to discord webhook when enabled', function (): void {
    config()->set('alerts.discord.enabled', true);
    config()->set('alerts.discord.webhook_url', 'https://discord.test/webhook');
    config()->set('alerts.discord.timeout', 3);
    config()->set('alerts.discord.retry_times', 1);
    config()->set('alerts.discord.retry_sleep_ms', 1);

    Http::fake([
        'https://discord.test/webhook' => Http::response([], 204),
    ]);

    $delivered = app(DiscordAlert::class)->send([
        'content' => 'Erro crítico detectado.',
        'embeds'  => [],
    ]);

    expect($delivered)->toBeTrue();
    Http::assertSent(fn (ClientRequest $request): bool => $request->url() === 'https://discord.test/webhook'
        && $request['content'] === 'Erro crítico detectado.');
});

it('does not send payload when discord alerts are disabled', function (): void {
    config()->set('alerts.discord.enabled', false);
    config()->set('alerts.discord.webhook_url', 'https://discord.test/webhook');

    Http::fake();

    $delivered = app(DiscordAlert::class)->send([
        'content' => 'Erro crítico detectado.',
        'embeds'  => [],
    ]);

    expect($delivered)->toBeFalse();
    Http::assertNothingSent();
});

it('builds payload with details link to internal UI', function (): void {
    $alert = SystemErrorAlert::factory()->create();

    $payload = app(DiscordAlert::class)->buildPayload($alert);

    $detailsField = collect($payload['embeds'][0]['fields'])
        ->first(fn (array $field): bool => $field['name'] === 'Detalhes');

    expect($detailsField)->not->toBeNull()
        ->and($detailsField['value'])->toContain('/suporte/alertas-erros/');
});

it('stores queue runtime context when a worker timeout is reported', function (): void {
    config()->set('alerts.discord.enabled', true);
    config()->set('alerts.discord.webhook_url', 'https://discord.test/webhook');

    Queue::fake();

    Cache::put('alerts:queue:last-job:database:long_timeout', [
        'connection'  => 'database',
        'queue'       => Queues::LongTimeout->value,
        'name'        => 'App\\Jobs\\ScrapeProjectsSourceJob',
        'uuid'        => 'job-uuid-123',
        'attempts'    => 2,
        'reserved_at' => now()->toIso8601String(),
    ], now()->addMinutes(10));

    $process = new Process([
        'php',
        'artisan',
        'queue:work',
        '--once',
        '--queue=' . Queues::LongTimeout->value,
        '--tries=3',
    ]);
    $process->setTimeout(160);

    $exception = new ProcessTimedOutException($process, ProcessTimedOutException::TYPE_GENERAL);

    app(DiscordAlert::class)->report($exception);

    $alert = SystemErrorAlert::query()->latest('id')->first();

    expect($alert)->not->toBeNull()
        ->and($alert?->context['queue_worker']['queues'])->toContain(Queues::LongTimeout->value)
        ->and($alert?->context['queue_last_jobs'][Queues::LongTimeout->value]['name'])->toBe('App\\Jobs\\ScrapeProjectsSourceJob');
});

it('does not report ignored and 4xx http exceptions', function (): void {
    config()->set('alerts.discord.enabled', true);
    config()->set('alerts.discord.webhook_url', 'https://discord.test/webhook');
    config()->set('alerts.discord.ignored_exceptions', [LogicException::class]);

    $alert = app(DiscordAlert::class);

    $reflection = new ReflectionClass($alert);
    $method     = $reflection->getMethod('shouldReport');

    $ignored = $method->invoke($alert, new LogicException('ignored'));
    $http4xx = $method->invoke($alert, new HttpException(404, 'not found'));
    $http5xx = $method->invoke($alert, new HttpException(500, 'server error'));

    expect($ignored)->toBeFalse()
        ->and($http4xx)->toBeFalse()
        ->and($http5xx)->toBeTrue();
});

it('skips throttle cache add when throttle is disabled', function (): void {
    config()->set('alerts.discord.throttle_seconds', 0);

    $alert = app(DiscordAlert::class);

    Cache::shouldReceive('add')->never();

    $reflection = new ReflectionClass($alert);
    $method     = $reflection->getMethod('wasRecentlyReported');

    $result = $method->invoke($alert, 'fingerprint-abc');

    expect($result)->toBeFalse();
});

it('extracts command and queues from timeout messages and sanitizes context', function (): void {
    $alert = app(DiscordAlert::class);

    $reflection = new ReflectionClass($alert);

    $extractCommand = $reflection->getMethod('extractTimedOutCommand');

    $extractQueues = $reflection->getMethod('extractQueueNamesFromCommand');

    $sanitize = $reflection->getMethod('sanitizeRecursive');

    $process = Process::fromShellCommandline('php artisan queue:work --queue=default,' . Queues::LongTimeout->value . ',default');
    $process->setTimeout(10);

    $timeoutException = new ProcessTimedOutException($process, ProcessTimedOutException::TYPE_GENERAL);

    $command = $extractCommand->invoke($alert, $timeoutException);
    $queues  = $extractQueues->invoke($alert, $command);

    $emptyQueues  = $extractQueues->invoke($alert, 'php artisan queue:work --once');
    $quotedQueues = $extractQueues->invoke($alert, "'php' 'artisan' 'queue:work' '--queue=" . Queues::LongTimeout->value . "' '--once'");

    $sanitized = $sanitize->invoke($alert, [
        'token'  => 'abc',
        'nested' => [
            'authorization' => 'Bearer x',
            'name'          => 'ok',
        ],
    ]);

    expect($command)->toContain('--queue=default,' . Queues::LongTimeout->value . ',default')
        ->and($queues)->toBe(['default', Queues::LongTimeout->value])
        ->and($emptyQueues)->toBe([])
        ->and($quotedQueues)->toBe([Queues::LongTimeout->value])
        ->and($sanitized['token'])->toBe('**********')
        ->and($sanitized['nested']['authorization'])->toBe('**********')
        ->and($sanitized['nested']['name'])->toBe('ok');
});

it('builds trace summary and formats user fallbacks', function (): void {
    config()->set('alerts.discord.trace_lines', 1);

    $alert = app(DiscordAlert::class);

    $reflection = new ReflectionClass($alert);

    $traceSummary = $reflection->getMethod('buildTraceSummary');

    $formatUser = $reflection->getMethod('formatUser');

    $emptySummary = $traceSummary->invoke($alert, '');
    $limited      = $traceSummary->invoke($alert, "line-1\nline-2");

    $userWithEmail = new class () {
        public function getAuthIdentifier(): int
        {
            return 42;
        }

        public string $email = 'dev@remsoft.com';
    };

    $userWithoutEmail = new class () {
        public function getAuthIdentifier(): int
        {
            return 7;
        }
    };

    $formattedNull         = $formatUser->invoke($alert, null);
    $formattedWithEmail    = $formatUser->invoke($alert, $userWithEmail);
    $formattedWithoutEmail = $formatUser->invoke($alert, $userWithoutEmail);

    expect($emptySummary)->toBe('Rastreio indisponível.')
        ->and($limited)->toBe('line-1')
        ->and($formattedNull)->toBe('Não autenticado')
        ->and($formattedWithEmail)->toBe('42 (dev@remsoft.com)')
        ->and($formattedWithoutEmail)->toBe('7');
});

it('builds sanitized context from request and handles null request', function (): void {
    $alert = app(DiscordAlert::class);

    $reflection = new ReflectionClass($alert);
    $method     = $reflection->getMethod('buildSanitizedContext');

    $request = Request::create('/x?secret=123&name=ok', 'POST', [
        'password'              => 'hidden',
        'password_confirmation' => 'hidden-2',
        'token'                 => 'abc',
        'payload'               => ['x-api-key' => 'k', 'field' => 'value'],
    ]);
    $request->headers->set('User-Agent', 'Pest');

    $withRequest = $method->invoke($alert, $request);
    $nullRequest = $method->invoke($alert, null);

    expect($withRequest['query']['secret'])->toBe('**********')
        ->and($withRequest['request']['token'])->toBe('**********')
        ->and($withRequest['request']['payload']['x-api-key'])->toBe('**********')
        ->and(isset($withRequest['request']['password']))->toBeFalse()
        ->and($nullRequest)->toBe([]);
});

it('resolves emergency severity and formats user without auth identifier', function (): void {
    $alert = app(DiscordAlert::class);

    $reflection = new ReflectionClass($alert);

    $severity = $reflection->getMethod('resolveSeverity');

    $formatUser = $reflection->getMethod('formatUser');

    $emergency = $severity->invoke($alert, new HttpException(503, 'unavailable'));

    $plainUser = (object) ['email' => 'no-id@remsoft.com'];
    $formatted = $formatUser->invoke($alert, $plainUser);

    expect($emergency)->toBe(SystemErrorAlertSeverities::Emergency)
        ->and($formatted)->toBe('N/A (no-id@remsoft.com)');
});

it('keeps queue last jobs empty when cache value is not array', function (): void {
    config()->set('alerts.discord.enabled', true);
    config()->set('alerts.discord.webhook_url', 'https://discord.test/webhook');

    Queue::fake();

    Cache::put('alerts:queue:last-job:database:long_timeout', 'invalid-value', now()->addMinutes(10));

    $process = new Process([
        'php',
        'artisan',
        'queue:work',
        '--once',
        '--queue=long_timeout',
    ]);
    $process->setTimeout(30);

    app(DiscordAlert::class)->report(new ProcessTimedOutException($process, ProcessTimedOutException::TYPE_GENERAL));

    $alert = SystemErrorAlert::query()->latest('id')->first();

    expect($alert)->not->toBeNull()
        ->and($alert?->context['queue_worker']['queues'])->toBe([Queues::LongTimeout->value])
        ->and($alert?->context['queue_last_jobs'])->toBe([]);
});

it('redacts sentinels before persistence queue dispatch and external delivery while preserving safe query data', function (): void {
    config()->set('alerts.discord.enabled', true);
    config()->set('alerts.discord.webhook_url', 'https://discord.test/webhook');
    Queue::fake([SendDiscordCriticalAlertJob::class]);
    Http::preventStrayRequests();
    Http::fake(['https://discord.test/webhook' => Http::response([], 204)]);
    $request = Request::create('https://app.test/search?page=2&access_token=SENTINEL_URL', 'POST', [
        'clientSecret'          => 'SENTINEL_BODY',
        'password_confirmation' => 'SENTINEL_PASSWORD',
        'safe'                  => 'kept',
    ]);
    $request->headers->set('Authorization', 'Bearer SENTINEL_HEADER');
    $request->headers->set('X-Request-Id', 'api_key=SENTINEL_REQUEST_ID');
    $request->headers->set('User-Agent', 'Pest token=SENTINEL_AGENT');

    app()->instance('request', $request);
    $exception = new RuntimeException('Failure SENTINEL_BODY client_secret=SENTINEL_MESSAGE');

    app(DiscordAlert::class)->report($exception, [
        'api_key'    => 'SENTINEL_EXTRA',
        'query'      => ['refresh_token' => 'SENTINEL_OVERRIDE', 'page' => 2],
        'nested'     => [['accessToken' => 'SENTINEL_NESTED']],
        'diagnostic' => 'Retry SENTINEL_BODY',
    ]);

    $alert = SystemErrorAlert::query()->sole();
    expect($alert->toJson())->not->toContain('SENTINEL')
        ->and($alert->request_url)->toContain('page=2', 'access_token=**********')
        ->and($alert->context['query']['page'])->toBe(2)
        ->and($alert->context['request']['safe'])->toBe('kept');
    Queue::assertPushed(SendDiscordCriticalAlertJob::class, function (SendDiscordCriticalAlertJob $job): bool {
        expect(json_encode($job->payload, JSON_THROW_ON_ERROR))->not->toContain('SENTINEL');
        expect($job->systemErrorAlertId)->toBe(SystemErrorAlert::query()->sole()->getKey());

        app(DiscordAlert::class)->send($job->payload);

        return true;
    });
    Http::assertSent(function (ClientRequest $request): bool {
        expect($request->body())->not->toContain('SENTINEL');

        return $request->url() === 'https://discord.test/webhook';
    });
});

it('sanitizes historical records before building payloads and bounds the complete embed', function (): void {
    $alert = SystemErrorAlert::factory()->create([
        'message'     => 'access_token="' . str_repeat('SENTINEL ', 1000) . '"',
        'request_url' => 'https://SENTINEL_USER:SENTINEL_PASS@app.test/?api_key=SENTINEL_URL&page=2#SENTINEL_FRAGMENT',
        'trace'       => "#0 /app/Test.php(1): execute('SENTINEL_TRACE')\n#1 {main}",
        'route_name'  => str_repeat('a', 191),
    ]);

    $payload = app(DiscordAlert::class)->buildPayload($alert);

    expect(json_encode($payload, JSON_THROW_ON_ERROR))->not->toContain('SENTINEL');
    $embed  = $payload['embeds'][0];
    $length = mb_strlen($embed['title']);

    foreach ($embed['fields'] as $field) {
        expect(mb_strlen($field['value']))->toBeLessThanOrEqual(400);
        $length += mb_strlen($field['name']) + mb_strlen($field['value']);
    }

    expect($length)->toBeLessThanOrEqual(6000);
});

it('sanitizes already queued payloads immediately before HTTP even when delivery fails', function (): void {
    config()->set('alerts.discord.enabled', true);
    config()->set('alerts.discord.webhook_url', 'https://discord.test/webhook');
    config()->set('alerts.discord.retry_times', 1);
    Http::preventStrayRequests();
    Http::fake(['https://discord.test/webhook' => Http::response([], 500)]);
    $payload = [
        'content' => 'Failure Authorization: Bearer SENTINEL_CONTENT',
        'embeds'  => [[
            'title'     => 'api_key=SENTINEL_TITLE',
            'timestamp' => '2026-01-01T10:00:00+00:00',
            'fields'    => [
                ['name' => 'URL', 'value' => '/search?access_token=SENTINEL_URL&page=2'],
                ['name' => 'Rastreio (resumo)', 'value' => "#0 /app/Test.php(1): run('SENTINEL_TRACE')"],
            ],
        ]],
    ];

    expect(fn () => app(DiscordAlert::class)->send($payload))->toThrow(RequestException::class);

    Http::assertSent(function (ClientRequest $request): bool {
        expect($request->body())->not->toContain('SENTINEL')
            ->and($request['embeds'][0]['timestamp'])->toBe('2026-01-01T10:00:00+00:00');

        return true;
    });
});

it('limits persisted diagnostic text and omits trace arguments', function (): void {
    config()->set('alerts.discord.enabled', true);
    config()->set('alerts.discord.webhook_url', 'https://discord.test/webhook');
    Queue::fake([SendDiscordCriticalAlertJob::class]);
    $previousIgnoreArguments = ini_set('zend.exception_ignore_args', '0');

    try {
        $exception = (static fn (string $argument): RuntimeException => new RuntimeException(str_repeat('é', 5000)))('SENTINEL_TRACE_ARGUMENT');
    } finally {
        ini_set('zend.exception_ignore_args', (string) $previousIgnoreArguments);
    }

    expect($exception->getTrace()[0]['args'])->toContain('SENTINEL_TRACE_ARGUMENT');

    app(DiscordAlert::class)->report($exception, ['diagnostic' => str_repeat('é', 3000)]);

    $alert = SystemErrorAlert::query()->sole();
    expect($alert->message)->toHaveLength(4000)
        ->and(mb_strlen($alert->context['diagnostic']))->toBe(2000)
        ->and($alert->trace)->not->toContain('SENTINEL_TRACE_ARGUMENT');
    Queue::assertPushed(SendDiscordCriticalAlertJob::class);
});

it('reports a CLI timeout without a bound request and sanitizes its fallback command', function (): void {
    config()->set('alerts.discord.enabled', true);
    config()->set('alerts.discord.webhook_url', 'https://discord.test/webhook');
    Queue::fake([SendDiscordCriticalAlertJob::class]);
    auth()->id();
    /** Preserve auditing's resolved request while exercising the reporter's requestless CLI path. */
    RequestFacade::getFacadeRoot();
    app()->offsetUnset('request');
    $process = new Process(['php', 'artisan', 'queue:work']);
    $process->setTimeout(10);

    $exception = new ProcessTimedOutException($process, ProcessTimedOutException::TYPE_GENERAL);
    new ReflectionProperty(Exception::class, 'message')->setValue($exception, 'worker --api-key SENTINEL_CLI --once');

    app(DiscordAlert::class)->report($exception);

    $alert = SystemErrorAlert::query()->sole();
    expect($alert->request_method)->toBe('CLI')
        ->and($alert->route_name)->toBe('queue-worker')
        ->and($alert->request_url)->toBe('worker --api-key=********** --once')
        ->and($alert->toJson())->not->toContain('SENTINEL');
    Queue::assertPushed(SendDiscordCriticalAlertJob::class);
});

it('keeps payloads usable when the support details route is unavailable', function (): void {
    $alert = SystemErrorAlert::factory()->create();
    app('router')->setRoutes(new RouteCollection());

    $payload = app(DiscordAlert::class)->buildPayload($alert);

    $details = collect($payload['embeds'][0]['fields'])->firstWhere('name', 'Detalhes');
    expect($details['value'])->toBe('N/A');
});

it('bounds queued payload content and all embed fields before external delivery', function (): void {
    config()->set('alerts.discord.enabled', true);
    config()->set('alerts.discord.webhook_url', 'https://discord.test/webhook');
    Http::preventStrayRequests();
    Http::fake(['https://discord.test/webhook' => Http::response([], 204)]);
    $embed = [
        'title'  => str_repeat('é', 500),
        'fields' => array_fill(0, 20, ['name' => str_repeat('é', 200), 'value' => str_repeat('é', 2000)]),
    ];

    app(DiscordAlert::class)->send(['content' => str_repeat('é', 3000), 'embeds' => [$embed, $embed]]);

    Http::assertSent(function (ClientRequest $request): bool {
        expect(mb_strlen($request['content']))->toBe(500)
            ->and($request['embeds'])->toHaveCount(1);
        $embed = $request['embeds'][0];
        expect($embed['fields'])->toHaveCount(12);
        $length = mb_strlen($embed['title']);

        foreach ($embed['fields'] as $field) {
            $length += mb_strlen($field['name']) + mb_strlen($field['value']);
        }

        expect($length)->toBeLessThanOrEqual(6000);

        return true;
    });
});

it('persists sanitized occurrences independently of the external channel', function (bool $enabled, string $webhook): void {
    config()->set('alerts.discord.enabled', $enabled);
    config()->set('alerts.discord.webhook_url', $webhook);
    Queue::fake();
    Cache::shouldReceive('add')->never();
    $exception = new RuntimeException('Failure api_key=SENTINEL_SECRET');

    app(DiscordAlert::class)->report($exception);
    app(DiscordAlert::class)->report($exception);

    $alert = SystemErrorAlert::query()->sole();
    expect($alert->occurrences)->toBe(2)
        ->and($alert->last_notified_at)->toBeNull()
        ->and($alert->message)->not->toContain('SENTINEL');
    Queue::assertNotPushed(SendDiscordCriticalAlertJob::class);
})->with([
    'disabled'        => [false, 'https://discord.test/webhook'],
    'missing webhook' => [true, ''],
]);

it('preserves the original exception in the default logger when database reporting fails', function (string $statement): void {
    config()->set('alerts.discord.enabled', true);
    config()->set('alerts.discord.webhook_url', 'https://discord.test/webhook');
    Queue::fake();
    $exception = new RuntimeException('Original application failure');
    $logger    = Mockery::mock(LoggerInterface::class);
    $logger->shouldReceive('error')->once()->with($exception->getMessage(), Mockery::on(
        static fn (array $context): bool => $context['exception'] === $exception,
    ));
    app()->instance(LoggerInterface::class, $logger);

    if ($statement === 'select') {
        app(DiscordAlert::class)->report($exception);
        Queue::fake();
    }

    $failed = false;
    DB::connection()->beforeExecuting(function (string $query) use ($statement, &$failed): void {
        if (!$failed && str_starts_with($query, $statement) && str_contains($query, 'system_error_alerts')) {
            $failed = true;

            throw new RuntimeException('Reporter database unavailable');
        }
    });

    report($exception);

    expect($failed)->toBeTrue();
    Queue::assertNotPushed(SendDiscordCriticalAlertJob::class);
    app(DiscordAlert::class)->report(new RuntimeException('Next independent failure'));
    expect(SystemErrorAlert::query()->where('message', 'Next independent failure')->count())->toBe(1);
})->with(['read' => 'select', 'insert' => 'insert']);

it('keeps the local record and original log when throttling cache is unavailable', function (): void {
    config()->set('alerts.discord.enabled', true);
    config()->set('alerts.discord.webhook_url', 'https://discord.test/webhook');
    config()->set('alerts.discord.throttle_seconds', 60);
    Queue::fake();
    Cache::shouldReceive('add')->once()->andThrow(new RuntimeException('Cache unavailable'));
    $exception = new RuntimeException('Original cache incident');
    $logger    = Mockery::mock(LoggerInterface::class);
    $logger->shouldReceive('error')->once()->with($exception->getMessage(), Mockery::on(
        static fn (array $context): bool => $context['exception'] === $exception,
    ));
    app()->instance(LoggerInterface::class, $logger);

    report($exception);

    expect(SystemErrorAlert::query()->sole()->message)->toBe($exception->getMessage());
    Queue::assertNotPushed(SendDiscordCriticalAlertJob::class);
});

it('keeps local persistence and original logging when queue dispatch fails', function (): void {
    config()->set('alerts.discord.enabled', true);
    config()->set('alerts.discord.webhook_url', 'https://discord.test/webhook');
    config()->set('alerts.discord.throttle_seconds', 0);
    config()->set('audit.enabled', false);
    Bus::partialMock()->shouldReceive('dispatch')->once()->with(Mockery::type(SendDiscordCriticalAlertJob::class))
        ->andThrow(new RuntimeException('Queue unavailable'));
    $exception = new RuntimeException('Original queue incident');
    $logger    = Mockery::mock(LoggerInterface::class);
    $logger->shouldReceive('error')->once()->with($exception->getMessage(), Mockery::on(
        static fn (array $context): bool => $context['exception'] === $exception,
    ));
    app()->instance(LoggerInterface::class, $logger);

    report($exception);

    expect(SystemErrorAlert::query()->sole()->message)->toBe($exception->getMessage())
        ->and(SystemErrorAlert::query()->sole()->last_notified_at)->toBeNull();
});

it('persists worker timeouts when optional runtime cache cannot be read', function (): void {
    config()->set('alerts.discord.enabled', false);
    Queue::fake();
    Cache::shouldReceive('get')->once()->with('alerts:queue:last-job:database:critical')
        ->andThrow(new RuntimeException('Runtime cache unavailable'));
    $process = new Process(['php', 'artisan', 'queue:work', '--queue=critical']);
    $process->setTimeout(10);

    app(DiscordAlert::class)->report(new ProcessTimedOutException($process, ProcessTimedOutException::TYPE_GENERAL));

    $alert = SystemErrorAlert::query()->sole();
    expect($alert->exception_class)->toBe(ProcessTimedOutException::class)
        ->and($alert->context['queue_last_jobs'])->toBe([])
        ->and($alert->context['queue_worker']['queues'])->toBe(['critical']);
    Queue::assertNotPushed(SendDiscordCriticalAlertJob::class);
});

it('blocks recursive reporting across instances and releases the guard afterwards', function (): void {
    config()->set('alerts.discord.enabled', false);
    Queue::fake();
    $nested = false;
    DB::connection()->beforeExecuting(function (string $query) use (&$nested): void {
        if (!$nested && str_contains($query, 'system_error_alerts')) {
            $nested = true;
            app(DiscordAlert::class)->report(new RuntimeException('Nested reporter failure'));
        }
    });

    app(DiscordAlert::class)->report(new RuntimeException('Original failure'));
    app(DiscordAlert::class)->report(new RuntimeException('Later failure'));

    expect($nested)->toBeTrue()
        ->and(SystemErrorAlert::query()->pluck('message')->all())->toBe(['Original failure', 'Later failure']);
    Queue::assertNotPushed(SendDiscordCriticalAlertJob::class);
});

it('preserves exclusions with the external channel disabled and permits the next critical report', function (Throwable $exception): void {
    config()->set('alerts.discord.enabled', false);
    config()->set('alerts.discord.ignored_exceptions', [LogicException::class]);
    Queue::fake();

    app(DiscordAlert::class)->report($exception);

    expect(SystemErrorAlert::query()->count())->toBe(0);
    app(DiscordAlert::class)->report(new RuntimeException('Critical incident after exclusion'));
    expect(SystemErrorAlert::query()->sole()->message)->toBe('Critical incident after exclusion');
    Queue::assertNotPushed(SendDiscordCriticalAlertJob::class);
})->with([
    'configured exclusion' => fn (): Throwable => new LogicException('Ignored'),
    'HTTP client error'    => fn (): Throwable => new HttpException(404, 'Not found'),
]);

it('persists every occurrence while notifying again only after the throttle expires', function (): void {
    config()->set('alerts.discord.enabled', true);
    config()->set('alerts.discord.webhook_url', 'https://discord.test/webhook');
    config()->set('alerts.discord.throttle_seconds', 60);
    $this->freezeTime();
    Queue::fake();
    $exception = new RuntimeException('Repeated incident');

    app(DiscordAlert::class)->report($exception);
    $this->travel(59)->seconds();
    app(DiscordAlert::class)->report($exception);
    Queue::assertPushed(SendDiscordCriticalAlertJob::class, 1);
    $this->travel(2)->seconds();
    app(DiscordAlert::class)->report($exception);

    $alert = SystemErrorAlert::query()->sole();

    expect($alert->occurrences)->toBe(3)
        ->and($alert->last_notified_at)->toBeNull();
    Queue::assertPushed(SendDiscordCriticalAlertJob::class, 2);
});
