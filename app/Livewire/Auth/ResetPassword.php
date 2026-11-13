<?php

declare(strict_types = 1);

namespace App\Livewire\Auth;

use App\Actions\Users\ResetUserPassword;
use App\Models\User;
use App\Traits\Components\WithToast;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Component;

#[Layout('layouts.guest', ['variant' => 'split'])]
class ResetPassword extends Component
{
    use WithToast;

    private const int MAX_RESET_ATTEMPTS = 5;

    private const int RESET_DECAY_SECONDS = 60;

    public string $token = '';

    public string $email = '';

    #[Locked]
    public string $context = 'admin';

    public string $password = '';

    public string $password_confirmation = '';

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'token'    => ['required', 'string'],
            'email'    => ['required', 'email'],
            'password' => ['required', 'string', 'confirmed'],
        ];
    }

    public function render(): View
    {
        return view('livewire.auth.reset-password');
    }

    public function mount(string $token): void
    {
        $context       = request()->query('context');
        $this->context = in_array($context, ['admin', 'support', 'customer'], true) ? $context : 'admin';

        $this->token = $token;
        $email       = request()->get('email', '');
        $this->email = is_string($email) ? $email : '';
    }

    public function save(ResetUserPassword $resetUserPassword): RedirectResponse | Redirector | null
    {
        $this->email = mb_strtolower(trim($this->email));
        $this->ensureIsNotRateLimited();
        RateLimiter::hit($this->throttleKey(), self::RESET_DECAY_SECONDS);

        $this->validate();

        if (!$this->hasValidResetToken()) {
            $this->addError('email', __(Password::INVALID_TOKEN));

            return null;
        }

        $this->validate(['password' => ['required', 'string', 'confirmed', Rules\Password::defaults()]]);

        $status = $resetUserPassword->handle(
            email: $this->email,
            password: $this->password,
            token: $this->token,
        );

        if ($status === Password::PASSWORD_RESET) {
            RateLimiter::clear($this->throttleKey());
            $this->toast('Senha resetada com sucesso', nextPage: true);

            return redirect()->route(User::query()->where('email', $this->email)->first()?->type->loginRouteName() ?? 'admin.login');
        }

        $this->addError('email', __($status));

        return null;
    }

    private function hasValidResetToken(): bool
    {
        $user = User::query()->where('email', $this->email)->first();

        return $user instanceof User && Password::tokenExists($user, $this->token);
    }

    private function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), self::MAX_RESET_ATTEMPTS)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans_choice('passwords.reset_throttled', $seconds, ['seconds' => $seconds]),
        ]);
    }

    private function throttleKey(): string
    {
        return 'password-reset|' . mb_strtolower(trim($this->email)) . '|' . request()->ip();
    }
}
