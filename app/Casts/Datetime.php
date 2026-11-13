<?php

declare(strict_types = 1);

namespace App\Casts;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

/** @implements CastsAttributes<Carbon|null, string|\DateTimeInterface|null> */
class Datetime implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): ?Carbon
    {
        if (!$value) {
            return null;
        }

        if (!is_string($value) && !$value instanceof \DateTimeInterface) {
            throw new InvalidArgumentException('Invalid datetime value');
        }

        return Carbon::parse($value);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        if (!$value) {
            return null;
        }

        if ($value instanceof \DateTimeInterface) {
            return $value->format('Y-m-d H:i:s');
        }

        $date = Carbon::createFromFormat($this->getFormat($value), $value);

        if (!$date instanceof Carbon) {
            throw new InvalidArgumentException('Invalid datetime format');
        }

        return $date->format('Y-m-d H:i:s');
    }

    protected function getFormat(string $value): string
    {
        $regex = $this->availableRegex();

        return match (true) {
            preg_match($regex['d/m/Y H:i'], $value) === 1 => 'd/m/Y H:i',
            preg_match($regex['d/m/Y'], $value) === 1     => 'd/m/Y',
            preg_match($regex['H:i'], $value) === 1       => 'H:i',
            default                                       => throw new InvalidArgumentException('Invalid datetime format'),
        };
    }

    /** @return array<string, string> */
    protected function availableRegex(): array
    {
        return [
            'd/m/Y H:i' => '/^\d{2}\/\d{2}\/\d{4} \d{2}:\d{2}$/',
            'd/m/Y'     => '/^\d{2}\/\d{2}\/\d{4}$/',
            'H:i'       => '/^\d{2}:\d{2}$/',
        ];
    }
}
