<?php

declare(strict_types = 1);

namespace App\Actions\Users;

use App\Enums\TypeUsers;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;

final readonly class UpdateUser
{
    /**
     * @param array{name: string, email: string, type: TypeUsers|int|string, role_id?: int|null} $userData
     */
    public function handle(User $user, array $userData): User
    {
        return DB::transaction(function () use ($user, $userData): User {
            $user  = User::withTrashed()->lockForUpdate()->findOrFail($user->id);
            $email = trim($userData['email']);

            if (mb_strtolower(trim($user->email)) === mb_strtolower($email)) {
                $email = $user->email;
            } elseif ($user->invitation_pending) {
                Password::deleteToken($user);
            }

            $type = $userData['type'] instanceof TypeUsers
                ? $userData['type']
                : TypeUsers::from(filter_var($userData['type'], FILTER_VALIDATE_INT) ?: throw new \ValueError('Tipo de usuário inválido.'));

            $user->update([
                'name'    => $userData['name'],
                'email'   => $email,
                'type'    => $type,
                'role_id' => data_get($userData, 'role_id', $user->role_id),
            ]);

            return $user;
        });
    }
}
