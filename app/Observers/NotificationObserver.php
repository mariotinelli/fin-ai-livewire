<?php

declare(strict_types = 1);

namespace App\Observers;

use App\Models\Notification;
use App\Support\NotificationCount;

class NotificationObserver
{
    /** Captura as identidades antes de syncOriginal; o helper posterga somente a invalidação. */
    public function saved(Notification $notification): void
    {
        NotificationCount::forget((string) $notification->notifiable_type, (string) $notification->notifiable_id, $notification->getConnectionName());

        if ($notification->wasChanged(['notifiable_type', 'notifiable_id'])) {
            $type = $notification->getRawOriginal('notifiable_type');
            $id   = $notification->getRawOriginal('notifiable_id');

            if (is_string($type) && (is_string($id) || is_int($id))) {
                NotificationCount::forget($type, (string) $id, $notification->getConnectionName());
            }
        }
    }

    public function deleted(Notification $notification): void
    {
        NotificationCount::forget((string) $notification->notifiable_type, (string) $notification->notifiable_id, $notification->getConnectionName());
    }
}
