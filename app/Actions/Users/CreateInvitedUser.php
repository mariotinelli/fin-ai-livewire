<?php

declare(strict_types = 1);

namespace App\Actions\Users;

use App\Enums\TypeUsers;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

final readonly class CreateInvitedUser
{
    public function __construct(
        private CreateUser $createUser,
        private SendUserInvitation $sendUserInvitation,
    ) {
    }

    /**
     * @param array{name: string, email: string, type: TypeUsers|int|string, role_id?: int|null} $userData
     * @return array{user: User, status: string}
     */
    public function handle(array $userData): array
    {
        return DB::transaction(function () use ($userData): array {
            $user   = $this->createUser->handle(userData: $userData, password: Str::random(64), invitationPending: true);
            $status = $this->sendUserInvitation->handle(user: $user);

            return ['user' => $user, 'status' => $status];
        });
    }
}
