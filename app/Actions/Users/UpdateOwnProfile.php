<?php

declare(strict_types = 1);

namespace App\Actions\Users;

use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\DB;

final readonly class UpdateOwnProfile
{
    /**
     * @param array{name: string, email: string} $profileData
     */
    public function handle(User $user, array $profileData): User
    {
        return DB::transaction(function () use ($user, $profileData): User {
            $user = User::withTrashed()->lockForUpdate()->findOrFail($user->id);

            if ($user->trashed()) {
                throw new AuthorizationException();
            }

            $email = mb_strtolower(trim($profileData['email']));

            if (mb_strtolower(trim($user->email)) === $email) {
                $email = $user->email;
            }

            $user->update(['name' => $profileData['name'], 'email' => $email]);

            return $user;
        });
    }
}
