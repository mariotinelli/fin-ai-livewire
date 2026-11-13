<?php

declare(strict_types = 1);

namespace App\Traits\Components;

use Carbon\Carbon;

trait WithConverters
{
    /** @return array{Carbon, Carbon}|null */
    protected function converterRangeToDates(string | null $value, string $fromFormat = 'd/m/Y'): ?array
    {
        if ($value === null || trim($value) === '') {
            return null;
        }

        $dates = explode(' até ', $value);
        $start = Carbon::createFromFormat($fromFormat, $dates[0]);
        $end   = Carbon::createFromFormat($fromFormat, $dates[1] ?? $dates[0]);

        if (!$start instanceof Carbon || !$end instanceof Carbon) {
            throw new \InvalidArgumentException('Invalid date range');
        }

        return [
            $start->startOfDay(),
            $end->endOfDay(),
        ];
    }

    protected function converterIntToFloat(int | float | null $value): ?float
    {
        if ($value === null || is_float($value)) {
            return $value;
        }

        return (float) $value / 100;
    }

    protected function converterStringToInt(string | float | int | null $value): ?int
    {
        if ($value === null || is_string($value) && trim($value) === '') {
            return null;
        }

        if (is_float($value)) {
            return (int) round($value * 100);
        }

        $floatValue = str((string) $value)
            ->replace('.', '')
            ->replace(',', '.')
            ->toFloat() * 100;

        return (int) round($floatValue);
    }

    protected function converterStringToFloat(string | float | int | null $value): ?float
    {
        if (is_string($value) && !str_contains($value, ',') && !str_contains($value, '.')) {
            return $this->converterIntToFloat((int) $value);
        }

        $value = $this->converterStringToInt($value);

        return $this->converterIntToFloat($value);
    }

    protected function converterToFloat(string | float | int $value): float
    {
        return match (true) {
            is_float($value)  => $value,
            is_int($value)    => $this->converterIntToFloat($value) ?? 0.0,
            is_string($value) => $this->converterStringToFloat($value) ?? 0.0,
        };
    }
}
