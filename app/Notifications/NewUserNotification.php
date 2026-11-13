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
class NewUserNotification extends Notification implements ShouldQueue, ShouldBeEncrypted, ExpiringAccessMail
{
    use Queueable;
    use QueuesMail;
    use ExpiresAccessMail;

    public function __construct(public string $token, public string $email)
    {
        $this->afterCommit();
        $this->initializeAccessMail(config()->integer('auth.passwords.' . Password::getDefaultDriver() . '.expire'), $this->email);
    }

    /** @return list<string> */
    public function via(User $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(User $notifiable): MailMessage
    {
        return new MailMessage()
            ->subject('Nova conta cadastrada no sistema ' . config()->string('app.name'))
            ->greeting('Olá ' . $notifiable->name . '!')
            ->line('Uma nova conta foi criada para você em nosso sistema!')
            ->line('Defina sua senha para concluir o primeiro acesso.')
            ->action('Definir minha senha', route('password.reset', ['token' => $this->token, 'email' => $this->email, 'context' => str($notifiable->type->loginRouteName())->before('.login')->value()]))
            ->line('Este convite é de uso único e expira em ' . config()->integer('auth.passwords.' . config()->string('auth.defaults.passwords') . '.expire') . ' minutos após a emissão.')
            ->line('Se o convite expirar, solicite um novo link em [Recuperar acesso](' . route('password.forgot', ['context' => str($notifiable->type->loginRouteName())->before('.login')->value()]) . ').')
            ->line('*Este é um email automático, por favor não responda*')
            ->salutation('Atenciosamente')
            ->markdown('vendor.notifications.email');
    }

    public function shouldSend(User $notifiable, string $channel): bool
    {
        $recipient = $this->accessRecipient($notifiable);

        return $recipient instanceof User && Password::tokenExists($recipient, $this->token);
    }
}
