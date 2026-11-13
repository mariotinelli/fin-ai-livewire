<?php

declare(strict_types = 1);

namespace App\Actions\Users;

use App\Enums\TypeUsers;
use App\Models\User;
use SensitiveParameter;

final readonly class CreateUser
{
    /**
     * @param array{name: string, email: string, type: TypeUsers|int|string, role_id?: int|null} $userData
     */
    public function handle(array $userData, #[SensitiveParameter] string $password, bool $invitationPending = false): User
    {
        $type = $userData['type'] instanceof TypeUsers
            ? $userData['type']
            : TypeUsers::from(filter_var($userData['type'], FILTER_VALIDATE_INT) ?: throw new \ValueError('Tipo de usuário inválido.'));

        return User::query()->create([
            'name'               => $userData['name'],
            'email'              => $userData['email'],
            'type'               => $type,
            'role_id'            => $userData['role_id'] ?? null,
            'password'           => $password,
            'invitation_pending' => $invitationPending,
        ]);
    }
}
