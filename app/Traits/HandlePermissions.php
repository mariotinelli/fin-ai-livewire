<?php

declare(strict_types = 1);

namespace App\Traits;

use App\Models\Permission;
use BackedEnum;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

trait HandlePermissions
{
    private function rememberUntil(): DateTimeInterface
    {
        return now()->addMinutes(5);
    }

    /** @return BelongsToMany<Permission, $this> */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * @param  BackedEnum|array<BackedEnum>  $permission
     */
    public function givePermissionTo(BackedEnum | array $permission): void
    {
        if (empty($permission)) {
            return;
        }

        $names       = array_map(fn (BackedEnum $perm): string | int => $perm->value, is_array($permission) ? $permission : [$permission]);
        $permissions = Permission::query()->whereIn('name', $names)->get();

        $this->permissions()->newPivotStatement()->upsert(
            $permissions->map(fn (Permission $permission): array => [
                'permission_id' => $permission->id,
                'role_id'       => $this->id,
            ])->all(),
            ['permission_id', 'role_id'],
            ['permission_id']
        );

        $this->refreshPermissionCache();
    }

    public function hasPermissionTo(BackedEnum $permission): bool
    {
        /** @var array<int, string> $permissions */
        $permissions = app()->runningInConsole() || DB::transactionLevel() > 0
            ? $this->permissions()->pluck('name')->all()
            : Cache::memo()->remember(
                $this->getKeyPermissionCache(),
                $this->rememberUntil(),
                fn (): array => $this->permissions()->pluck('name')->all()
            );

        return in_array($permission->value, $permissions, true);
    }

    /** @param array<string> $permissions */
    public function syncPermissions(array $permissions): void
    {
        $permissions = Permission::query()
            ->select('id')
            ->whereIn('name', $permissions)
            ->pluck('id')
            ->toArray();

        $this->permissions()->sync($permissions);

        $this->refreshPermissionCache();
    }

    public function getKeyPermissionCache(): string
    {
        return "role::{$this->id}::permissions";
    }

    /** @param BackedEnum|array<BackedEnum> $permission */
    public function revokePermissionTo(BackedEnum | array $permission): void
    {
        if (empty($permission)) {
            return;
        }

        $names       = array_map(fn (BackedEnum $perm): string | int => $perm->value, is_array($permission) ? $permission : [$permission]);
        $permissions = Permission::query()->whereIn('name', $names)->get();

        $this->permissions()->detach($permissions);

        $this->refreshPermissionCache();
    }

    public function refreshPermissionCache(): void
    {
        $this->unsetRelation('permissions');

        if (app()->runningUnitTests()) {
            return;
        }

        $cacheKey = $this->getKeyPermissionCache();
        DB::afterCommit(static function () use ($cacheKey): void {
            Cache::memo()->forget($cacheKey);
        });
    }
}
