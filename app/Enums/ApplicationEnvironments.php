<?php

declare(strict_types = 1);

namespace App\Enums;

use InvalidArgumentException;

enum ApplicationEnvironments: string
{
    case Local      = 'local';
    case Testing    = 'testing';
    case Qa         = 'qa';
    case Homolog    = 'homolog';
    case Production = 'production';

    public static function fromName(string $environment): self
    {
        return match (strtolower(trim($environment))) {
            'local'              => self::Local,
            'testing'            => self::Testing,
            'qa'                 => self::Qa,
            'hml', 'homolog'     => self::Homolog,
            'prod', 'production' => self::Production,
            default              => throw new InvalidArgumentException("Ambiente de aplicação inválido: {$environment}."),
        };
    }

    public function isDeployed(): bool
    {
        return !in_array($this, [self::Local, self::Testing], true);
    }
}
