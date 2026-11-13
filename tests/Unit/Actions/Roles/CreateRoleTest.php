<?php

declare(strict_types = 1);

use App\Actions\Roles\CreateRole;
use App\Enums\Permissions\Management\RolePermissions;
use App\Models\Role;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

use function Pest\Laravel\assertDatabaseHas;

it('rejects an existing role name regardless of case', function (string $name): void {
    Role::factory()->create(['name' => 'Gerente']);
    $count = Role::query()->count();

    expect(fn () => app(CreateRole::class)->handle(
        roleData: ['name' => $name],
        selectedPermissions: [RolePermissions::View->value],
    ))->toThrow(UniqueConstraintViolationException::class);

    $this->assertDatabaseCount('roles', $count);
    $this->assertDatabaseCount('permission_role', 0);
})->with(['Gerente', 'gerente']);

it('creates role with selected permissions', function (): void {
    $role = app(CreateRole::class)->handle(
        roleData: [
            'name'        => 'Perfil Task Create',
            'description' => 'Descrição de teste',
        ],
        selectedPermissions: [
            RolePermissions::View->value,
            RolePermissions::Create->value,
        ],
    );

    expect($role->name)->toBe('Perfil Task Create')
        ->and($role->description)->toBe('Descrição de teste')
        ->and($role->hasPermissionTo(RolePermissions::View))->toBeTrue()
        ->and($role->hasPermissionTo(RolePermissions::Create))->toBeTrue();

    assertDatabaseHas('roles', [
        'id'          => $role->id,
        'name'        => 'Perfil Task Create',
        'description' => 'Descrição de teste',
    ]);
});

it('rolls back the role and permissions when sync fails', function (): void {
    DB::listen(function (QueryExecuted $query): void {
        if (str_contains(strtolower($query->sql), 'insert into') && str_contains($query->sql, 'permission_role')) {
            throw new RuntimeException('Simulated sync failure');
        }
    });

    expect(fn () => app(CreateRole::class)->handle(
        roleData: ['name' => 'Atomic role'],
        selectedPermissions: [RolePermissions::View->value],
    ))->toThrow(RuntimeException::class, 'Simulated sync failure');

    $this->assertDatabaseMissing('roles', ['name' => 'Atomic role']);
    $this->assertDatabaseCount('permission_role', 0);
});

it('invalidates cached permissions only when the surrounding transaction commits', function (bool $commit, bool $nested): void {
    app()->instance('env', 'local');
    DB::beginTransaction();

    if ($nested) {
        DB::beginTransaction();
    }

    $role = app(CreateRole::class)->handle(
        roleData: ['name' => 'Atomic role'],
        selectedPermissions: [RolePermissions::View->value],
    );
    $key = $role->getKeyPermissionCache();
    expect(Cache::has($key))->toBeFalse();
    Cache::put($key, ['previous-cache']);
    expect(Cache::memo()->get($key))->toBe(['previous-cache']);

    if ($nested) {
        DB::commit();
    }

    expect(Cache::get($key))->toBe(['previous-cache']);
    expect(Cache::memo()->get($key))->toBe(['previous-cache']);

    if ($commit) {
        DB::commit();
        expect(Cache::has($key))->toBeFalse();
        expect(Cache::memo()->has($key))->toBeFalse();
        $this->assertModelExists($role);
    } else {
        DB::rollBack();
        expect(Cache::get($key))->toBe(['previous-cache']);
        expect(Cache::memo()->get($key))->toBe(['previous-cache']);
        $this->assertDatabaseMissing('roles', ['id' => $role->id]);
        $this->assertDatabaseCount('permission_role', 0);
    }
})->with(['commit' => true, 'rollback' => false])
    ->with(['single transaction' => false, 'nested transaction' => true]);
