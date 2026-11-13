<?php

declare(strict_types = 1);

namespace App\Actions\Users;

use App\Enums\TypeUsers;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

final readonly class ResendUserInvitation
{
    public function __construct(private SendUserInvitation $sendUserInvitation)
    {
    }

    public function handle(User $user): string
    {
        return DB::transaction(function () use ($user): string {
            $recipient = User::withTrashed()->lockForUpdate()->findOrFail($user->id);

            if ($recipient->trashed() || $recipient->type !== TypeUsers::User || !$recipient->invitation_pending) {
                throw ValidationException::withMessages([
                    'invitation' => 'O reenvio exige um usuário ativo com convite pendente.',
                ]);
            }

            return $this->sendUserInvitation->handle(user: $recipient);
        });
    }
}
