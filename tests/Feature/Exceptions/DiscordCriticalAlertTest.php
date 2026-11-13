<?php

declare(strict_types = 1);

use App\Jobs\SendDiscordCriticalAlertJob;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

beforeEach(function (): void {
    config()->set('alerts.discord.enabled', true);
    config()->set('alerts.discord.webhook_url', 'https://discord.test/webhook');
    config()->set('alerts.discord.throttle_seconds', 60);

    cache()->flush();
    Queue::fake();
});

it('dispatches discord alert job for critical exceptions', function (): void {
    report(new RuntimeException('Critical failure in billing.'));

    Queue::assertPushed(SendDiscordCriticalAlertJob::class, 1);
});

it('does not dispatch when current environment is not enabled', function (): void {
    config()->set('alerts.discord.enabled', false);

    report(new RuntimeException('Critical failure in billing.'));

    Queue::assertNotPushed(SendDiscordCriticalAlertJob::class);
});

it('does not dispatch discord alert job for ignored exceptions', function (): void {
    $validator = Validator::make([], ['name' => ['required']]);
    $exception = new ValidationException($validator);

    report($exception);

    Queue::assertNothingPushed();
});

it('throttles duplicate critical exceptions in the configured window', function (): void {
    report(new RuntimeException('Critical failure in queue worker.'));
    report(new RuntimeException('Critical failure in queue worker.'));

    Queue::assertPushed(SendDiscordCriticalAlertJob::class, 1);
});
