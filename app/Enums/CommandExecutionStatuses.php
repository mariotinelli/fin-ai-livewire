<?php

declare(strict_types = 1);

namespace App\Enums;

enum CommandExecutionStatuses: int
{
    case Queued     = 1;
    case InProgress = 2;
    case Success    = 3;
    case Error      = 4;

    public function label(): string
    {
        return match ($this) {
            self::Queued     => 'Em fila',
            self::InProgress => 'Em execução',
            self::Success    => 'Sucesso',
            self::Error      => 'Erro',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Queued     => 'info',
            self::InProgress => 'warning',
            self::Success    => 'success',
            self::Error      => 'error',
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
