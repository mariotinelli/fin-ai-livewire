<?php

declare(strict_types = 1);

namespace App\Enums\Permissions\Management;

enum RolePermissions: string
{
    case View   = 'view roles';
    case Create = 'create roles';
    case Edit   = 'edit roles';

    public function label(): string
    {
        return match ($this) {
            self::View   => 'Visualizar Perfis',
            self::Create => 'Criar Perfis',
            self::Edit   => 'Editar Perfis',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::View   => 'Permite visualizar o menu de perfis e a lista de perfis',
            self::Create => 'Permite criar novos perfis',
            self::Edit   => 'Permite editar perfis',
        };
    }

    /** @return list<self> */
    public static function all(): array
    {
        return [
            self::View,
            self::Create,
            self::Edit,
        ];
    }
}
