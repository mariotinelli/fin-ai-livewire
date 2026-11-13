<?php

declare(strict_types = 1);

namespace App\Support\Navigation\Definitions;

use App\Models\CommandExecution;
use App\Models\SystemErrorAlert;
use App\Support\Navigation\Contracts\DefinesSidebarMenu;
use App\Support\Navigation\SidebarGroup;
use App\Support\Navigation\SidebarItem;
use App\Support\Navigation\SidebarPermission;

final class SupportRemSoftSidebarMenu implements DefinesSidebarMenu
{
    public function groups(): array
    {
        return [
            new SidebarGroup(
                key: 'support',
                label: 'Suporte',
                items: [
                    new SidebarItem(
                        name: 'Comandos',
                        route: 'support.artisan-commands.index',
                        icon: 'command-line',
                        prefix: 'support.artisan-commands',
                        permission: new SidebarPermission('viewAny', [CommandExecution::class]),
                    ),
                    new SidebarItem(
                        name: 'Alertas de Erro',
                        route: 'support.system-error-alerts.index',
                        icon: 'solid.exclamation-triangle',
                        prefix: 'support.system-error-alerts',
                        permission: new SidebarPermission('viewAny', [SystemErrorAlert::class]),
                    ),
                ],
            ),
        ];
    }
}
