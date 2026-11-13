<?php

declare(strict_types = 1);

namespace App\Actions\Notifications;

use App\Models\User;
use Illuminate\Support\Facades\DB;

final readonly class DeleteNotification
{
    public function handle(User $user, string $notificationId): void
    {
        DB::transaction(function () use ($user, $notificationId): void {
            $notification = $user->notifications()->withTrashed()->whereKey($notificationId)->lockForUpdate()->firstOrFail();

            if (!$notification->trashed()) {
                $notification->delete();
            }
        });
    }
}
