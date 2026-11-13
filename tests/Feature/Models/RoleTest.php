<?php

declare(strict_types = 1);

use App\Models\Role;

it('returns users relation', function (): void {
    $role = Role::factory()->make();

    expect($role->users()->getForeignKeyName())->toBe('role_id');
});

it('returns permissions relation from trait', function (): void {
    $role = Role::factory()->make();

    expect($role->permissions()->getTable())->toBe('permission_role');
});
