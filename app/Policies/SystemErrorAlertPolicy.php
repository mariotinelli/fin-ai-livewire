<?php

declare(strict_types = 1);

namespace App\Policies;

use App\Models\SystemErrorAlert;
use App\Models\User;

class SystemErrorAlertPolicy
{
    public function viewAny(User $user): bool
    {
        return $this->canAccess($user);
    }

    public function view(User $user, SystemErrorAlert $systemErrorAlert): bool
    {
        return $this->canAccess($user);
    }

    public function update(User $user, SystemErrorAlert $systemErrorAlert): bool
    {
        return $this->canAccess($user);
    }

    private function canAccess(User $user): bool
    {
        return $user->isSupportRemSoft();
    }
}
