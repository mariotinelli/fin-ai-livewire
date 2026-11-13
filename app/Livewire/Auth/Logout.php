<?php

declare(strict_types = 1);

namespace App\Livewire\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;

class Logout extends Component
{
    public function render(): View
    {
        return view('livewire.auth.logout');
    }

    public function logout(): RedirectResponse | Redirector
    {
        $loginRoute = Auth::user()?->type->loginRouteName() ?? 'admin.login';
        Auth::logoutCurrentDevice();

        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route($loginRoute);
    }
}
