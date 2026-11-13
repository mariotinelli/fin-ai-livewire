<?php

declare(strict_types = 1);

namespace App\Support\Navigation;

final readonly class SidebarGroup
{
    /**
     * @param  array<int, SidebarItem>  $items
     */
    public function __construct(
        public string $key,
        public ?string $label,
        public array $items,
    ) {
    }
}
