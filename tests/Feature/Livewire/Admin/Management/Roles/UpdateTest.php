<?php

declare(strict_types = 1);

use App\Enums\Permissions\Management\RolePermissions;
use App\Enums\Permissions\Management\UserPermissions;
use App\Enums\TypeUsers;
use App\Livewire\Admin\Management\Roles\Update;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Livewire\livewire;

beforeEach(function (): void {
    $this->user = User::factory()->create(['type' => TypeUsers::SupportRemSoft]);
    $this->user->givePermissionTo(RolePermissions::all());
    $this->actingAs($this->user);

    $this->role = Role::factory()->create(['name' => 'Perfil original']);
});

it('shows a validation error when renaming to another role with different case', function (): void {
    Role::factory()->create(['name' => 'Gerente']);
    $originalName = $this->role->name;

    livewire(Update::class)
        ->call('loadRole', $this->role->id)
        ->set('role.name', 'gerente')
        ->set('selectedPermissions', [RolePermissions::View->value])
        ->call('save')
        ->assertHasErrors(['role.name' => 'unique'])
        ->assertNotDispatched('roles::refresh');

    expect($this->role->refresh()->name)->toBe($originalName);
});

it('allows saving the current role without renaming it', function (): void {
    livewire(Update::class)
        ->call('loadRole', $this->role->id)
        ->set('role.description', 'Descrição atualizada')
        ->set('selectedPermissions', [RolePermissions::View->value])
        ->call('save')
        ->assertHasNoErrors()
        ->assertDispatched('roles::refresh');

    expect($this->role->refresh()->description)->toBe('Descrição atualizada');
});

it('can access with edit roles permission', function (): void {
    $this->user->revokePermissionTo(RolePermissions::Edit);

    livewire(Update::class)
        ->call('loadRole', $this->role->id)
        ->assertForbidden();

    $this->user->givePermissionTo(RolePermissions::Edit);

    livewire(Update::class)
        ->call('loadRole', $this->role->id)
        ->assertOk();
});

it('can load role correctly', function (): void {
    livewire(Update::class)
        ->call('loadRole', $this->role->id)
        ->assertSet('role.name', $this->role->name)
        ->assertSet('role.description', $this->role->description)
        ->assertSet('selectedPermissions', $this->role->permissions->pluck('name')->toArray());
});

it('can update a role', function (): void {
    $selectedPermissions = collect(RolePermissions::all())->map(fn (RolePermissions $permission) => $permission->value)->toArray();
    $this->role->syncPermissions($selectedPermissions);

    assertDatabaseCount('permission_role', $this->role->permissions()->count() + $this->user->role->permissions()->count());

    $newPermissions = collect(RolePermissions::all())->map(fn (RolePermissions $permission) => $permission->value);

    livewire(Update::class)
        ->call('loadRole', $this->role->id)
        ->set('role.name', 'Admin')
        ->set('role.description', 'Test role')
        ->set('selectedPermissions', $newPermissions->toArray())
        ->call('save')
        ->assertHasNoErrors()
        ->assertToast('Perfil atualizado com sucesso')
        ->assertDispatched('roles::refresh');

    assertDatabaseHas('roles', [
        'id'          => $this->role->id,
        'name'        => 'Admin',
        'description' => 'Test role',
    ]);

    $permissions = Permission::query()->whereIn('name', $newPermissions->toArray())->get();

    assertDatabaseCount('permission_role', $permissions->count() + $this->user->role->permissions()->count());

    foreach ($permissions as $permission) {
        assertDatabaseHas('permission_role', [
            'role_id'       => $this->role->id,
            'permission_id' => $permission->id,
        ]);
    }
});

it('reauthorizes after opening and does not persist when permission is revoked', function (): void {
    $originalName = $this->role->name;
    $component    = livewire(Update::class)
        ->call('loadRole', $this->role->id)
        ->set('role.name', 'Blocked role')
        ->set('selectedPermissions', [RolePermissions::View->value]);
    $this->user->revokePermissionTo(RolePermissions::Edit);

    $component->call('save')
        ->assertForbidden()
        ->assertNotDispatched('roles::refresh')
        ->assertNotDispatched('toast');

    assertDatabaseHas('roles', ['id' => $this->role->id, 'name' => $originalName]);
});

it('rejects an unowned permission without changing the role', function (): void {
    $originalName = $this->role->name;

    livewire(Update::class)
        ->call('loadRole', $this->role->id)
        ->set('role.name', 'Elevated role')
        ->set('selectedPermissions', [UserPermissions::Edit->value])
        ->call('save')
        ->assertForbidden()
        ->assertNotDispatched('roles::refresh')
        ->assertNotDispatched('toast');

    assertDatabaseHas('roles', ['id' => $this->role->id, 'name' => $originalName]);
});

it('rejects a privileged role id substituted after opening', function (): void {
    $privilegedRole = Role::factory()->create(['name' => 'Privileged role']);
    User::factory()->create(['type' => TypeUsers::SupportRemSoft, 'role_id' => $privilegedRole->id]);
    $regularName    = $this->role->name;
    $privilegedName = $privilegedRole->name;

    livewire(Update::class)
        ->call('loadRole', $this->role->id)
        ->set('role', $privilegedRole)
        ->set('role.name', 'Tampered role')
        ->set('selectedPermissions', [RolePermissions::View->value])
        ->call('save')
        ->assertForbidden()
        ->assertNotDispatched('roles::refresh')
        ->assertNotDispatched('toast');

    assertDatabaseHas('roles', ['id' => $this->role->id, 'name' => $regularName]);
    assertDatabaseHas('roles', ['id' => $privilegedRole->id, 'name' => $privilegedName]);
});

it('can load permission from selected template', function (): void {
    $template            = Role::factory()->create();
    $selectedPermissions = collect(RolePermissions::all())->map(fn (RolePermissions $permission) => $permission->value)->toArray();
    $template->syncPermissions($selectedPermissions);

    assertDatabaseCount('permission_role', $template->permissions()->count() + $this->user->role->permissions()->count());

    livewire(Update::class)
        ->call('loadRole', $this->role->id)
        ->set('template', $template->id)
        ->assertSet('selectedPermissions', fn (array $data): bool => count(array_diff($data, $selectedPermissions)) === 0
            && count(array_diff($selectedPermissions, $data)) === 0);
});

it('can clear permissions when clear template', function (): void {
    $template            = Role::factory()->create();
    $selectedPermissions = collect(RolePermissions::all())->map(fn (RolePermissions $permission) => $permission->value)->toArray();
    $template->syncPermissions($selectedPermissions);

    assertDatabaseCount('permission_role', $template->permissions()->count() + $this->user->role->permissions()->count());

    livewire(Update::class)
        ->call('loadRole', $this->role->id)
        ->set('template', $template->id)
        ->assertDispatched('select-template')
        ->assertSet('selectedPermissions', fn (array $data): bool => count(array_diff($data, $selectedPermissions)) === 0
            && count(array_diff($selectedPermissions, $data)) === 0)
        ->set('template', null)
        ->assertSet('selectedPermissions', [])
        ->assertDispatched('select-template', []);
});

it('validate name', function (int | string | null $name, string $rule): void {
    livewire(Update::class)
        ->call('loadRole', $this->role->id)
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
    livewire(Update::class)
        ->call('loadRole', $this->role->id)
        ->set('role.description', $description)
        ->call('save')
        ->assertHasErrors(['role.description' => $rule]);
})->with([
    [123, 'string'],
    ['ab', 'min'],
    [str_repeat('a', 501), 'max'],
]);

it('validate selected permissions', function (?array $permissions, string $field, string $rule): void {
    livewire(Update::class)
        ->call('loadRole', $this->role->id)
        ->set('selectedPermissions', $permissions)
        ->call('save')
        ->assertHasErrors([$field => $rule]);
})->with([
    [null, 'selectedPermissions', 'required'],
    [['invalid'], 'selectedPermissions.0', 'exists'],
]);
