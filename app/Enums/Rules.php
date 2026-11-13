<?php

declare(strict_types = 1);

namespace App\Enums;

enum Rules: string
{
    case Required = 'required';
    case Between  = 'between';
    case Min      = 'min';
    case Max      = 'max';

    /** @return list<string> */
    public static function moneyOrder(): array
    {
        return [
            self::Required->value,
            self::Between->value,
            self::Min->value,
            self::Max->value,
        ];
    }
}
