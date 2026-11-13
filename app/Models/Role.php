<?php

declare(strict_types = 1);

namespace App\Models;

use App\Traits\HandlePermissions;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property ?string $description
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 * @property Collection<int, User> $users
 * @property Collection<int, Permission> $permissions
 */
class Role extends BaseModel
{
    /** @use HasFactory<\Database\Factories\RoleFactory> */
    use HasFactory;
    use HandlePermissions;

    /** @return HasMany<User, $this> */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
