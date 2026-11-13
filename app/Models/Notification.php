<?php

declare(strict_types = 1);

namespace App\Models;

use App\Observers\NotificationObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\DatabaseNotification;

#[ObservedBy([NotificationObserver::class])]
class Notification extends DatabaseNotification
{
    /** @use HasFactory<\Database\Factories\NotificationFactory> */
    use HasFactory;
    use SoftDeletes;

    protected function casts(): array
    {
        return [
            ...parent::casts(),
            'viewed_at' => 'datetime',
        ];
    }
}
