<?php

declare(strict_types = 1);

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserObserver
{
    public function updating(User $user): void
    {
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
    }

    public function updated(User $user): void
    {
        if (!$user->wasChanged('email')) {
            return;
        }

        $recipient = clone $user;

        DB::afterCommit(fn (): null => $recipient->sendEmailVerificationNotification());
    }
}
