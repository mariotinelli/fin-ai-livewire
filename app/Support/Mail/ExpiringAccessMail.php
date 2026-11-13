<?php

declare(strict_types = 1);

namespace App\Support\Mail;

use App\Models\User;

interface ExpiringAccessMail
{
    public function captureRecipient(User $recipient): void;

    public function isExpired(): bool;
}
