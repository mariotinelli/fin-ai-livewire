<?php

declare(strict_types = 1);

namespace App\Support\Navigation;

final readonly class SidebarPermission
{
    /**
     * @param  array<int, mixed>  $arguments
     */
    public function __construct(
        public string $ability,
        public array $arguments = [],
    ) {
    }
}
