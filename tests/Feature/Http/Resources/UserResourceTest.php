<?php

declare(strict_types = 1);

use App\Http\Resources\UserResource;
use App\Models\User;

it('exposes the reusable authenticated user representation', function (): void {
    $user = User::factory()->create([
        'name'  => 'Pessoa Teste',
        'email' => 'pessoa@example.com',
    ]);

    expect(UserResource::make($user)->resolve())->toBe([
        'id'    => $user->id,
        'name'  => 'Pessoa Teste',
        'email' => 'pessoa@example.com',
    ]);
});
