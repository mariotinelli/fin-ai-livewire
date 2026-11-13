<?php

declare(strict_types = 1);

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\PasswordResetLinkSent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Component;

#[Layout('layouts.guest', ['variant' => 'split'])]
class ForgotPassword extends Component
{
    public string $email = '';

    #[Locked]
    public string $context = 'admin';

    public function mount(): void
    {
        $context       = request()->query('context');
        $this->context = in_array($context, ['admin', 'support', 'customer'], true) ? $context : 'admin';
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
        ];
    }

    public function render(): View
    {
        return view('livewire.auth.forgot-password', ['loginRoute' => $this->context . '.login']);
    }

    public function sendResetLink(): void
    {
        $this->validate();

        $prefix    = 'password-recovery:' . app()->environment();
        $recipient = hash_hmac('sha256', mb_strtolower(trim($this->email)), config()->string('app.key'));

        if (RateLimiter::increment($prefix . ':ip:' . request()->ip(), 60) > 5
            || RateLimiter::increment($prefix . ':recipient:' . $recipient, 3600) > 3) {
            session()->flash('status', __(Password::RESET_LINK_SENT));

            return;
        }

        $status = DB::transaction(function (): string {
            User::query()->where('email', $this->email)->lockForUpdate()->first();

            return Password::sendResetLink(
                ['email' => $this->email],
                function (User $user, string $token): void {
                    DB::afterCommit(function () use ($user, $token): void {
                        $user->sendPasswordResetNotification($token);
                        event(new PasswordResetLinkSent($user));
                    });
                },
            );
        });

        if (in_array($status, [Password::INVALID_USER, Password::RESET_THROTTLED], true)) {
            session()->flash('status', __(Password::RESET_LINK_SENT));

            return;
        }

        if ($status !== Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        session()->flash('status', __($status));
    }
}
