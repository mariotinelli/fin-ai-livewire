<?php

declare(strict_types = 1);

namespace App\Notifications;

use App\Enums\Queues;
use App\Services\Notifications\DatabaseNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\Attributes\Backoff;
use Illuminate\Queue\Attributes\Queue;
use Illuminate\Queue\Attributes\Tries;

#[Queue(Queues::HighPriority)]
#[Tries(3)]
#[Backoff([10, 30, 60])]
class EmailDeliveryFailedNotification extends Notification implements ShouldQueue, ShouldBeEncrypted
{
    use Queueable;

    public function __construct(public readonly string $emailNotificationId)
    {
        $this->afterCommit();
    }

    /** @return list<string> */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /** @return array<string, mixed> */
    public function toDatabase(object $notifiable): array
    {
        return new DatabaseNotification()->error()->title('Falha no envio de e-mail')
            ->description('O envio de um e-mail não foi concluído. Referência: ' . $this->emailNotificationId . '.')
            ->toArray();
    }
}
