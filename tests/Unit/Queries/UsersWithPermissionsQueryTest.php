<?php

declare(strict_types = 1);

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Queries\UsersWithPermissionsQuery;

it('returns admin users and users with at least one requested permission', function (): void {
    $requestedPermission = Permission::factory()->create([
        'name' => 'permission-requested-' . fake()->uuid(),
    ]);

    $otherPermission = Permission::factory()->create([
        'name' => 'permission-other-' . fake()->uuid(),
    ]);

    $roleWithPermission = Role::factory()->create();
    $roleWithPermission->permissions()->attach($requestedPermission->id);

    $roleWithoutPermission = Role::factory()->create();
    $roleWithoutPermission->permissions()->attach($otherPermission->id);

    $adminUser         = User::factory()->admin()->create();
    $allowedUser       = User::factory()->user()->create(['role_id' => $roleWithPermission->id]);
    $userWithoutAccess = User::factory()->user()->create(['role_id' => $roleWithoutPermission->id]);
    $userWithoutRole   = User::factory()->user()->create(['role_id' => null]);

    $users = app(UsersWithPermissionsQuery::class)->get([$requestedPermission->name]);

    expect($users->pluck('id')->all())
        ->toContain($adminUser->id, $allowedUser->id)
        ->not->toContain($userWithoutAccess->id, $userWithoutRole->id);
});

it('returns only admin users when requested permissions are empty', function (): void {
    $permission = Permission::factory()->create([
        'name' => 'permission-empty-request-' . fake()->uuid(),
    ]);

    $role = Role::factory()->create();
    $role->permissions()->attach($permission->id);

    $adminUser  = User::factory()->admin()->create();
    $normalUser = User::factory()->user()->create(['role_id' => $role->id]);

    $users = app(UsersWithPermissionsQuery::class)->get([]);

    expect($users->pluck('id')->all())
        ->toContain($adminUser->id)
        ->not->toContain($normalUser->id)
        ->and($users)->toHaveCount(1);
});

it('excludes deactivated administrators and permission holders', function (): void {
    $permission = Permission::factory()->create(['name' => 'query-permission']);
    $role       = Role::factory()->create();
    $role->permissions()->attach($permission->id);
    $active       = User::factory()->user()->create(['role_id' => $role->id]);
    $deleted      = User::factory()->user()->create(['role_id' => $role->id]);
    $deletedAdmin = User::factory()->admin()->create();
    $deleted->delete();
    $deletedAdmin->delete();

    $users = app(UsersWithPermissionsQuery::class)->get([$permission->name]);

    expect($users->modelKeys())->toBe([$active->id]);
});
