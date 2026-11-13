<?php

declare(strict_types = 1);

use App\Enums\SystemErrorAlertSeverities;
use App\Enums\SystemErrorAlertStatuses;
use App\Models\SystemErrorAlert;
use App\Models\User;
use Illuminate\Database\UniqueConstraintViolationException;

it('rejects a second group with the same fingerprint and environment', function (): void {
    $alert = SystemErrorAlert::factory()->create();

    expect(fn () => SystemErrorAlert::factory()->create([
        'fingerprint' => $alert->fingerprint,
        'environment' => $alert->environment,
    ]))->toThrow(UniqueConstraintViolationException::class);
});

it('reads the alert owner and persisted alert state', function (): void {
    $user  = User::factory()->create();
    $alert = SystemErrorAlert::factory()->for($user)->create([
        'status'   => SystemErrorAlertStatuses::Acknowledged,
        'severity' => SystemErrorAlertSeverities::Critical,
        'context'  => ['request' => 'context'],
    ])->refresh();

    expect($alert->user->is($user))->toBeTrue()
        ->and($alert->status)->toBe(SystemErrorAlertStatuses::Acknowledged)
        ->and($alert->severity)->toBe(SystemErrorAlertSeverities::Critical)
        ->and($alert->context)->toBe(['request' => 'context']);
});

it('retains consolidated source records and their original audit links', function (): void {
    $history = [[
        'attributes' => ['id' => 42, 'occurrences' => 8, 'trace' => 'Original trace', 'context' => '{"source":"original"}'],
        'audit_ids'  => [5, 8],
    ]];
    $alert = SystemErrorAlert::factory()->create(['consolidated_history' => $history]);

    expect($alert->refresh()->consolidated_history)->toEqual($history);
});
