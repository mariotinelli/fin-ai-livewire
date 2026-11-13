<?php

declare(strict_types = 1);

namespace App\Notifications;

use App\Enums\Queues;
use App\Models\User;
use App\Support\Mail\ExpiringAccessMail;
use App\Traits\ExpiresAccessMail;
use App\Traits\QueuesMail;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\Attributes\Backoff;
use Illuminate\Queue\Attributes\DeleteWhenMissingModels;
use Illuminate\Queue\Attributes\MaxExceptions;
use Illuminate\Queue\Attributes\Queue;
use Illuminate\Queue\Attributes\Tries;

#[Queue(Queues::LowPriority)]
#[Tries(3)]
#[DeleteWhenMissingModels]
#[MaxExceptions(3)]
#[Backoff([10, 30, 60, 120])]
class VerifyEmailNotification extends VerifyEmail implements ShouldQueue, ShouldBeEncrypted, ExpiringAccessMail
{
    use Queueable;
    use QueuesMail;
    use ExpiresAccessMail;

    public function __construct()
    {
        $this->afterCommit();
        $this->initializeAccessMail(config()->integer('auth.verification.expire', 60));
    }

    public function shouldSend(User $notifiable, string $channel): bool
    {
        $recipient = $this->accessRecipient($notifiable);

        return $recipient instanceof User && !$recipient->hasVerifiedEmail();
    }
}
