<?php

declare(strict_types = 1);

namespace App\Support\Alerts;

use App\Actions\SystemErrorAlert\UpsertSystemErrorAlert;
use App\Enums\SystemErrorAlertSeverities;
use App\Jobs\SendDiscordCriticalAlertJob;
use App\Models\SystemErrorAlert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Process\Exception\ProcessTimedOutException;
use Throwable;

class DiscordAlert
{
    private static bool $reporting = false;

    /** @param array<string, mixed> $extraContext */
    public function report(Throwable $throwable, array $extraContext = []): void
    {
        if (self::$reporting) {
            return;
        }

        self::$reporting = true;

        try {
            if (!$this->shouldReport($throwable)) {
                return;
            }

            $systemErrorAlert = app(UpsertSystemErrorAlert::class)->handle(attributes: $this->buildUpsertAttributes($throwable, $extraContext));

            if (!$this->isEnabled() || $this->wasRecentlyReported($systemErrorAlert->fingerprint)) {
                return;
            }

            SendDiscordCriticalAlertJob::dispatch(
                $systemErrorAlert->id,
                $this->buildPayload($systemErrorAlert),
            );
        } catch (Throwable) {
            // Reporting is auxiliary: logging its failure here can recursively invoke this reporter.
        } finally {
            self::$reporting = false;
        }
    }

    /** @param array{content: string, embeds: array<int, array<string, mixed>>} $payload */
    public function send(array $payload): bool
    {
        $webhookUrl = $this->payloadString(config('alerts.discord.webhook_url'), '');

        if (!$this->isEnabled() || $webhookUrl === '') {
            return false;
        }

        $payload = $this->sanitizePayload($payload);

        Http::timeout(config()->integer('alerts.discord.timeout'))
            ->retry(config()->integer('alerts.discord.retry_times'), config()->integer('alerts.discord.retry_sleep_ms'))
            ->post($webhookUrl, [
                'content' => $payload['content'],
                'embeds'  => $payload['embeds'],
            ])
            ->throw();

        return true;
    }

    /** @return array{content: string, embeds: array<int, array<string, mixed>>} */
    public function buildPayload(SystemErrorAlert $systemErrorAlert): array
    {
        $traceSummary = $this->buildTraceSummary($systemErrorAlert->trace);
        $location     = ($systemErrorAlert->file ?? 'N/A') . ':' . ($systemErrorAlert->line ?? 'N/A');
        $alertUrl     = $this->getAlertUrl($systemErrorAlert);

        return $this->sanitizePayload([
            'content' => sprintf(
                '[%s] Erro crítico detectado em %s.',
                strtoupper($systemErrorAlert->environment),
                config()->string('app.name'),
            ),
            'embeds' => [[
                'title'  => 'Exceção crítica do sistema',
                'color'  => 15158332,
                'fields' => [
                    ['name' => 'Exceção', 'value' => $systemErrorAlert->exception_class, 'inline' => false],
                    ['name' => 'Mensagem', 'value' => $systemErrorAlert->message ?: 'Sem mensagem disponível.', 'inline' => false],
                    ['name' => 'Local', 'value' => $location, 'inline' => false],
                    ['name' => 'Método', 'value' => $systemErrorAlert->request_method ?? 'N/A', 'inline' => true],
                    ['name' => 'Rota', 'value' => $systemErrorAlert->route_name ?? 'N/A', 'inline' => true],
                    ['name' => 'ID da Requisição', 'value' => $systemErrorAlert->request_id ?? 'N/A', 'inline' => true],
                    ['name' => 'Usuário', 'value' => $this->formatUser($systemErrorAlert->user), 'inline' => false],
                    ['name' => 'URL', 'value' => $systemErrorAlert->request_url ?? 'N/A', 'inline' => false],
                    ['name' => 'Ocorrências', 'value' => (string) $systemErrorAlert->occurrences, 'inline' => true],
                    ['name' => 'Detalhes', 'value' => $alertUrl, 'inline' => false],
                    ['name' => 'Rastreio (resumo)', 'value' => $traceSummary, 'inline' => false],
                ],
                'timestamp' => now()->toIso8601String(),
            ]],
        ]);
    }

    /**
     * @param array{content: string, embeds: array<int, array<string, mixed>>} $payload
     * @return array{content: string, embeds: array<int, array<string, mixed>>}
     */
    private function sanitizePayload(array $payload): array
    {
        $sanitizer = new AlertSanitizer($payload);
        $embeds    = [];

        foreach (array_slice($payload['embeds'], 0, 1) as $embed) {
            $fields = [];

            $rawFields = $embed['fields'] ?? [];

            foreach (array_slice(is_array($rawFields) ? $rawFields : [], 0, 12) as $field) {
                if (!is_array($field)) {
                    continue;
                }

                $value = $this->payloadString($field['value'] ?? 'N/A');

                if (($field['name'] ?? '') === 'URL') {
                    $value = $sanitizer->url($value) ?? 'N/A';
                }

                if (($field['name'] ?? '') === 'Rastreio (resumo)') {
                    $value = $sanitizer->trace($value) ?? 'N/A';
                }

                $fields[] = [
                    'name'   => $sanitizer->text($this->payloadString($field['name'] ?? 'N/A'), 80),
                    'value'  => $sanitizer->text($value, 400),
                    'inline' => (bool) ($field['inline'] ?? false),
                ];
            }

            $embeds[] = [
                'title'     => $sanitizer->text($this->payloadString($embed['title'] ?? '', ''), 200),
                'color'     => is_numeric($embed['color'] ?? null) ? (int) $embed['color'] : 15158332,
                'fields'    => $fields,
                'timestamp' => $sanitizer->text($this->payloadString($embed['timestamp'] ?? now()->toIso8601String()), 40),
            ];
        }

        return ['content' => $sanitizer->text($payload['content'], 500) ?? '', 'embeds' => $embeds];
    }

    private function shouldReport(Throwable $throwable): bool
    {
        /** @var array<int, class-string<Throwable>> $ignoredExceptions */
        $ignoredExceptions = config('alerts.discord.ignored_exceptions', []);

        foreach ($ignoredExceptions as $ignoredException) {
            if ($throwable instanceof $ignoredException) {
                return false;
            }
        }

        if ($throwable instanceof HttpExceptionInterface) {
            return $throwable->getStatusCode() >= 500;
        }

        return true;
    }

    private function isEnabled(): bool
    {
        return (bool) config('alerts.discord.enabled') && $this->payloadString(config('alerts.discord.webhook_url'), '') !== '';
    }

    private function wasRecentlyReported(string $fingerprint): bool
    {
        $throttleSeconds = config()->integer('alerts.discord.throttle_seconds', 60);

        if ($throttleSeconds <= 0) {
            return false;
        }

        return !Cache::add("alerts:discord:{$fingerprint}", true, now()->addSeconds($throttleSeconds));
    }

    private function fingerprint(Throwable $throwable, ?Request $request): string
    {
        return hash('sha256', implode('|', [
            $throwable::class,
            $throwable->getMessage(),
            $throwable->getFile(),
            $request?->method() ?? 'N/A',
            $request?->path() ?? 'N/A',
        ]));
    }

    /** @return array<string, mixed>
     * @param array<string, mixed> $extraContext */
    private function buildUpsertAttributes(Throwable $throwable, array $extraContext = []): array
    {
        $request = $this->resolveRequest();
        $trace   = implode("\n", array_map(
            static fn (array $frame, int $index): string => sprintf(
                '#%d %s(%s): %s%s%s()',
                $index,
                $frame['file'] ?? '[internal function]',
                $frame['line'] ?? '?',
                $frame['class'] ?? '',
                $frame['type'] ?? '',
                $frame['function'],
            ),
            $throwable->getTrace(),
            array_keys($throwable->getTrace()),
        ));
        $runtimeContext = $this->buildRuntimeContext($throwable);
        $context        = array_merge(
            $this->buildSanitizedContext($request),
            $runtimeContext,
            $extraContext,
        );
        $sanitizer = new AlertSanitizer([
            'request' => $request?->all() ?? [],
            'headers' => $request?->headers->all() ?? [],
            'context' => $context,
        ]);

        $isCliRuntime  = isset($runtimeContext['queue_worker']) || isset($runtimeContext['queue_last_jobs']);
        $worker        = $runtimeContext['queue_worker'] ?? null;
        $workerCommand = is_array($worker) && is_string($worker['command'] ?? null) ? $worker['command'] : null;

        return [
            'fingerprint'     => $this->fingerprint($throwable, $request),
            'severity'        => $this->resolveSeverity($throwable),
            'environment'     => app()->environment(),
            'exception_class' => $throwable::class,
            'message'         => $sanitizer->text($throwable->getMessage() ?: 'Sem mensagem disponível.', $sanitizer->limit('message_limit', 4000)),
            'file'            => $sanitizer->text($throwable->getFile(), 255),
            'line'            => $throwable->getLine(),
            'route_name'      => $sanitizer->text($request?->route()?->getName() ?? $request?->path() ?? ($isCliRuntime ? 'queue-worker' : null), 255),
            'request_method'  => $request?->method() ?? ($isCliRuntime ? 'CLI' : null),
            'request_url'     => $request instanceof Request ? $sanitizer->url($request->fullUrl()) : $sanitizer->text($workerCommand),
            'request_id'      => $sanitizer->text($request?->header('X-Request-Id'), 255),
            'user_id'         => Auth::id(),
            'context'         => $sanitizer->context($context),
            'trace'           => $sanitizer->trace($trace),
            'occurred_at'     => now(),
        ];
    }

    /** @return array<string, mixed> */
    private function buildRuntimeContext(Throwable $throwable): array
    {
        if (!$throwable instanceof ProcessTimedOutException) {
            return [];
        }

        $command = $this->extractTimedOutCommand($throwable);
        $queues  = $this->extractQueueNamesFromCommand($command);

        $lastJobs = [];

        foreach ($queues as $queue) {
            $cacheKey = "alerts:queue:last-job:database:{$queue}";

            try {
                $cachedJob = Cache::get($cacheKey);
            } catch (Throwable) {
                continue;
            }

            if (!is_array($cachedJob)) {
                continue;
            }

            $lastJobs[$queue] = $cachedJob;
        }

        return [
            'queue_worker' => [
                'command' => $command,
                'queues'  => $queues,
            ],
            'queue_last_jobs' => $lastJobs,
        ];
    }

    private function extractTimedOutCommand(ProcessTimedOutException $throwable): string
    {
        $message = $throwable->getMessage();

        if (preg_match('/The process "(?P<command>.+)" exceeded/', $message, $matches) === 1) {
            return (string) $matches['command'];
        }

        return $message;
    }

    /** @return array<int, string> */
    private function extractQueueNamesFromCommand(string $command): array
    {
        if (preg_match('/--queue=(?P<queues>[^\s\'"]+)/', $command, $matches) !== 1) {
            return [];
        }

        $queueNames = array_filter(array_map(
            trim(...),
            explode(',', (string) $matches['queues']),
        ));

        return array_values(array_unique($queueNames));
    }

    private function resolveRequest(): ?Request
    {
        if (!app()->bound('request')) {
            return null;
        }

        return request();
    }

    private function buildTraceSummary(?string $trace): string
    {
        if (!is_string($trace) || $trace === '') {
            return 'Rastreio indisponível.';
        }

        $traceLines   = explode("\n", new AlertSanitizer()->trace($trace) ?? '');
        $limit        = max(config()->integer('alerts.discord.trace_lines', 12), 1);
        $traceSummary = implode("\n", array_slice($traceLines, 0, $limit));

        return $this->truncate($traceSummary, 1000);
    }

    private function resolveSeverity(Throwable $throwable): SystemErrorAlertSeverities
    {
        if ($throwable instanceof HttpExceptionInterface && $throwable->getStatusCode() >= 503) {
            return SystemErrorAlertSeverities::Emergency;
        }

        return SystemErrorAlertSeverities::Critical;
    }

    private function getAlertUrl(SystemErrorAlert $systemErrorAlert): string
    {
        if (!app()->bound('router') || !Route::has('support.system-error-alerts.show')) {
            return 'N/A';
        }

        return route('support.system-error-alerts.show', $systemErrorAlert);
    }

    /** @return array<string, mixed> */
    private function buildSanitizedContext(?Request $request): array
    {
        if (!$request instanceof Request) {
            return [];
        }

        return [
            'ip'         => $request->ip(),
            'user_agent' => $request->userAgent(),
            'query'      => $this->sanitizeRecursive($request->query()),
            'request'    => $this->sanitizeRecursive($request->except(['password', 'password_confirmation'])),
        ];
    }

    /** @param array<array-key, mixed> $data
     * @return array<array-key, mixed>
     */
    private function sanitizeRecursive(array $data): array
    {
        return new AlertSanitizer($data)->context($data);
    }

    private function truncate(string $value, int $limit): string
    {
        return mb_strlen($value) <= $limit
            ? $value
            : mb_substr($value, 0, $limit - 3) . '...';
    }

    private function formatUser(mixed $user): string
    {
        if (!is_object($user)) {
            return 'Não autenticado';
        }

        $identifier = method_exists($user, 'getAuthIdentifier') ? $user->getAuthIdentifier() : null;
        $id         = $this->payloadString($identifier);

        $email = data_get($user, 'email');

        if (is_string($email) && $email !== '') {
            return "{$id} ({$email})";
        }

        return $id;
    }

    private function payloadString(mixed $value, string $default = 'N/A'): string
    {
        return is_scalar($value) ? (string) $value : $default;
    }
}
