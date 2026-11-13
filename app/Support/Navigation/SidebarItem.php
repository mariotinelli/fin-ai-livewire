<?php

declare(strict_types = 1);

namespace App\Support\Navigation;

final readonly class SidebarItem
{
    public function __construct(
        public string $name,
        public string $route,
        public string $icon,
        public ?string $prefix = null,
        public ?SidebarPermission $permission = null,
        public ?string $feature = null,
    ) {
    }
}
