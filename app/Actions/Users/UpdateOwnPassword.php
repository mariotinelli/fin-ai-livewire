<?php

declare(strict_types = 1);

namespace App\Actions\Users;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use SensitiveParameter;

final readonly class UpdateOwnPassword
{
    public function __construct(private InvalidateUserSessions $invalidateUserSessions)
    {
    }

    public function handle(User $user, #[SensitiveParameter] string $currentPassword, #[SensitiveParameter] string $password, string $currentSessionId): User
    {
        return DB::connection($user->getConnectionName())->transaction(function () use ($user, $currentPassword, $password, $currentSessionId): User {
            $lockedUser = $user->newQuery()->lockForUpdate()->findOrFail($user->id);

            if (!Hash::check($currentPassword, $lockedUser->password)) {
                throw ValidationException::withMessages(['current_password' => ['A senha atual está incorreta.']]);
            }

            $lockedUser->update(['password' => Hash::make($password)]);
            $this->invalidateUserSessions->handle(user: $lockedUser, exceptSessionId: $currentSessionId);

            return $lockedUser->refresh();
        });
    }
}
