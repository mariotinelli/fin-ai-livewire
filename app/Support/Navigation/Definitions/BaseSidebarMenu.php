<?php

declare(strict_types = 1);

namespace App\Support\Navigation\Definitions;

use App\Support\Navigation\Contracts\DefinesSidebarMenu;
use App\Support\Navigation\SidebarGroup;
use App\Support\Navigation\SidebarItem;

final readonly class BaseSidebarMenu implements DefinesSidebarMenu
{
    public function __construct(private string $dashboardRoute)
    {
    }

    public function groups(): array
    {
        return [
            new SidebarGroup(
                key: 'primary',
                label: null,
                items: [
                    new SidebarItem(
                        name: 'Dashboard',
                        route: $this->dashboardRoute,
                        icon: 'solid.home',
                    ),
                ],
            ),
        ];
    }
}
