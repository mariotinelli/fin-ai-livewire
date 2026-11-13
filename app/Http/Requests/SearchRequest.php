<?php

declare(strict_types = 1);

namespace App\Http\Requests;

use App\Enums\Permissions\Management\RolePermissions;
use App\Enums\Permissions\Management\UserPermissions;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    public function authorize(): bool
    {
        if ($this->routeIs('search.states')) {
            return true;
        }

        $user = $this->user();

        if (!$user instanceof User || !$user->type->canAccessAdminArea()) {
            return false;
        }

        if ($this->routeIs('search.users')) {
            return $user->can('viewAny', User::class);
        }

        if ($user->isAdmin()) {
            return true;
        }

        return array_any([RolePermissions::View, RolePermissions::Create, RolePermissions::Edit, UserPermissions::View, UserPermissions::Create, UserPermissions::Edit], fn (\App\Enums\Permissions\Management\RolePermissions | UserPermissions $permission): bool => $user->hasPermissionTo($permission));
    }

    /**
     * @return array<string, list<string>>
     */
    public function rules(): array
    {
        $columns = match (true) {
            $this->routeIs('search.users')  => ['id', 'name', 'email'],
            $this->routeIs('search.states') => ['id', 'name', 'initials'],
            default                         => ['id', 'name'],
        };

        $selectionRules = match ($this->input('selectedColumn', 'id')) {
            'name'     => ['required', 'string', 'max:255', 'distinct'],
            'email'    => ['required', 'string', 'email', 'max:255', 'distinct'],
            'initials' => ['required', 'string', 'size:2', 'distinct'],
            default    => ['required', 'integer', 'min:1', 'max:2147483647', 'distinct'],
        };

        return [
            'selectedColumn' => ['sometimes', 'required', 'string', 'in:' . implode(',', $columns)],
            'selected'       => ['sometimes', 'array', 'list', 'max:100'],
            'selected.*'     => $selectionRules,
            'search'         => ['sometimes', 'nullable', 'string', 'max:255'],
            'page'           => ['sometimes', 'required', 'integer', 'min:1', 'max:100000'],
        ];
    }
}
