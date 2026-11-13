<?php

declare(strict_types = 1);

namespace App\Casts;

use App\Traits\Components\WithConverters;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

/** @implements CastsAttributes<float|null, string|int|float|null> */
class Money implements CastsAttributes
{
    use WithConverters;

    /**
     * @example 10000 -> 100.00
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): ?float
    {
        if (!is_int($value) && !is_float($value) && $value !== null) {
            throw new \InvalidArgumentException('Invalid stored monetary value');
        }

        return $this->converterIntToFloat($value);
    }

    /**
     * @example 100.00 -> 10000
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): ?int
    {
        return $this->converterStringToInt($value);
    }
}
