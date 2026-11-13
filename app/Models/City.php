<?php

declare(strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property int $state_id
 * @property string $ibge_code
 * @property State $state
 * @property Collection<int, Address> $addresses
 */
class City extends BaseModel
{
    /** @use HasFactory<\Database\Factories\CityFactory> */
    use HasFactory;

    public $timestamps = false;

    /** @return BelongsTo<State, $this> */
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    /** @return HasMany<Address, $this> */
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }
}
