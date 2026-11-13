<?php

declare(strict_types = 1);

namespace App\Traits\Components;

trait WithModal
{
    public bool $modalOpen = false;

    public function openModal(): void
    {
        $this->clearValidation();
        $this->modalOpen = true;
    }

    public function closeModal(): void
    {
        $this->modalOpen = false;
    }
}
