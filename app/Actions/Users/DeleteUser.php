<?php

declare(strict_types = 1);

namespace App\Actions\Users;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use RuntimeException;

final readonly class DeleteUser
{
    public function __construct(private InvalidateUserSessions $invalidateUserSessions)
    {
    }

    public function handle(User $actor, User $user): void
    {
        DB::connection($user->getConnectionName())->transaction(function () use ($actor, $user): void {
            $actor = $actor->newQuery()->findOrFail($actor->id);
            $user  = $user->newQuery()->lockForUpdate()->findOrFail($user->id);

            Gate::forUser($actor)->authorize('delete', $user);

            $this->invalidateUserSessions->handle(user: $user);

            if (!$user->delete()) {
                throw new RuntimeException('Não foi possível desativar o usuário.');
            }
        });
    }
}
