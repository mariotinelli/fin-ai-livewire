<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Auth;

use App\Actions\Users\CreateUser;
use App\Enums\TypeUsers;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request, CreateUser $createUser): RedirectResponse
    {
        /** @var array{name: string, email: string, password: string} $validated */
        $validated = $request->validate([
            'name'     => ['required', 'string', 'min:3', 'max:191'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:191', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults(), 'max:191'],
        ]);

        $user = $createUser->handle(
            userData: [
                'name'  => $validated['name'],
                'email' => $validated['email'],
                'type'  => TypeUsers::Customer,
            ],
            password: $validated['password'],
        );

        event(new Registered($user));

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route($user->type->initialRouteName());
    }
}
