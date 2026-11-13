<?php

declare(strict_types = 1);

namespace App\Enums;

enum SystemErrorAlertStatuses: int
{
    case Open         = 1;
    case Acknowledged = 2;
    case Resolved     = 3;

    public function label(): string
    {
        return match ($this) {
            self::Open         => 'Aberto',
            self::Acknowledged => 'Reconhecido',
            self::Resolved     => 'Resolvido',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Open         => 'error',
            self::Acknowledged => 'warning',
            self::Resolved     => 'success',
        };
    }

    /** @return array<int|string, string> */
    public static function options(): array
    {
        $options = [];

        foreach (self::cases() as $case) {
            $options[$case->value] = $case->label();
        }

        return $options;
    }
}
