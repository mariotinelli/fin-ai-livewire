<?php

declare(strict_types = 1);

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Carbon;

trait ExpiresAccessMail
{
    private ?Carbon $accessMailExpiresAt = null;

    private ?string $accessMailEmail = null;

    protected function initializeAccessMail(int $tokenMinutes, ?string $email = null): void
    {
        $minutes                   = max(0, min($tokenMinutes, config()->integer('auth.access_mail_queue_minutes')));
        $this->accessMailExpiresAt = now()->addMinutes($minutes);
        $this->accessMailEmail     = $email;
    }

    public function captureRecipient(User $recipient): void
    {
        $this->accessMailEmail ??= $recipient->email;
    }

    public function isExpired(): bool
    {
        return $this->accessMailExpiresAt === null || $this->accessMailExpiresAt->lte(now());
    }

    protected function accessRecipient(User $notifiable): ?User
    {
        if ($this->isExpired()) {
            return null;
        }

        $this->captureRecipient($notifiable);
        $recipient = $notifiable->fresh();

        if ($recipient === null || $recipient->trashed()
            || $recipient->email !== $this->accessMailEmail || $notifiable->email !== $this->accessMailEmail) {
            return null;
        }

        return $recipient;
    }
}
