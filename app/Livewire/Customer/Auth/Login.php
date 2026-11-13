<?php

declare(strict_types = 1);

namespace App\Livewire\Customer\Auth;

use App\Enums\TypeUsers;
use App\Livewire\Auth\BaseLogin;
use Livewire\Attributes\Layout;

#[Layout('layouts.guest', ['variant' => 'split'])]
class Login extends BaseLogin
{
    protected function areaType(): TypeUsers
    {
        return TypeUsers::Customer;
    }

    protected function areaTitle(): string
    {
        return 'Área do cliente';
    }

    protected function context(): string
    {
        return 'customer';
    }
}
