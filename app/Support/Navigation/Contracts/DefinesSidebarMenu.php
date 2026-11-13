<?php

declare(strict_types = 1);

namespace App\Support\Navigation\Contracts;

use App\Support\Navigation\SidebarGroup;

interface DefinesSidebarMenu
{
    /**
     * @return array<int, SidebarGroup>
     */
    public function groups(): array;
}
