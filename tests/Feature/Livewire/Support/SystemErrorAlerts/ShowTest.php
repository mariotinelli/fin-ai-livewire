<?php

declare(strict_types = 1);

use App\Enums\SystemErrorAlertStatuses;
use App\Enums\TypeUsers;
use App\Livewire\Support\SystemErrorAlerts\Show;
use App\Models\SystemErrorAlert;
use App\Models\User;

use function Pest\Laravel\actingAs;

use function Pest\Livewire\livewire;

it('forbids access when user type is not support rem soft', function (): void {
    $alert = SystemErrorAlert::factory()->create();

    actingAs(User::factory()->admin()->create());

    livewire(Show::class, ['systemErrorAlert' => $alert])
        ->assertForbidden();
});

it('updates alert status to acknowledged and resolved', function (): void {
    /** @var User $supportUser */
    $supportUser = User::factory()->create([
        'type' => TypeUsers::SupportRemSoft,
    ]);

    actingAs($supportUser);

    $alert = SystemErrorAlert::factory()->create([
        'status' => SystemErrorAlertStatuses::Open,
    ]);

    livewire(Show::class, ['systemErrorAlert' => $alert])
        ->call('acknowledge')
        ->assertDispatched('toast')
        ->call('resolve')
        ->assertDispatched('toast');

    $alert->refresh();

    expect($alert->status)->toBe(SystemErrorAlertStatuses::Resolved);
});
