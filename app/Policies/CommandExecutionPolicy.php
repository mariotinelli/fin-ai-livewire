<?php

declare(strict_types = 1);

namespace App\Policies;

use App\Models\CommandExecution;
use App\Models\User;

class CommandExecutionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isSupportRemSoft();
    }

    public function view(User $user, CommandExecution $commandExecution): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $this->viewAny($user);
    }
}
