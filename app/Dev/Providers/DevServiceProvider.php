<?php

declare(strict_types = 1);

namespace App\Dev\Providers;

use App\Dev\Livewire\EnvBar;
use App\Dev\Livewire\Login;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class DevServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Livewire::component('dev.env-bar', EnvBar::class);
        Livewire::component('dev.login', Login::class);
    }
}
