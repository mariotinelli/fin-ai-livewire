<?php

declare(strict_types = 1);

namespace App\Actions\Notifications;

use App\Models\User;
use App\Support\NotificationCount;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

final readonly class MarkNotificationsViewed
{
    /** @param list<string> $notificationIds */
    public function handle(User $user, array $notificationIds): void
    {
        DB::transaction(function () use ($user, $notificationIds): void {
            $query         = $user->notifications()->whereIn('id', $notificationIds);
            $notifications = (clone $query)->lockForUpdate()->get(['id']);

            if ($notifications->count() !== count($notificationIds)) {
                throw ValidationException::withMessages(['notificationIds' => 'O lote contém notificações indisponíveis.']);
            }

            if ($query->whereNull('viewed_at')->update(['viewed_at' => now()]) > 0) {
                NotificationCount::forgetFor($user);
            }
        });
    }
}
