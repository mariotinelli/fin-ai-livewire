<?php

declare(strict_types = 1);

namespace App\Enums;

enum Status: string
{
    case All         = 'all';
    case Active      = 'active';
    case Deactivated = 'deactivated';

    public function label(): string
    {
        return match ($this) {
            self::All         => 'Todos',
            self::Active      => 'Ativos',
            self::Deactivated => 'Desativados',
        };
    }

    /** @return array<string, string> */
    public static function toArray(): array
    {
        return [
            self::All->value         => self::All->label(),
            self::Active->value      => self::Active->label(),
            self::Deactivated->value => self::Deactivated->label(),
        ];
    }
}
