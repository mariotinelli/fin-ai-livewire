<?php

declare(strict_types = 1);

namespace App\Dev\Livewire;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;

/**
 * @property-read Collection<int, User> $users
 */
class Login extends Component
{
    private const string HOME = 'home';

    public ?int $selectedUser = null;

    public function boot(): void
    {
        abort_if(!withEnvBar(), Response::HTTP_UNAUTHORIZED);
    }

    public function mount(): void
    {
        $this->selectedUser = user()?->id;
    }

    public function render(): View
    {
        return view('livewire.dev.login');
    }

    /** @return Collection<int, User> */
    #[Computed]
    public function users(): Collection
    {
        abort_if(!withEnvBar(), Response::HTTP_UNAUTHORIZED);

        return User::query()
            // ->with('customer')
            ->get();
    }

    public function login(): Redirector | RedirectResponse
    {
        abort_if(!withEnvBar(), Response::HTTP_UNAUTHORIZED);

        $this->validate(['selectedUser' => ['required', 'integer']]);

        $user = User::query()->find($this->selectedUser);

        if (!$user instanceof User) {
            throw ValidationException::withMessages(['selectedUser' => 'Usuário indisponível para troca.']);
        }

        session()->put('fake_login', true);

        auth()->login($user);
        session()->regenerate();

        return redirect()->route(self::HOME);
    }
}
