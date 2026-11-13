<?php

declare(strict_types = 1);

namespace App\Queries;

use App\Enums\TypeUsers;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

final readonly class UsersWithPermissionsQuery
{
    /**
     * @param list<string> $permissions
     * @return Collection<int, User>
     */
    public function get(array $permissions): Collection
    {
        return User::query()
            ->whereType(TypeUsers::Admin->value)
            ->orWhereHas('role.permissions', fn (Builder $query) => $query->whereIn('name', $permissions))
            ->get();
    }
}
