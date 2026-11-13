<?php

declare(strict_types = 1);

use App\Models\Role;

it('matches partial text regardless of accents or case', function (string $term): void {
    $role = Role::factory()->create(['name' => 'Gestão de João']);
    Role::factory()->create(['name' => 'Financeiro']);

    expect(Role::query()->whereInsensitive('name', $term)->pluck('id')->all())->toBe([$role->id]);
})->with(['joao', 'JOÃO', 'gestao', 'GESTÃO']);

it('treats SQL and pattern characters as literal text', function (string $term): void {
    $role = Role::factory()->create(['name' => 'Prefixo ' . $term . ' sufixo']);
    Role::factory()->create(['name' => 'Outra opção']);

    expect(Role::query()->whereInsensitive('name', $term)->pluck('id')->all())->toBe([$role->id]);
})->with(['%', '_', '!', "O'Reilly", "' OR 1=1 --", '50%_done!', '\\']);

it('supports literal partial searches on numeric columns', function (): void {
    $role = Role::factory()->create(['id' => 9876501]);
    Role::factory()->create(['id' => 9876502]);

    expect(Role::query()->whereInsensitive('id', '6501')->pluck('id')->all())->toBe([$role->id]);
});
