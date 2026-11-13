<?php

declare(strict_types = 1);

use App\Jobs\SendDiscordCriticalAlertJob;
use App\Models\SystemErrorAlert;
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

it('persists critical error alert and dispatches discord job', function (): void {
    report(new RuntimeException('Erro crítico de conexão com banco.'));

    $alert = SystemErrorAlert::query()->first();

    expect($alert)->not->toBeNull()
        ->and($alert?->message)->toBe('Erro crítico de conexão com banco.')
        ->and($alert?->occurrences)->toBe(1);

    Queue::assertPushed(SendDiscordCriticalAlertJob::class, function (SendDiscordCriticalAlertJob $job) use ($alert): bool {
        $detailsField = collect($job->payload['embeds'][0]['fields'] ?? [])
            ->first(fn (array $field): bool => ($field['name'] ?? null) === 'Detalhes');

        return is_array($detailsField)
            && str_contains((string) ($detailsField['value'] ?? ''), (string) $alert?->id);
    });
});

it('does not persist ignored exceptions', function (): void {
    $validator = Validator::make([], ['name' => ['required']]);

    report(new ValidationException($validator));

    expect(SystemErrorAlert::query()->count())->toBe(0);
    Queue::assertNothingPushed();
});

it('increments occurrences for repeated fingerprint', function (): void {
    report(new RuntimeException('Falha crítica repetida.'));
    report(new RuntimeException('Falha crítica repetida.'));

    $alert = SystemErrorAlert::query()->first();

    expect($alert)->not->toBeNull()
        ->and($alert?->occurrences)->toBe(2);
});
