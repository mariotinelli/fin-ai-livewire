<?php

declare(strict_types = 1);

namespace App\Livewire\Auth;

use App\Enums\TypeUsers;
use App\Support\Auth\IntendedDestination;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector as LivewireRedirector;

#[Layout('layouts.guest', ['variant' => 'split'])]
abstract class BaseLogin extends Component
{
    public string $email = '';

    public string $password = '';

    public bool $remember = false;

    public function render(): View
    {
        return view('livewire.auth.login', ['areaTitle' => $this->areaTitle(), 'context' => $this->context()]);
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    public function login(IntendedDestination $destination): RedirectResponse | LivewireRedirector
    {
        /** @var array{email: string, password: string} $data */
        $data = $this->validate();

        $this->ensureIsNotRateLimited();

        if (!Auth::attempt([
            'email'    => $data['email'],
            'password' => $data['password'],
            fn (Builder $query): Builder => $query->whereIn('type', $this->allowedUserTypes()),
        ], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());

        session()->regenerate();

        return redirect()->to($destination->pull($this->areaType()));
    }

    public function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => (int) ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email)) . '|' . request()->ip();
    }

    abstract protected function areaType(): TypeUsers;

    abstract protected function areaTitle(): string;

    abstract protected function context(): string;

    /** @return array<int, int> */
    protected function allowedUserTypes(): array
    {
        return $this->areaType() === TypeUsers::Admin ? TypeUsers::adminAreaValues() : [$this->areaType()->value];
    }
}
