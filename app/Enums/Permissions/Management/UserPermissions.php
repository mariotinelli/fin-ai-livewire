<?php

declare(strict_types = 1);

namespace App\Enums\Permissions\Management;

enum UserPermissions: string
{
    case View    = 'view users';
    case Create  = 'create users';
    case Edit    = 'edit users';
    case Delete  = 'delete users';
    case Restore = 'restore users';

    public function label(): string
    {
        return match ($this) {
            self::View    => 'Visualizar Usuários',
            self::Create  => 'Criar Usuários',
            self::Edit    => 'Editar Usuários',
            self::Delete  => 'Desativar Usuários',
            self::Restore => 'Ativar Usuários',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::View    => 'Permite visualizar o menu de usuários e a lista de usuários',
            self::Create  => 'Permite criar novos usuários',
            self::Edit    => 'Permite editar usuários',
            self::Delete  => 'Permite desativar usuários',
            self::Restore => 'Permite ativar usuários',
        };
    }

    /** @return list<self> */
    public static function all(): array
    {
        return [
            self::View,
            self::Create,
            self::Edit,
            self::Delete,
            self::Restore,
        ];
    }
}
