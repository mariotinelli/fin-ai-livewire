<?php

declare(strict_types = 1);

namespace App\Support;

final class FiscalDocument
{
    public static function normalize(?string $value): ?string
    {
        $cpf = Cpf::normalize($value);

        if ($cpf !== null && strlen($cpf) === 11) {
            return $cpf;
        }

        return Cnpj::normalize($value);
    }

    public static function format(?string $value): ?string
    {
        return match (true) {
            self::isCpf($value)  => Cpf::format($value),
            self::isCnpj($value) => Cnpj::format($value),
            default              => null,
        };
    }

    public static function isValid(?string $value): bool
    {
        return self::isCpf($value) || self::isCnpj($value);
    }

    public static function isCpf(?string $value): bool
    {
        return Cpf::isValid($value);
    }

    public static function isCnpj(?string $value): bool
    {
        return Cnpj::isValid($value);
    }
}
