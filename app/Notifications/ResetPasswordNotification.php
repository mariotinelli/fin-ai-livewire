<?php

declare(strict_types = 1);

namespace App\Notifications;

use App\Enums\Queues;
use App\Models\User;
use App\Support\Mail\ExpiringAccessMail;
use App\Traits\ExpiresAccessMail;
use App\Traits\QueuesMail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\Attributes\Backoff;
use Illuminate\Queue\Attributes\DeleteWhenMissingModels;
use Illuminate\Queue\Attributes\MaxExceptions;
use Illuminate\Queue\Attributes\Queue;
use Illuminate\Queue\Attributes\Tries;
use Illuminate\Support\Facades\Password;

#[Queue(Queues::LowPriority)]
#[Tries(3)]
#[DeleteWhenMissingModels]
#[MaxExceptions(3)]
#[Backoff([10, 30, 60, 120])]
class ResetPasswordNotification extends ResetPassword implements ShouldQueue, ShouldBeEncrypted, ExpiringAccessMail
{
    use Queueable;
    use QueuesMail;
    use ExpiresAccessMail;

    public function __construct(string $token, public string $email)
    {
        parent::__construct($token);
        $this->afterCommit();
        $this->initializeAccessMail(config()->integer('auth.passwords.' . Password::getDefaultDriver() . '.expire'), $this->email);
    }

    public function shouldSend(User $notifiable, string $channel): bool
    {
        $recipient = $this->accessRecipient($notifiable);

        return $recipient instanceof User && Password::tokenExists($recipient, $this->token);
    }
}
