<?php

declare(strict_types = 1);

use App\Enums\SystemErrorAlertSeverities;
use App\Enums\SystemErrorAlertStatuses;
use App\Models\SystemErrorAlert;
use App\Models\User;
use App\Queries\SystemErrorAlertsQuery;
use Illuminate\Support\Carbon;

it('combines status severity and environment filters', function (): void {
    $criteria = [
        'status'      => SystemErrorAlertStatuses::Open,
        'severity'    => SystemErrorAlertSeverities::Critical,
        'environment' => 'production',
    ];
    $matching = SystemErrorAlert::factory()->create($criteria);
    SystemErrorAlert::factory()->create([...$criteria, 'status' => SystemErrorAlertStatuses::Resolved]);
    SystemErrorAlert::factory()->create([...$criteria, 'severity' => SystemErrorAlertSeverities::Emergency]);
    SystemErrorAlert::factory()->create([...$criteria, 'environment' => 'homolog']);

    $alerts = app(SystemErrorAlertsQuery::class)->paginate(
        status: SystemErrorAlertStatuses::Open->value,
        severity: SystemErrorAlertSeverities::Critical->value,
        environment: 'production',
    );

    expect($alerts->total())->toBe(1);
    expect($alerts->getCollection()->sole()->is($matching))->toBeTrue();
});

it('searches alert fields without accents or case without escaping the selected filters', function (string $field, string $search): void {
    $attributes = [
        'environment'     => 'production',
        'status'          => SystemErrorAlertStatuses::Open,
        'severity'        => SystemErrorAlertSeverities::Critical,
        'exception_class' => 'RuntimeException',
        'message'         => 'A plain failure',
        'request_url'     => 'https://example.test/orders',
        $field            => 'João da Conceição 0',
    ];
    $matching = SystemErrorAlert::factory()->create($attributes);
    SystemErrorAlert::factory()->create([...$attributes, 'environment' => 'homolog']);
    SystemErrorAlert::factory()->create([...$attributes, 'status' => SystemErrorAlertStatuses::Resolved]);
    SystemErrorAlert::factory()->create([...$attributes, 'severity' => SystemErrorAlertSeverities::Emergency]);
    SystemErrorAlert::factory()->create([
        'environment'     => 'production',
        'status'          => SystemErrorAlertStatuses::Open,
        'severity'        => SystemErrorAlertSeverities::Critical,
        'exception_class' => 'LogicException',
        'message'         => 'Another failure',
        'request_url'     => 'https://example.test/users',
    ]);

    $alerts = app(SystemErrorAlertsQuery::class)->paginate(search: $search, status: SystemErrorAlertStatuses::Open->value, severity: SystemErrorAlertSeverities::Critical->value, environment: 'production');

    expect($alerts->total())->toBe(1);
    expect($alerts->getCollection()->sole()->is($matching))->toBeTrue();
})->with(['exception_class', 'message', 'request_url'])->with(['joao', 'JOÃO', 'CONCEICAO', '0']);

it('sorts and paginates alerts with an accurate total', function (): void {
    SystemErrorAlert::factory()->create(['occurrences' => 3]);
    $first  = SystemErrorAlert::factory()->create(['occurrences' => 1]);
    $second = SystemErrorAlert::factory()->create(['occurrences' => 2]);

    $alerts = app(SystemErrorAlertsQuery::class)->paginate(
        sortBy: 'occurrences',
        sortDirection: 'desc',
        perPage: 2,
        page: 2,
    );

    expect($alerts->total())->toBe(3);
    expect($alerts->currentPage())->toBe(2);
    expect($alerts->lastPage())->toBe(2);
    expect($alerts->getCollection()->modelKeys())->toBe([$first->id]);

    $ascending = app(SystemErrorAlertsQuery::class)->paginate(sortBy: 'occurrences', sortDirection: 'asc', perPage: 2);
    expect($ascending->getCollection()->modelKeys())->toBe([$first->id, $second->id]);
});

it('loads associated users and orders the newest occurrences first by default', function (): void {
    $user  = User::factory()->create();
    $older = SystemErrorAlert::factory()->create(['last_seen_at' => Carbon::parse('2026-01-01 10:00:00')]);
    $newer = SystemErrorAlert::factory()->create(['last_seen_at' => Carbon::parse('2026-01-02 10:00:00'), 'user_id' => $user->id]);

    $alerts = app(SystemErrorAlertsQuery::class)->paginate();

    expect($alerts->getCollection()->modelKeys())->toBe([$newer->id, $older->id]);
    $loaded = $alerts->getCollection()->first();
    expect($loaded->relationLoaded('user'))->toBeTrue();
    expect($loaded->user->is($user))->toBeTrue();
});

it('returns distinct ordered environments independently of the current result filters', function (): void {
    SystemErrorAlert::factory()->create(['environment' => 'homolog']);
    SystemErrorAlert::factory()->count(2)->create(['environment' => 'production']);

    $query = app(SystemErrorAlertsQuery::class);
    expect($query->paginate(environment: 'unavailable')->total())->toBe(0);
    expect($query->environments())->toBe(['homolog' => 'homolog', 'production' => 'production']);
});
