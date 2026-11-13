<?php

declare(strict_types = 1);

namespace App\Policies;

use App\Enums\Permissions\Management\RolePermissions;
use App\Enums\TypeUsers;
use App\Models\Role;
use App\Models\User;
use App\Traits\Policies\CheckIsAdmin;

class RolePolicy
{
    use CheckIsAdmin;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(RolePermissions::View);
    }

    /** @param array<array-key, mixed>|null $selectedPermissions */
    public function create(User $user, ?array $selectedPermissions = null): bool
    {
        return $user->isSupportRemSoft()
            && $user->hasPermissionTo(RolePermissions::Create)
            && ($selectedPermissions === null || $this->permissionsBelongTo($user, $selectedPermissions));
    }

    /** @param array<array-key, mixed>|null $selectedPermissions */
    public function update(User $user, Role $role, ?array $selectedPermissions = null): bool
    {
        return $user->isSupportRemSoft()
            && $user->hasPermissionTo(RolePermissions::Edit)
            && $user->role_id !== $role->id
            && !$role->users()->whereIn('type', [TypeUsers::Admin, TypeUsers::SupportRemSoft])->exists()
            && ($selectedPermissions === null || $this->permissionsBelongTo($user, $selectedPermissions));
    }

    /** @param array<array-key, mixed> $selectedPermissions */
    private function permissionsBelongTo(User $user, array $selectedPermissions): bool
    {
        if ($user->role === null) {
            return false;
        }

        $selected = array_filter($selectedPermissions, is_string(...));

        if (count($selected) !== count($selectedPermissions)) {
            return false;
        }

        $ownedPermissions = array_filter($user->role->permissions()->pluck('name')->all(), is_string(...));

        return array_diff($selected, $ownedPermissions) === [];
    }
}
