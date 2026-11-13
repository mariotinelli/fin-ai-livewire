<?php

declare(strict_types = 1);

use App\Enums\Permissions\Management\RolePermissions;
use App\Enums\Permissions\Management\UserPermissions;
use App\Enums\TypeUsers;
use App\Models\Role;
use App\Models\User;
use App\Policies\RolePolicy;
use Illuminate\Support\Facades\Gate;

it('allows only admins and authorized support users to create roles', function (TypeUsers $type, bool $hasPermission, bool $expected): void {
    $actor = User::factory()->create(['type' => $type]);

    if ($hasPermission) {
        $actor->givePermissionTo(RolePermissions::Create);
    }

    expect(Gate::forUser($actor)->allows('create', Role::class))->toBe($expected);
})->with([
    'admin without explicit permission' => [TypeUsers::Admin, false, true],
    'support with permission'           => [TypeUsers::SupportRemSoft, true, true],
    'support without permission'        => [TypeUsers::SupportRemSoft, false, false],
    'user with permission'              => [TypeUsers::User, true, false],
    'customer with permission'          => [TypeUsers::Customer, true, false],
]);

it('limits support role creation to permissions it owns', function (): void {
    $support = User::factory()->create(['type' => TypeUsers::SupportRemSoft]);
    $support->givePermissionTo([RolePermissions::Create, RolePermissions::View]);

    expect(Gate::forUser($support)->allows('create', [Role::class, [RolePermissions::View->value]]))->toBeTrue()
        ->and(Gate::forUser($support)->allows('create', [Role::class, [UserPermissions::Edit->value]]))->toBeFalse();
});

it('allows support to update only non-privileged roles outside its own role', function (string $target, bool $expected): void {
    $support = User::factory()->create(['type' => TypeUsers::SupportRemSoft]);
    $support->givePermissionTo([RolePermissions::Edit, RolePermissions::View]);

    $role = match ($target) {
        'own'     => $support->role,
        'support' => tap(Role::factory()->create(), fn (Role $role) => User::factory()->create([
            'type'    => TypeUsers::SupportRemSoft,
            'role_id' => $role->id,
        ])),
        'admin' => tap(Role::factory()->create(), fn (Role $role) => User::factory()->create([
            'type'    => TypeUsers::Admin,
            'role_id' => $role->id,
        ])),
        default => Role::factory()->create(),
    };

    expect(Gate::forUser($support)->allows('update', [$role, [RolePermissions::View->value]]))->toBe($expected);
})->with([
    'regular role'       => ['regular', true],
    'own role'           => ['own', false],
    'support role'       => ['support', false],
    'administrator role' => ['admin', false],
]);

it('prevents support from adding an unowned permission while updating a role', function (): void {
    $support = User::factory()->create(['type' => TypeUsers::SupportRemSoft]);
    $support->givePermissionTo(RolePermissions::Edit);

    $role = Role::factory()->create();

    expect(Gate::forUser($support)->allows('update', [$role, [UserPermissions::Create->value]]))->toBeFalse();
});

it('allows admins to manage roles regardless of assignments and permission selection', function (): void {
    $admin = User::factory()->admin()->create();
    $role  = Role::factory()->create();
    User::factory()->create(['type' => TypeUsers::SupportRemSoft, 'role_id' => $role->id]);

    expect(Gate::forUser($admin)->allows('create', [Role::class, [UserPermissions::Edit->value]]))->toBeTrue()
        ->and(Gate::forUser($admin)->allows('update', [$role, [UserPermissions::Edit->value]]))->toBeTrue();
});

it('rejects selected permissions when support has no assigned role', function (): void {
    $support = Mockery::mock(User::class)->makePartial();
    $support->shouldReceive('isSupportRemSoft')->once()->andReturnTrue();
    $support->shouldReceive('hasPermissionTo')->once()->with(RolePermissions::Create)->andReturnTrue();

    if (!$support instanceof User) {
        throw new RuntimeException('The partial mock must retain the user type.');
    }

    $support->setRelation('role', null);

    expect(new RolePolicy()->create($support, [RolePermissions::View->value]))->toBeFalse();
});
