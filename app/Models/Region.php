<?php

declare(strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property Collection<int, State> $states
 */
class Region extends BaseModel
{
    /** @use HasFactory<\Database\Factories\RegionFactory> */
    use HasFactory;

    public $timestamps = false;

    /** @return HasMany<State, $this> */
    public function states(): HasMany
    {
        return $this->hasMany(State::class);
    }
}
