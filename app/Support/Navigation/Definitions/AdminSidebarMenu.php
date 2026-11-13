<?php

declare(strict_types = 1);

namespace App\Support\Navigation\Definitions;

use App\Models\Role;
use App\Models\User;
use App\Support\Navigation\Contracts\DefinesSidebarMenu;
use App\Support\Navigation\SidebarGroup;
use App\Support\Navigation\SidebarItem;
use App\Support\Navigation\SidebarPermission;

final class AdminSidebarMenu implements DefinesSidebarMenu
{
    public function groups(): array
    {
        return [
            new SidebarGroup(
                key: 'primary',
                label: null,
                items: [
                    new SidebarItem(
                        name: 'Dashboard',
                        route: 'admin.dashboard',
                        icon: 'solid.home',
                    ),
                ],
            ),
            new SidebarGroup(
                key: 'management',
                label: 'Gestão',
                items: [
                    new SidebarItem(
                        name: 'Usuários',
                        route: 'admin.management.users.index',
                        icon: 'solid.users',
                        prefix: 'admin.management.users',
                        permission: new SidebarPermission('viewAny', [User::class]),
                    ),
                    new SidebarItem(
                        name: 'Perfis',
                        route: 'admin.management.roles.index',
                        icon: 'solid.tag',
                        prefix: 'admin.management.roles',
                        permission: new SidebarPermission('viewAny', [Role::class]),
                    ),
                ],
            ),
        ];
    }
}
