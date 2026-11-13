<?php

declare(strict_types = 1);

use App\Enums\Permissions\Management\UserPermissions;
use App\Enums\TypeUsers;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

it('preserves policy restrictions for admins without a role', function (): void {
    $admin   = User::factory()->admin()->create(['role_id' => null]);
    $support = User::factory()->create(['type' => TypeUsers::SupportRemSoft]);
    $user    = User::factory()->user()->create();

    expect(Gate::forUser($admin)->allows('update', $user))->toBeTrue()
        ->and(Gate::forUser($admin)->allows('update', $admin))->toBeFalse()
        ->and(Gate::forUser($admin)->allows('delete', $support))->toBeFalse()
        ->and(Gate::forUser($admin)->allows('viewAnyProject', User::class))->toBeFalse();
});

it('enforces the actor and target matrix for user mutations', function (TypeUsers $actorType, bool $permitted, TypeUsers $targetType, string $ability, UserPermissions $permission): void {
    $actor  = User::factory()->create(['type' => $actorType]);
    $target = User::factory()->create(['type' => $targetType]);

    if ($permitted) {
        $actor->givePermissionTo($permission);
    }

    $allowedActors = $permitted
        ? ($ability === 'update'
            ? [TypeUsers::Admin, TypeUsers::SupportRemSoft]
            : [TypeUsers::Admin, TypeUsers::User])
        : [TypeUsers::Admin];

    expect(Gate::forUser($actor)->allows($ability, $target))
        ->toBe($targetType === TypeUsers::User && in_array($actorType, $allowedActors, true));
})->with(TypeUsers::cases())->with([true, false])->with(TypeUsers::cases())->with([
    'edit'       => ['update', UserPermissions::Edit],
    'deactivate' => ['delete', UserPermissions::Delete],
    'restore'    => ['restore', UserPermissions::Restore],
]);

it('keeps list permissions', function (): void {
    $actor = actingAsUser();

    expect(Gate::forUser($actor)->allows('viewAny', User::class))->toBeFalse();

    $actor->givePermissionTo(UserPermissions::View);

    expect(Gate::forUser($actor)->allows('viewAny', User::class))->toBeTrue();
    expect(Gate::forUser(actingAsAdmin())->allows('viewAny', User::class))->toBeTrue();
});

it('allows only admins and authorized support users to create common users', function (TypeUsers $type, bool $hasPermission, bool $expected): void {
    $actor = User::factory()->create(['type' => $type]);

    if ($hasPermission) {
        $actor->givePermissionTo(UserPermissions::Create);
    }

    expect(Gate::forUser($actor)->allows('create', User::class))->toBe($expected);
})->with([
    'admin without explicit permission' => [TypeUsers::Admin, false, true],
    'support with permission'           => [TypeUsers::SupportRemSoft, true, true],
    'support without permission'        => [TypeUsers::SupportRemSoft, false, false],
    'user with permission'              => [TypeUsers::User, true, false],
    'customer with permission'          => [TypeUsers::Customer, true, false],
]);

it('limits support assignments to non-privileged roles whose permissions it owns', function (string $scenario, bool $expected): void {
    $support = User::factory()->create(['type' => TypeUsers::SupportRemSoft]);
    $support->givePermissionTo([UserPermissions::Create, UserPermissions::Edit, UserPermissions::View]);

    $target = User::factory()->user()->create();
    $role   = match ($scenario) {
        'own role'        => $support->role,
        'privileged role' => tap(Role::factory()->create(), fn (Role $role) => User::factory()->create([
            'type'    => TypeUsers::SupportRemSoft,
            'role_id' => $role->id,
        ])),
        'unowned permission' => Role::factory()->withPermissions([UserPermissions::Delete])->create(),
        default              => Role::factory()->withPermissions([UserPermissions::View])->create(),
    };

    expect(Gate::forUser($support)->allows('create', [User::class, $role]))->toBe($expected)
        ->and(Gate::forUser($support)->allows('update', [$target, $role]))->toBe($expected);
})->with([
    'owned role'         => ['owned role', true],
    'own role'           => ['own role', false],
    'privileged role'    => ['privileged role', false],
    'unowned permission' => ['unowned permission', false],
]);

it('prevents support from changing its own role or any privileged account', function (TypeUsers $targetType): void {
    $support = User::factory()->create(['type' => TypeUsers::SupportRemSoft]);
    $support->givePermissionTo(UserPermissions::Edit);

    $target = $targetType === TypeUsers::SupportRemSoft
        ? $support
        : User::factory()->create(['type' => $targetType]);

    expect(Gate::forUser($support)->allows('update', $target))->toBeFalse();
})->with([TypeUsers::Admin, TypeUsers::SupportRemSoft, TypeUsers::Customer]);

it('limits project access to customers', function (TypeUsers $type): void {
    $actor = User::factory()->create(['type' => $type]);

    expect(Gate::forUser($actor)->allows('viewAnyProject', User::class))->toBe($type === TypeUsers::Customer);
})->with(TypeUsers::cases());

it('limits invitation resends to authorized editors and eligible accounts', function (TypeUsers $actorType, bool $permission): void {
    $actor  = User::factory()->create(['type' => $actorType]);
    $target = User::factory()->user()->create(['invitation_pending' => true]);

    if ($permission) {
        $actor->givePermissionTo(UserPermissions::Edit);
    }

    expect(Gate::forUser($actor)->allows('resendInvitation', $target))
        ->toBe($actorType === TypeUsers::Admin || ($actorType === TypeUsers::SupportRemSoft && $permission));
})->with(TypeUsers::cases())->with([true, false]);

it('forbids resending to inactive completed or privileged accounts', function (array $attributes): void {
    $actor  = User::factory()->admin()->create();
    $target = User::factory()->user()->create(array_merge(['invitation_pending' => true], $attributes));

    expect(Gate::forUser($actor)->allows('resendInvitation', $target))->toBeFalse();
})->with([
    'inactive'  => [['deleted_at' => '2026-01-01 00:00:00']],
    'completed' => [['invitation_pending' => false]],
    'admin'     => [['type' => TypeUsers::Admin]],
    'support'   => [['type' => TypeUsers::SupportRemSoft]],
    'customer'  => [['type' => TypeUsers::Customer]],
]);
