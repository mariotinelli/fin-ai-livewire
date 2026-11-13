<?php

declare(strict_types = 1);

namespace App\Traits\Components;

trait WithSidepage
{
    public bool $sidepageOpen = false;

    public function openSidepage(): void
    {
        $this->sidepageOpen = true;
    }

    public function closeSidepage(): void
    {
        $this->sidepageOpen = false;
    }
}
