<?php

declare(strict_types = 1);

namespace App\Support;

final class Cpf
{
    public static function normalize(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $normalized = preg_replace('/[.\-\s]/u', '', $value);

        if (!is_string($normalized) || preg_match('/^\d+$/D', $normalized) !== 1) {
            return null;
        }

        return $normalized;
    }

    public static function format(?string $value): ?string
    {
        $normalized = self::normalize($value);

        if ($normalized === null || strlen($normalized) !== 11) {
            return null;
        }

        return sprintf(
            '%s.%s.%s-%s',
            substr($normalized, 0, 3),
            substr($normalized, 3, 3),
            substr($normalized, 6, 3),
            substr($normalized, 9, 2),
        );
    }

    public static function isValid(?string $value): bool
    {
        $cpf = self::normalize($value);

        if ($cpf === null || strlen($cpf) !== 11 || preg_match('/^(\d)\1{10}$/D', $cpf) === 1) {
            return false;
        }

        return self::digit(substr($cpf, 0, 9), 10) === (int) $cpf[9]
            && self::digit(substr($cpf, 0, 10), 11) === (int) $cpf[10];
    }

    private static function digit(string $base, int $weight): int
    {
        $sum = 0;

        for ($index = 0; $index < strlen($base); $index++) {
            $sum += (int) $base[$index] * ($weight - $index);
        }

        $digit = 11 - ($sum % 11);

        return $digit >= 10 ? 0 : $digit;
    }
}
