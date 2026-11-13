<?php

declare(strict_types = 1);

use App\Enums\Permissions\Management\UserPermissions;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Cache\Events\CacheHit;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

function forceRunningInConsole(bool $value): void
{
    $property = new ReflectionProperty(app(), 'isRunningInConsole');
    $property->setValue(app(), $value);
}

it('attaches a single permission to role', function (): void {
    Permission::query()->firstOrCreate(['name' => UserPermissions::View->value]);

    $role = Role::factory()->create();
    $role->givePermissionTo(UserPermissions::View);

    expect($role->permissions()->pluck('name')->all())->toContain(UserPermissions::View->value);
});

it('attaches many permissions to role', function (): void {
    Permission::query()->firstOrCreate(['name' => UserPermissions::Create->value]);
    Permission::query()->firstOrCreate(['name' => UserPermissions::Edit->value]);

    $role = Role::factory()->create();
    $role->givePermissionTo([UserPermissions::Create, UserPermissions::Edit]);

    expect($role->permissions()->pluck('name')->all())
        ->toContain(UserPermissions::Create->value, UserPermissions::Edit->value);
});

it('does nothing when giving empty permission set', function (): void {
    $role = Role::factory()->create();

    $role->givePermissionTo([]);

    expect($role->permissions()->count())->toBe(0);
});

it('checks if role has permission', function (): void {
    Permission::query()->firstOrCreate(['name' => UserPermissions::Delete->value]);

    $role = Role::factory()->create();
    $role->givePermissionTo(UserPermissions::Delete);

    expect($role->hasPermissionTo(UserPermissions::Delete))->toBeTrue()
        ->and($role->hasPermissionTo(UserPermissions::Restore))->toBeFalse();
});

it('reads the permission cache once across repeated checks in the same request', function (): void {
    $role = Role::factory()->create();
    Cache::put($role->getKeyPermissionCache(), [UserPermissions::View->value]);
    Event::fake([CacheHit::class]);

    forceRunningInConsole(false);
    DB::rollBack();

    try {
        expect($role->hasPermissionTo(UserPermissions::View))->toBeTrue();
        expect($role->hasPermissionTo(UserPermissions::Delete))->toBeFalse();
        expect((clone $role)->hasPermissionTo(UserPermissions::View))->toBeTrue();
        Event::assertDispatchedTimes(CacheHit::class, 1);
    } finally {
        forceRunningInConsole(true);
        DB::beginTransaction();
    }
});

it('syncs permissions by permission names', function (): void {
    Permission::query()->firstOrCreate(['name' => UserPermissions::View->value]);
    Permission::query()->firstOrCreate(['name' => UserPermissions::Create->value]);

    $role = Role::factory()->create();
    $role->syncPermissions([UserPermissions::View->value, UserPermissions::Create->value]);

    expect($role->permissions()->pluck('name')->all())
        ->toContain(UserPermissions::View->value, UserPermissions::Create->value);
});

it('returns permission cache key using role id', function (): void {
    $role = Role::factory()->create();

    expect($role->getKeyPermissionCache())->toBe("role::{$role->id}::permissions");
});

it('revokes one and many permissions from role', function (): void {
    Permission::query()->firstOrCreate(['name' => UserPermissions::View->value]);
    Permission::query()->firstOrCreate(['name' => UserPermissions::Create->value]);

    $role = Role::factory()->create();
    $role->givePermissionTo([UserPermissions::View, UserPermissions::Create]);

    $role->revokePermissionTo(UserPermissions::View);

    expect($role->permissions()->pluck('name')->all())->not->toContain(UserPermissions::View->value);

    $role->revokePermissionTo([UserPermissions::Create]);
    expect($role->permissions()->pluck('name')->all())->not->toContain(UserPermissions::Create->value);
});

it('does nothing when revoking empty permission set', function (): void {
    $role = Role::factory()->create();

    $role->revokePermissionTo([]);

    expect($role->permissions()->count())->toBe(0);
});

it('refreshes permission cache when app is not running unit tests', function (): void {
    $role = Role::factory()->create();

    app()->instance('env', 'local');

    $key = $role->getKeyPermissionCache();
    Cache::put($key, [UserPermissions::View->value]);
    expect(Cache::memo()->get($key))->toBe([UserPermissions::View->value]);

    $role->refreshPermissionCache();

    expect(Cache::has($key))->toBeFalse();
    expect(Cache::memo()->has($key))->toBeFalse();

    app()->instance('env', 'testing');
});

it('grants repeated and overlapping permissions once without removing other links', function (): void {
    $role      = Role::factory()->create();
    $otherRole = Role::factory()->create();
    $role->givePermissionTo(UserPermissions::View);
    $role->load('permissions');
    $role->givePermissionTo(UserPermissions::View);
    $role->givePermissionTo([UserPermissions::View, UserPermissions::Create, UserPermissions::Create]);

    $otherRole->givePermissionTo(UserPermissions::View);

    expect($role->permissions->pluck('name')->all())->toEqualCanonicalizing([
        UserPermissions::View->value, UserPermissions::Create->value,
    ]);
    expect($otherRole->permissions()->pluck('name')->all())->toBe([UserPermissions::View->value]);
    $this->assertDatabaseCount('permission_role', 3);
});

it('ignores unknown permission names without changing existing grants', function (): void {
    $role = Role::factory()->create();
    $role->givePermissionTo(UserPermissions::View);
    Permission::query()->where('name', UserPermissions::Restore->value)->delete();

    $role->givePermissionTo(UserPermissions::Restore);

    expect($role->permissions()->pluck('name')->all())->toBe([UserPermissions::View->value]);
});

it('rolls back the entire grant batch when one insert fails', function (): void {
    $role = Role::factory()->create();
    $role->givePermissionTo(UserPermissions::View);
    Permission::retrieved(function (Permission $permission): void {
        if ($permission->name === UserPermissions::Edit->value) {
            Permission::query()->whereKey($permission->id)->delete();
        }
    });

    expect(fn () => DB::transaction(fn () => $role->givePermissionTo([UserPermissions::Create, UserPermissions::Edit])))
        ->toThrow(QueryException::class, 'SQLSTATE[23503]');

    expect($role->permissions()->pluck('name')->all())->toBe([UserPermissions::View->value]);
});

it('does not swallow foreign key failures for a deleted role', function (): void {
    $role = Role::factory()->create();
    $role->delete();

    expect(fn () => DB::transaction(fn () => $role->givePermissionTo(UserPermissions::View)))
        ->toThrow(QueryException::class, 'SQLSTATE[23503]');

    $this->assertDatabaseCount('permission_role', 0);
});

it('keeps revoke and sync coherent after repeated grants', function (): void {
    $role = Role::factory()->create();
    $role->givePermissionTo([UserPermissions::View, UserPermissions::Create]);
    $role->givePermissionTo(UserPermissions::View);
    $role->load('permissions');

    $role->revokePermissionTo(UserPermissions::View);

    expect($role->permissions->pluck('name')->all())->toBe([UserPermissions::Create->value]);

    $role->syncPermissions([UserPermissions::Edit->value, UserPermissions::Edit->value]);
    expect($role->permissions->pluck('name')->all())->toBe([UserPermissions::Edit->value]);

    $role->syncPermissions([]);
    expect($role->permissions)->toBeEmpty();
});

it('invalidates permission cache only after commit and preserves it on rollback', function (bool $commit, bool $nested): void {
    $role = Role::factory()->create();
    app()->instance('env', 'local');
    forceRunningInConsole(false);
    Cache::put($role->getKeyPermissionCache(), []);
    expect(Cache::memo()->get($role->getKeyPermissionCache()))->toBe([]);
    DB::beginTransaction();

    if ($nested) {
        DB::beginTransaction();
    }

    $role->givePermissionTo(UserPermissions::View);
    $role->givePermissionTo(UserPermissions::View);

    if ($nested) {
        DB::commit();
    }

    expect(Cache::get($role->getKeyPermissionCache()))->toBe([]);
    expect(Cache::memo()->get($role->getKeyPermissionCache()))->toBe([]);
    expect($role->hasPermissionTo(UserPermissions::View))->toBeTrue();

    if ($commit) {
        DB::commit();
        expect(Cache::has($role->getKeyPermissionCache()))->toBeFalse();
        expect(Cache::memo()->has($role->getKeyPermissionCache()))->toBeFalse();
        expect($role->hasPermissionTo(UserPermissions::View))->toBeTrue();
    } else {
        DB::rollBack();
        expect(Cache::get($role->getKeyPermissionCache()))->toBe([]);
        expect(Cache::memo()->get($role->getKeyPermissionCache()))->toBe([]);
        expect($role->hasPermissionTo(UserPermissions::View))->toBeFalse();
        $this->assertDatabaseCount('permission_role', 0);
    }
})->with(['commit' => true, 'rollback' => false])
    ->with(['single transaction' => false, 'nested transaction' => true]);
