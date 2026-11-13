<?php

declare(strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $postal_code
 * @property ?string $street
 * @property ?string $district
 * @property ?string $number
 * @property ?string $complement
 * @property ?int $city_id
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 * @property City $city
 */
class Address extends BaseModel
{
    /** @use HasFactory<\Database\Factories\AddressFactory> */
    use HasFactory;

    /** @return BelongsTo<City, $this> */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
