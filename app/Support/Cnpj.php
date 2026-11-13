<?php

declare(strict_types = 1);

namespace App\Support;

final class Cnpj
{
    public static function normalize(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $normalized = preg_replace('/[.\/\-\s]/u', '', mb_strtoupper($value));

        if (!is_string($normalized) || preg_match('/^[A-Z0-9]+$/D', $normalized) !== 1) {
            return null;
        }

        return $normalized;
    }

    public static function format(?string $value): ?string
    {
        $normalized = self::normalize($value);

        if ($normalized === null || preg_match('/^[A-Z0-9]{12}[0-9]{2}$/D', $normalized) !== 1) {
            return null;
        }

        return sprintf(
            '%s.%s.%s/%s-%s',
            substr($normalized, 0, 2),
            substr($normalized, 2, 3),
            substr($normalized, 5, 3),
            substr($normalized, 8, 4),
            substr($normalized, 12, 2),
        );
    }

    public static function isValid(?string $value): bool
    {
        $cnpj = self::normalize($value);

        if ($cnpj === null || preg_match('/^[A-Z0-9]{12}[0-9]{2}$/D', $cnpj) !== 1) {
            return false;
        }

        if (preg_match('/^(.)\1{13}$/D', $cnpj) === 1) {
            return false;
        }

        return self::digit(substr($cnpj, 0, 12), [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2]) === (int) $cnpj[12]
            && self::digit(substr($cnpj, 0, 13), [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2]) === (int) $cnpj[13];
    }

    /** @param list<int> $weights */
    private static function digit(string $base, array $weights): int
    {
        $sum = 0;

        foreach ($weights as $index => $weight) {
            $sum += (ord($base[$index]) - 48) * $weight;
        }

        $digit = 11 - ($sum % 11);

        return $digit >= 10 ? 0 : $digit;
    }
}
