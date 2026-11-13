<?php

declare(strict_types = 1);

namespace App\Policies;

use App\Enums\Permissions\Management\UserPermissions;
use App\Enums\TypeUsers;
use App\Models\Role;
use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->hasPermissionTo(UserPermissions::View);
    }

    public function create(User $user, ?Role $role = null): bool
    {
        return $user->isAdmin()
            || ($user->isSupportRemSoft()
                && $user->hasPermissionTo(UserPermissions::Create)
                && (!$role instanceof Role || $this->canAssignRole($user, $role)));
    }

    public function update(User $user, User $model, ?Role $role = null): bool
    {
        return $model->type === TypeUsers::User
            && $user->id !== $model->id
            && ($user->isAdmin()
                || ($user->isSupportRemSoft()
                    && $user->hasPermissionTo(UserPermissions::Edit)
                    && (!$role instanceof Role || $this->canAssignRole($user, $role))));
    }

    public function resendInvitation(User $user, User $model): bool
    {
        return !$model->trashed()
            && $model->invitation_pending
            && $this->update($user, $model);
    }

    public function delete(User $user, User $model): bool
    {
        return $model->type === TypeUsers::User
            && $user->type->canAccessAdminArea()
            && ($user->isAdmin() || $user->hasPermissionTo(UserPermissions::Delete));
    }

    public function restore(User $user, User $model): bool
    {
        return $model->type === TypeUsers::User
            && $user->type->canAccessAdminArea()
            && ($user->isAdmin() || $user->hasPermissionTo(UserPermissions::Restore));
    }

    public function viewAnyProject(User $user): bool
    {
        return $user->isCustomer();
    }

    private function canAssignRole(User $user, Role $role): bool
    {
        if ($user->role === null || $user->role_id === $role->id) {
            return false;
        }

        if ($role->users()->whereIn('type', [TypeUsers::Admin, TypeUsers::SupportRemSoft])->exists()) {
            return false;
        }

        $ownedPermissions     = array_filter($user->role->permissions()->pluck('name')->all(), is_string(...));
        $delegatedPermissions = array_filter($role->permissions()->pluck('name')->all(), is_string(...));

        return array_diff($delegatedPermissions, $ownedPermissions) === [];
    }
}
