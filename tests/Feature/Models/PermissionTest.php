<?php

declare(strict_types = 1);

use App\Models\Permission;

it('returns users relation', function (): void {
    $permission = Permission::factory()->make();

    expect($permission->users()->getTable())->toBe('permission_user');
});
