<?php

declare(strict_types = 1);

namespace App\Actions\Users;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use SensitiveParameter;

final readonly class ResetUserPassword
{
    public function __construct(private InvalidateUserSessions $invalidateUserSessions)
    {
    }

    public function handle(string $email, #[SensitiveParameter] string $password, #[SensitiveParameter] string $token): string
    {
        return DB::transaction(function () use ($email, $password, $token): string {
            User::query()->where('email', $email)->lockForUpdate()->first();

            /** @var string $status */
            $status = Password::reset(
                ['email' => $email, 'password' => $password, 'token' => $token],
                $this->resetCredentialsAndRevokeSessions(...),
            );

            return $status;
        });
    }

    private function resetCredentialsAndRevokeSessions(User $user, #[SensitiveParameter] string $password): void
    {
        $user->forceFill([
            'password'           => Hash::make($password),
            'invitation_pending' => false,
        ])->save();

        $this->invalidateUserSessions->handle(user: $user);
        $user->refresh();

        DB::afterCommit(function () use ($user): void {
            event(new PasswordReset($user));
        });
    }
}
