<?php

declare(strict_types = 1);

namespace App\Actions\Notifications;

use App\Models\User;
use App\Support\NotificationCount;
use Illuminate\Support\Facades\DB;

final readonly class MarkNotificationsRead
{
    public function handle(User $user, ?string $notificationId = null): void
    {
        DB::transaction(function () use ($user, $notificationId): void {
            $query = $user->notifications();

            if ($notificationId !== null) {
                $query->whereKey($notificationId);
                (clone $query)->lockForUpdate()->firstOrFail();
            }

            $timestamp = now()->toDateTimeString();
            $read      = (clone $query)->whereNull('read_at')->update(['read_at' => $timestamp]);
            $viewed    = (clone $query)->whereNull('viewed_at')->update(['viewed_at' => $timestamp]);

            if ($read > 0 || $viewed > 0) {
                NotificationCount::forgetFor($user);
            }
        });
    }
}
