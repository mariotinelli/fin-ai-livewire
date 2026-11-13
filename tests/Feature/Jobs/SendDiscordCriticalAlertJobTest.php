<?php

declare(strict_types = 1);

use App\Jobs\SendDiscordCriticalAlertJob;
use App\Models\SystemErrorAlert;
use App\Support\Alerts\DiscordAlert;
use App\Support\Alerts\DiscordAlertDeliveryException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Request;
use Illuminate\Http\Client\RequestException;
use Illuminate\Queue\Worker;
use Illuminate\Queue\WorkerOptions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;

it('encrypts the queued snapshot and preserves it across retries until successful delivery', function (): void {
    config()->set('alerts.discord.enabled', true);
    config()->set('alerts.discord.webhook_url', 'https://discord.test/webhook');
    config()->set('alerts.discord.retry_times', 1);
    config()->set('alerts.discord.retry_sleep_ms', 0);

    $startedAt = now()->startOfSecond();
    $this->travelTo($startedAt);
    Http::preventStrayRequests();
    Http::fake([
        'https://discord.test/webhook' => Http::sequence()
            ->push([], 500)
            ->push([], 500)
            ->push([], 204),
    ]);
    $sentinel = 'SensitiveSnapshotSentinel-RSP108';
    $alert    = SystemErrorAlert::factory()->create(['message' => $sentinel, 'last_notified_at' => null]);
    $snapshot = app(DiscordAlert::class)->buildPayload($alert);
    $queue    = 'discord-alert-retry-success';
    Queue::connection('database')->push(
        new SendDiscordCriticalAlertJob($alert->getKey(), $snapshot),
        queue: $queue,
    );

    expect(json_encode($snapshot, JSON_THROW_ON_ERROR))->toContain($sentinel);
    expect(DB::table('jobs')->where('queue', $queue)->sole()->payload)->not->toContain($sentinel);

    $alert->update(['message' => 'Changed after dispatch', 'occurrences' => 50]);
    /** @var Worker $worker */
    $worker  = app('queue.worker');
    $options = new WorkerOptions(sleep: 0, maxTries: 0);

    $worker->runNextJob('database', $queue, $options);

    expect($alert->refresh()->last_notified_at)->toBeNull();
    expect(DB::table('jobs')->where('queue', $queue)->count())->toBe(1);
    expect(DB::table('jobs')->where('queue', $queue)->sole()->payload)->not->toContain($sentinel);

    $alert->update(['message' => 'Changed before retry', 'occurrences' => 100]);

    $this->travel(10)->seconds();
    $worker->runNextJob('database', $queue, $options);

    expect($alert->refresh()->last_notified_at)->toBeNull();
    expect(DB::table('jobs')->where('queue', $queue)->count())->toBe(1);

    $this->travel(30)->seconds();
    $worker->runNextJob('database', $queue, $options);

    expect($alert->refresh()->last_notified_at?->toDateTimeString())
        ->toBe($startedAt->copy()->addSeconds(40)->toDateTimeString());
    expect(DB::table('jobs')->where('queue', $queue)->count())->toBe(0);
    Http::assertSentCount(3);
    Http::assertNotSent(fn (Request $request): bool => $request->data() !== $snapshot);
});

it('records exhaustion without creating a recursive discord alert', function (): void {
    config()->set('alerts.discord.enabled', true);
    config()->set('alerts.discord.webhook_url', 'https://discord.test/webhook');
    config()->set('alerts.discord.retry_times', 1);
    config()->set('alerts.discord.retry_sleep_ms', 0);
    $this->freezeTime();
    Http::preventStrayRequests();
    Http::fake([
        'https://discord.test/webhook' => Http::sequence()
            ->push([], 500)
            ->push([], 500)
            ->push([], 500),
    ]);
    $alert = SystemErrorAlert::factory()->create(['last_notified_at' => null]);
    $queue = 'discord-alert-retry-exhaustion';
    Queue::connection('database')->push(
        new SendDiscordCriticalAlertJob($alert->getKey(), ['content' => 'Critical alert', 'embeds' => []]),
        queue: $queue,
    );
    Log::shouldReceive('error')->once()->with(
        'Esgotadas as tentativas de envio do alerta crítico para o Discord.',
        Mockery::on(static fn (array $context): bool => $context['system_error_alert_id'] === $alert->getKey()
            && $context['exception'] === RequestException::class
            && str_contains($context['message'], 'status code 500')),
    );
    /** @var Worker $worker */
    $worker  = app('queue.worker');
    $options = new WorkerOptions(sleep: 0, maxTries: 0);

    $worker->runNextJob('database', $queue, $options);
    $this->travel(10)->seconds();
    $worker->runNextJob('database', $queue, $options);
    $this->travel(30)->seconds();
    $worker->runNextJob('database', $queue, $options);

    expect($alert->refresh()->last_notified_at)->toBeNull()
        ->and(SystemErrorAlert::query()->count())->toBe(1);
    expect(DB::table('jobs')->where('queue', $queue)->count())->toBe(0);
    Http::assertSentCount(3);
});

it('does not confirm delivery when discord is disabled before execution', function (): void {
    config()->set('alerts.discord.enabled', false);
    config()->set('alerts.discord.webhook_url', 'https://discord.test/webhook');
    Http::preventStrayRequests();
    Http::fake();
    $alert = SystemErrorAlert::factory()->create(['last_notified_at' => null]);
    $job   = new SendDiscordCriticalAlertJob(
        $alert->getKey(),
        ['content' => 'Critical alert', 'embeds' => []],
    );

    $job->handle(app(DiscordAlert::class));

    expect($alert->refresh()->last_notified_at)->toBeNull();
    Http::assertNothingSent();
});

it('redacts the webhook URL and token from transport failures while preserving diagnostics', function (string $format): void {
    $token = 'WEBHOOK_SENTINEL+private';
    $url   = 'https://discord.test/api/webhooks/123/' . rawurlencode($token);
    config()->set('alerts.discord.webhook_url', $url);
    $sensitiveValue = match ($format) {
        'URL'            => $url,
        'encoded URL'    => rawurlencode($url),
        'token'          => $token,
        'encoded token'  => rawurlencode($token),
        'URL with query' => $url . '?wait=true',
        default          => throw new InvalidArgumentException('Unknown webhook failure format: ' . $format),
    };
    $failure = new ConnectionException('cURL error 28: timeout for ' . $sensitiveValue . ' (status 503)');
    $job     = new SendDiscordCriticalAlertJob(123, ['content' => 'Alert', 'embeds' => []]);
    $log     = Log::spy();

    $job->failed($failure);

    $log->shouldHaveReceived('error')->once()->with(
        Mockery::type('string'),
        Mockery::on(function (array $context) use ($token, $url): bool {
            expect($context)->toMatchArray(['system_error_alert_id' => 123, 'exception' => ConnectionException::class]);
            expect($context['message'])->toContain('cURL error 28', 'timeout', 'status 503', '**********');
            expect(json_encode($context, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES))
                ->not->toContain($url, rawurlencode($url), $token, rawurlencode($token));

            return true;
        }),
    );
})->with(['URL', 'encoded URL', 'token', 'encoded token', 'URL with query']);

it('sanitizes the root cause of chained delivery failures', function (): void {
    $url = 'https://discord.test/api/webhooks/123/CHAINED_WEBHOOK_SENTINEL';
    config()->set('alerts.discord.webhook_url', $url);
    $root      = new ConnectionException('Timeout while posting to ' . $url);
    $transport = new RuntimeException('Transport wrapper', previous: $root);
    $failure   = new DiscordAlertDeliveryException('Delivery wrapper', previous: $transport);
    $job       = new SendDiscordCriticalAlertJob(123, ['content' => 'Alert', 'embeds' => []]);
    $log       = Log::spy();

    $job->failed($failure);

    $log->shouldHaveReceived('error')->once()->with(Mockery::type('string'), [
        'system_error_alert_id' => 123,
        'exception'             => ConnectionException::class,
        'message'               => 'Timeout while posting to **********',
    ]);
});

it('logs a missing failure without inventing exception details', function (): void {
    config()->set('alerts.discord.webhook_url');
    $job = new SendDiscordCriticalAlertJob(123, ['content' => 'Alert', 'embeds' => []]);
    $log = Log::spy();

    $job->failed(null);

    $log->shouldHaveReceived('error')->once()->with(Mockery::type('string'), [
        'system_error_alert_id' => 123,
        'exception'             => null,
        'message'               => null,
    ]);
});

it('preserves safe failure details when the webhook is not configured', function (): void {
    config()->set('alerts.discord.webhook_url', '');
    $job = new SendDiscordCriticalAlertJob(123, ['content' => 'Alert', 'embeds' => []]);
    $log = Log::spy();

    $job->failed(new RuntimeException('Connection refused on port 443'));

    $log->shouldHaveReceived('error')->once()->with(Mockery::type('string'), [
        'system_error_alert_id' => 123,
        'exception'             => RuntimeException::class,
        'message'               => 'Connection refused on port 443',
    ]);
});
