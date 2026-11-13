<?php

declare(strict_types = 1);

use App\Enums\Permissions\Management\RolePermissions;
use App\Enums\Permissions\Management\UserPermissions;
use App\Enums\TypeUsers;
use App\Livewire\Admin\Management\Roles\Create;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Livewire\livewire;

beforeEach(function (): void {
    $this->user = User::factory()->create(['type' => TypeUsers::SupportRemSoft]);
    $this->user->givePermissionTo(RolePermissions::all());
    $this->actingAs($this->user);
});

it('can access with create roles permission', function (): void {
    $user = $this->user;

    $user->revokePermissionTo(RolePermissions::Create);

    livewire(Create::class)
        ->call('loadRole')
        ->assertForbidden();

    $user->givePermissionTo(RolePermissions::Create);

    livewire(Create::class)
        ->call('loadRole')
        ->assertOk();
});

it('shows a validation error for an existing role name with different case', function (): void {
    Role::factory()->create(['name' => 'Gerente']);
    $count = Role::query()->count();

    livewire(Create::class)
        ->call('loadRole')
        ->set('role.name', 'gerente')
        ->set('selectedPermissions', [RolePermissions::View->value])
        ->call('save')
        ->assertHasErrors(['role.name' => 'unique'])
        ->assertNotDispatched('roles::refresh');

    assertDatabaseCount('roles', $count);
});

it('can create a role', function (): void {
    $selectedPermissions = collect(RolePermissions::all())->map(fn (RolePermissions $permission) => $permission->value);

    livewire(Create::class)
        ->call('loadRole')
        ->set('role.name', 'Admin')
        ->set('role.description', 'Test role')
        ->set('selectedPermissions', $selectedPermissions->toArray())
        ->call('save')
        ->assertHasNoErrors()
        ->assertToast('Perfil cadastrado com sucesso')
        ->assertDispatched('roles::refresh');

    assertDatabaseHas('roles', [
        'name'        => 'Admin',
        'description' => 'Test role',
    ]);

    $role        = Role::query()->latest('id')->first();
    $permissions = Permission::query()->whereIn('name', $selectedPermissions->toArray())->get();

    assertDatabaseCount('permission_role', $permissions->count() + $this->user->role->permissions()->count());

    foreach ($permissions as $permission) {
        assertDatabaseHas('permission_role', [
            'role_id'       => $role->id,
            'permission_id' => $permission->id,
        ]);
    }
});

it('reauthorizes after opening and does not persist when permission is revoked', function (): void {
    $component = livewire(Create::class)
        ->call('loadRole')
        ->set('role.name', 'Blocked role')
        ->set('selectedPermissions', [RolePermissions::View->value]);
    $this->user->revokePermissionTo(RolePermissions::Create);

    $component->call('save')
        ->assertForbidden()
        ->assertNotDispatched('roles::refresh')
        ->assertNotDispatched('toast');

    assertDatabaseMissing('roles', ['name' => 'Blocked role']);
});

it('rejects permission ids outside support scope without persisting', function (): void {
    livewire(Create::class)
        ->call('loadRole')
        ->set('role.name', 'Elevated role')
        ->set('selectedPermissions', [UserPermissions::Edit->value])
        ->call('save')
        ->assertForbidden()
        ->assertNotDispatched('roles::refresh')
        ->assertNotDispatched('toast');

    assertDatabaseMissing('roles', ['name' => 'Elevated role']);
});

it('can load permission from selected template', function (): void {
    $template            = Role::factory()->create();
    $selectedPermissions = collect(RolePermissions::all())->map(fn (RolePermissions $permission) => $permission->value)->toArray();
    $template->syncPermissions($selectedPermissions);

    assertDatabaseCount('permission_role', $template->permissions()->count() + $this->user->role->permissions()->count());

    livewire(Create::class)
        ->call('loadRole')
        ->set('template', $template->id)
        ->assertDispatched('select-template')
        ->assertSet('selectedPermissions', fn (array $data): bool => count(array_diff($data, $selectedPermissions)) === 0
            && count(array_diff($selectedPermissions, $data)) === 0);
});

it('can clear permissions when clear template', function (): void {
    $template            = Role::factory()->create();
    $selectedPermissions = collect(RolePermissions::all())->map(fn (RolePermissions $permission) => $permission->value)->toArray();
    $template->syncPermissions($selectedPermissions);

    assertDatabaseCount('permission_role', $template->permissions()->count() + $this->user->role->permissions()->count());

    livewire(Create::class)
        ->call('loadRole')
        ->set('template', $template->id)
        ->assertDispatched('select-template')
        ->assertSet('selectedPermissions', fn (array $data): bool => count(array_diff($data, $selectedPermissions)) === 0
            && count(array_diff($selectedPermissions, $data)) === 0)
        ->set('template', null)
        ->assertSet('selectedPermissions', [])
        ->assertDispatched('select-template', []);
});

it('validate name', function (int | string | null $name, string $rule): void {
    livewire(Create::class)
        ->call('loadRole')
        ->set('role.name', $name)
        ->call('save')
        ->assertHasErrors(['role.name' => $rule]);
})->with([
    [null, 'required'],
    [123, 'string'],
    ['ab', 'min'],
    [str_repeat('a', 192), 'max'],
]);

it('validate description', function (int | string $description, string $rule): void {
    livewire(Create::class)
        ->call('loadRole')
        ->set('role.description', $description)
        ->call('save')
        ->assertHasErrors(['role.description' => $rule]);
})->with([
    [123, 'string'],
    ['ab', 'min'],
    [str_repeat('a', 501), 'max'],
]);

it('validate selected permissions', function (?array $permissions, string $field, string $rule): void {
    livewire(Create::class)
        ->call('loadRole')
        ->set('selectedPermissions', $permissions)
        ->call('save')
        ->assertHasErrors([$field => $rule]);
})->with([
    [null, 'selectedPermissions', 'required'],
    [['invalid'], 'selectedPermissions.0', 'exists'],
]);
