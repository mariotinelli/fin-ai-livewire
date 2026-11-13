<?php

declare(strict_types = 1);

namespace App\Enums;

enum Queues: string
{
    case LowPriority  = 'low_priority';
    case HighPriority = 'high_priority';
    case LongTimeout  = 'long_timeout';

    /** @return list<string> */
    public static function all(): array
    {
        return array_column(self::cases(), 'value');
    }
}
