<?php

declare(strict_types = 1);

namespace App\Enums;

use App\Enums\Permissions\Management\RolePermissions;
use App\Enums\Permissions\Management\UserPermissions;

enum Can: string
{
    /** @return list<RolePermissions|UserPermissions> */
    public static function allCases(): array
    {
        return [
            ...RolePermissions::cases(),
            ...UserPermissions::cases(),
            ...self::cases(),
        ];
    }

    /** @return array<string, object{label: string, permissions: list<\BackedEnum>}> */
    public static function management(): array
    {
        return [
            'roles' => (object) [
                'label'       => 'Perfis',
                'permissions' => RolePermissions::all(),
            ],
            'users' => (object) [
                'label'       => 'Usuários',
                'permissions' => UserPermissions::all(),
            ],
        ];
    }

    /** @return array<string, object{label: string, group: array<string, object{label: string, permissions: list<\BackedEnum>}>}> */
    public static function groups(): array
    {
        return [
            'management' => (object) [
                'label' => 'Gestão',
                'group' => Can::management(),
            ],
        ];
    }
}
