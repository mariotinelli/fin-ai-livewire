<?php

declare(strict_types = 1);

namespace App\Livewire\Support\Auth;

use App\Enums\TypeUsers;
use App\Livewire\Auth\BaseLogin;
use Livewire\Attributes\Layout;

#[Layout('layouts.guest', ['variant' => 'split'])]
class Login extends BaseLogin
{
    protected function areaType(): TypeUsers
    {
        return TypeUsers::SupportRemSoft;
    }

    protected function areaTitle(): string
    {
        return 'Área de suporte';
    }

    protected function context(): string
    {
        return 'support';
    }
}
