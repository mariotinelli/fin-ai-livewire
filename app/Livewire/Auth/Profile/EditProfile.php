<?php

declare(strict_types = 1);

namespace App\Livewire\Auth\Profile;

use Illuminate\View\View;
use Livewire\Component;

class EditProfile extends Component
{
    public function render(): View
    {
        return view('livewire.auth.profile.edit-profile');
    }
}
