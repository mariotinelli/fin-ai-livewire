<?php

declare(strict_types = 1);

namespace App\Livewire\Auth\Profile\Partials;

use App\Actions\Users\UpdateOwnProfile;
use App\Traits\Components\WithToast;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Livewire\Component;

class UpdateProfileInformationForm extends Component
{
    use WithToast;

    public string $name = '';

    public string $email = '';

    /** @return array<string, mixed> */
    protected function rules(): array
    {
        return [
            'name'  => ['required', 'string', 'max:191'],
            'email' => ['required', 'email', 'max:191', Rule::unique('users')->ignore(auth()->id())],
        ];
    }

    public function render(): View
    {
        return view('livewire.auth.profile.partials.update-profile-information-form');
    }

    public function mount(): void
    {
        abort_unless(Auth::check(), 403);

        $this->name  = authenticatedUser()->name;
        $this->email = authenticatedUser()->email;
    }

    public function save(UpdateOwnProfile $updateOwnProfile): void
    {
        abort_unless(Auth::check(), 403);

        $this->email = mb_strtolower(trim($this->email));
        $this->validate();

        if ($this->email !== mb_strtolower(trim(authenticatedUser()->email))
            && RateLimiter::increment('profile-email-change:' . app()->environment() . ':' . Auth::id(), 3600) > 3) {
            throw ValidationException::withMessages(['email' => 'Limite de alterações de e-mail atingido. Tente novamente mais tarde.']);
        }

        $user = $updateOwnProfile->handle(
            user: authenticatedUser(),
            profileData: ['name' => $this->name, 'email' => $this->email],
        );

        Auth::setUser($user);

        $this->name  = $user->name;
        $this->email = $user->email;

        $this->dispatch('profile::updated', name: $user->name, initials: $user->initials);
        $this->toast('Perfil atualizado com sucesso!');
    }
}
