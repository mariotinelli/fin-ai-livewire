<?php

declare(strict_types = 1);

use App\Actions\Roles\UpdateRole;
use App\Enums\Permissions\Management\RolePermissions;
use App\Models\Role;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

use function Pest\Laravel\assertDatabaseHas;

it('rejects another role name without changing the role or permissions', function (string $name): void {
    Role::factory()->create(['name' => 'Gerente']);
    $role = Role::factory()->create(['name' => 'Operador']);
    $role->syncPermissions([RolePermissions::View->value]);

    expect(fn () => app(UpdateRole::class)->handle(
        role: $role,
        roleData: ['name' => $name],
        selectedPermissions: [RolePermissions::Edit->value],
    ))->toThrow(UniqueConstraintViolationException::class);

    expect($role->refresh()->name)->toBe('Operador');
    expect($role->permissions()->pluck('name')->all())->toBe([RolePermissions::View->value]);
})->with(['Gerente', 'gerente']);

it('allows keeping its own name or changing only its case', function (string $name): void {
    $role = Role::factory()->create(['name' => 'Gerente']);

    app(UpdateRole::class)->handle(
        role: $role,
        roleData: ['name' => $name, 'description' => 'Descrição atualizada'],
        selectedPermissions: [RolePermissions::View->value],
    );

    expect($role->refresh()->name)->toBe($name);
    expect($role->description)->toBe('Descrição atualizada');
})->with(['Gerente', 'gerente']);

it('updates role data and sync permissions', function (): void {
    /** @var Role $role */
    $role = Role::factory()->create([
        'name'        => 'Perfil Original',
        'description' => 'Descrição original',
    ]);

    $role->syncPermissions([RolePermissions::View->value]);

    app(UpdateRole::class)->handle(
        role: $role,
        roleData: [
            'name'        => 'Perfil Atualizado',
            'description' => 'Descrição atualizada',
        ],
        selectedPermissions: [
            RolePermissions::Edit->value,
        ],
    );

    $role->refresh();

    expect($role->name)->toBe('Perfil Atualizado')
        ->and($role->description)->toBe('Descrição atualizada')
        ->and($role->hasPermissionTo(RolePermissions::Edit))->toBeTrue()
        ->and($role->hasPermissionTo(RolePermissions::View))->toBeFalse();

    assertDatabaseHas('roles', [
        'id'          => $role->id,
        'name'        => 'Perfil Atualizado',
        'description' => 'Descrição atualizada',
    ]);
});

it('preserves fields permissions and cache when sync fails after detaching', function (): void {
    /** @var Role $role */
    $role = Role::factory()->create(['name' => 'Original role', 'description' => 'Original description']);
    $role->syncPermissions([RolePermissions::View->value]);
    Cache::put($role->getKeyPermissionCache(), [RolePermissions::View->value]);
    DB::listen(function (QueryExecuted $query): void {
        if (str_contains(strtolower($query->sql), 'insert into') && str_contains($query->sql, 'permission_role')) {
            throw new RuntimeException('Simulated sync failure');
        }
    });

    expect(fn () => app(UpdateRole::class)->handle(
        role: $role,
        roleData: ['name' => 'Changed role', 'description' => 'Changed description'],
        selectedPermissions: [RolePermissions::Edit->value],
    ))->toThrow(RuntimeException::class, 'Simulated sync failure');

    $role->refresh();
    expect($role->name)->toBe('Original role')
        ->and($role->description)->toBe('Original description')
        ->and($role->permissions()->pluck('name')->all())->toBe([RolePermissions::View->value]);
    expect(Cache::get($role->getKeyPermissionCache()))->toBe([RolePermissions::View->value]);
});

it('keeps cached permissions until the surrounding transaction commits', function (bool $commit, bool $nested): void {
    /** @var Role $role */
    $role = Role::factory()->create(['name' => 'Original role', 'description' => 'Original description']);
    $role->syncPermissions([RolePermissions::View->value]);

    $key = $role->getKeyPermissionCache();
    Cache::put($key, [RolePermissions::View->value]);
    expect(Cache::memo()->get($key))->toBe([RolePermissions::View->value]);
    app()->instance('env', 'local');
    DB::beginTransaction();

    if ($nested) {
        DB::beginTransaction();
    }

    app(UpdateRole::class)->handle(
        role: $role,
        roleData: ['name' => 'Changed role'],
        selectedPermissions: [RolePermissions::Edit->value],
    );

    if ($nested) {
        DB::commit();
    }

    expect(Cache::get($key))->toBe([RolePermissions::View->value]);
    expect(Cache::memo()->get($key))->toBe([RolePermissions::View->value]);

    if ($commit) {
        DB::commit();
        expect(Cache::has($key))->toBeFalse();
        expect(Cache::memo()->has($key))->toBeFalse();
        expect($role->fresh()->permissions()->pluck('name')->all())->toBe([RolePermissions::Edit->value]);
    } else {
        DB::rollBack();
        expect(Cache::get($key))->toBe([RolePermissions::View->value]);
        expect(Cache::memo()->get($key))->toBe([RolePermissions::View->value]);
        $role->refresh();
        expect($role->name)->toBe('Original role')
            ->and($role->description)->toBe('Original description')
            ->and($role->permissions()->pluck('name')->all())->toBe([RolePermissions::View->value]);
    }
})->with(['commit' => true, 'rollback' => false])
    ->with(['single transaction' => false, 'nested transaction' => true]);
