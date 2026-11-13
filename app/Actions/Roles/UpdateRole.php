<?php

declare(strict_types = 1);

namespace App\Actions\Roles;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

final readonly class UpdateRole
{
    /**
     * @param array{name: string, description?: string|null} $roleData
     * @param list<string> $selectedPermissions
     */
    public function handle(Role $role, array $roleData, array $selectedPermissions): Role
    {
        return DB::transaction(function () use ($role, $roleData, $selectedPermissions): Role {
            $role->update([
                'name'        => $roleData['name'],
                'description' => $roleData['description'] ?? null,
            ]);

            $role->permissions()->sync(
                Permission::query()->whereIn('name', $selectedPermissions)->pluck('id')->all()
            );

            $cacheKey = $role->getKeyPermissionCache();

            DB::afterCommit(static function () use ($cacheKey): void {
                Cache::memo()->forget($cacheKey);
            });

            return $role;
        });
    }
}
