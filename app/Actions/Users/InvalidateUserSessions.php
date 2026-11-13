<?php

declare(strict_types = 1);

namespace App\Actions\Users;

use App\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use LogicException;

final readonly class InvalidateUserSessions
{
    /**
     * Requires database sessions on the user's connection for atomic revocation.
     */
    public function handle(User $user, ?string $exceptSessionId = null): void
    {
        $connection        = $user->getConnectionName() ?? config('database.default');
        $sessionConnection = config('session.connection') ?? config('database.default');

        if (!is_string($connection) || !is_string($sessionConnection)) {
            throw new LogicException('Configuração de conexão de sessões inválida.');
        }

        if (config('session.driver') !== 'database' || $sessionConnection !== $connection) {
            throw new LogicException('A invalidação de sessões exige o driver database na mesma conexão do usuário.');
        }

        DB::connection($connection)->transaction(function () use ($user, $exceptSessionId, $connection): void {
            $lockedUser = $user->newQuery()->withTrashed()->lockForUpdate()->findOrFail($user->id);
            $lockedUser->update(['remember_token' => Str::random(60)]);

            DB::connection($connection)->table(config()->string('session.table'))
                ->where('user_id', $lockedUser->id)
                ->when($exceptSessionId !== null, fn (Builder $query): Builder => $query->where('id', '<>', $exceptSessionId))
                ->delete();
        });
    }
}
