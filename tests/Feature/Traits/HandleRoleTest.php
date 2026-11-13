<?php

declare(strict_types = 1);

use App\Enums\Permissions\Management\UserPermissions;
use App\Enums\TypeUsers;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;

it('grants permissions to admins without a role', function (): void {
    $user = User::factory()->admin()->create(['role_id' => null]);

    expect($user->hasPermissionTo(UserPermissions::Delete))->toBeTrue();
});

it('denies permissions to support users without a role', function (): void {
    $user = User::factory()->create(['type' => TypeUsers::SupportRemSoft, 'role_id' => null]);

    expect($user->hasPermissionTo(UserPermissions::Delete))->toBeFalse();
});

it('returns false when user has no role', function (): void {
    $user = User::factory()->user()->create(['role_id' => null]);

    expect($user->hasPermissionTo(UserPermissions::View))->toBeFalse();
});

it('returns true when user is admin and has role', function (): void {
    $role = Role::factory()->create();
    $user = User::factory()->create([
        'type'    => TypeUsers::Admin,
        'role_id' => $role->id,
    ]);

    expect($user->hasPermissionTo(UserPermissions::Delete))->toBeTrue();
});

it('checks permissions from role for non admin users', function (): void {
    Permission::query()->firstOrCreate(['name' => UserPermissions::View->value]);
    $role = Role::factory()->create();
    $role->givePermissionTo(UserPermissions::View);

    $user = User::factory()->user()->create(['role_id' => $role->id]);

    expect($user->hasPermissionTo(UserPermissions::View))->toBeTrue()
        ->and($user->hasPermissionTo(UserPermissions::Edit))->toBeFalse();
});

it('delegates give and revoke permission to role', function (): void {
    Permission::query()->firstOrCreate(['name' => UserPermissions::Create->value]);

    $role = Role::factory()->create();
    $user = User::factory()->user()->create(['role_id' => $role->id]);

    $user->givePermissionTo(UserPermissions::Create);

    expect($role->fresh()->hasPermissionTo(UserPermissions::Create))->toBeTrue();

    $user->revokePermissionTo(UserPermissions::Create);

    expect($role->fresh()->hasPermissionTo(UserPermissions::Create))->toBeFalse();
});

it('ignores give and revoke permission when user has no role or permission is empty', function (): void {
    $userWithoutRole = User::factory()->user()->create(['role_id' => null]);

    $userWithoutRole->givePermissionTo([]);
    $userWithoutRole->revokePermissionTo([]);

    expect($userWithoutRole->role)->toBeNull();
});
