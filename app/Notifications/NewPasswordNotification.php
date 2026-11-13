<?php

declare(strict_types = 1);

namespace App\Notifications;

use App\Enums\Queues;
use App\Models\User;
use App\Support\Mail\ExpiringAccessMail;
use App\Traits\ExpiresAccessMail;
use App\Traits\QueuesMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
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
class NewPasswordNotification extends Notification implements ShouldQueue, ShouldBeEncrypted, ExpiringAccessMail
{
    use Queueable;
    use QueuesMail;
    use ExpiresAccessMail;

    public function __construct(public string $token)
    {
        $this->afterCommit();
        $this->initializeAccessMail(config()->integer('auth.passwords.' . Password::getDefaultDriver() . '.expire'));
    }

    /** @return list<string> */
    public function via(User $notifiable): array
    {
        return ['mail'];
    }

    public function shouldSend(User $notifiable, string $channel): bool
    {
        $recipient = $this->accessRecipient($notifiable);

        return $recipient instanceof User && Password::tokenExists($recipient, $this->token);
    }

    public function toMail(User $notifiable): MailMessage
    {
        return new MailMessage()
            ->subject('Redefinição de senha - ' . config()->string('app.name'))
            ->greeting('Olá ' . $notifiable->name . '!')
            ->line('Recebemos uma solicitação para redefinir sua senha.')
            ->line('Para criar uma nova senha, clique no botão abaixo:')
            ->action(
                'Redefinir minha senha',
                route('password.reset', ['token' => $this->token, 'email' => $notifiable->email, 'context' => str($notifiable->type->loginRouteName())->before('.login')->value()])
            )
            ->line('Se você não solicitou a redefinição de senha, ignore este e-mail.')
            ->line('*Este é um e-mail automático, por favor não responda.*')
            ->salutation('Atenciosamente, ' . config()->string('app.name'))
            ->markdown('vendor.notifications.email');
    }
}
