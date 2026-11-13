<?php

declare(strict_types = 1);

use App\Livewire\Auth\Profile\EditProfile;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

it('renders edit profile component', function (): void {
    /** @var User $user */
    $user = User::factory()->create();
    actingAs($user);

    livewire(EditProfile::class)
        ->assertStatus(200);
});
