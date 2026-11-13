<?php

declare(strict_types = 1);

namespace App\Traits\Components;

trait WithLoading
{
    public function showLoading(): void
    {
        $this->dispatch('toggle-loading', loading: true);
    }

    public function hideLoading(): void
    {
        $this->dispatch('toggle-loading', loading : false);
    }
}
