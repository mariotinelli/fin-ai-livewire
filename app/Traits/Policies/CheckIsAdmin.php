<?php

declare(strict_types = 1);

namespace App\Traits\Policies;

use App\Models\User;

trait CheckIsAdmin
{
    public function before(User $user, string $ability): ?bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null;
    }
}
