<?php

declare(strict_types = 1);

namespace App\Jobs;

use App\Enums\Queues;
use App\Models\User;
use App\Notifications\EmailDeliveryFailedNotification;
use App\Support\Alerts\DiscordAlert;
use App\Support\Alerts\DiscordAlertDeliveryException;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Http\Client\RequestException;
use Illuminate\Queue\Attributes\Backoff;
use Illuminate\Queue\Attributes\Queue;
use Illuminate\Queue\Attributes\Tries;
use Illuminate\Queue\Attributes\UniqueFor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Throwable;

#[Queue(Queues::HighPriority)]
#[Tries(3)]
#[UniqueFor(300)]
#[Backoff([10, 30, 60])]
class NotifyEmailDeliveryFailureJob implements ShouldQueue, ShouldBeEncrypted, ShouldBeUnique
{
    use Queueable;

    public function __construct(public readonly string $emailNotificationId)
    {
    }

    public function uniqueId(): string
    {
        return $this->emailNotificationId;
    }

    public function handle(DiscordAlert $discord): void
    {
        $this->notifyInternally();
        $this->notifyDiscord($discord);
    }

    private function notifyInternally(): void
    {
        DB::transaction(function (): void {
            $record = $this->failure()->lockForUpdate()->first();

            if ($record === null || $record->notified_at !== null) {
                return;
            }

            $requester  = $record->requester_id === null ? null : User::query()->find($record->requester_id);
            $recipients = $requester === null ? User::query()->admins()->get() : collect([$requester]);

            if ($recipients->isEmpty()) {
                return;
            }

            Notification::sendNow($recipients, new EmailDeliveryFailedNotification($this->emailNotificationId));
            $this->failure()->update(['notified_at' => now(), 'updated_at' => now()]);
        });
    }

    private function notifyDiscord(DiscordAlert $discord): void
    {
        try {
            DB::transaction(function () use ($discord): void {
                $record = $this->failure()->lockForUpdate()->first();

                if ($record === null || $record->discord_notified_at !== null) {
                    return;
                }

                $delivered = $discord->send([
                    'content' => 'Falha definitiva no envio de e-mail.',
                    'embeds'  => [[
                        'title'  => 'Falha no envio de e-mail',
                        'color'  => 15158332,
                        'fields' => [
                            ['name' => 'Referência', 'value' => $this->emailNotificationId, 'inline' => false],
                            ['name' => 'Ambiente', 'value' => $record->environment, 'inline' => true],
                            ['name' => 'Tentativas', 'value' => is_scalar($record->attempt_count) ? (string) $record->attempt_count : 'N/A', 'inline' => true],
                        ],
                    ]],
                ]);

                if ($delivered) {
                    $this->failure()->update(['discord_notified_at' => now(), 'updated_at' => now()]);
                }
            });
        } catch (Throwable $throwable) {
            throw new DiscordAlertDeliveryException(
                'Falha no alerta de e-mail: ' . get_debug_type($throwable) . '.',
                $throwable instanceof RequestException ? $throwable->response->status() : 0,
            );
        }
    }

    private function failure(): Builder
    {
        return DB::table('email_notifications')->where('id', $this->emailNotificationId)
            ->whereNotNull('failed_at')->whereNull('accepted_at')->whereNull('skipped_at')->whereNull('uncertain_at');
    }

    public function failed(?Throwable $exception): void
    {
        Log::error('Esgotadas as tentativas do alerta de falha de e-mail.', [
            'email_notification_id' => $this->emailNotificationId,
            'exception'             => $exception instanceof Throwable ? get_debug_type($exception) : null,
            'code'                  => (int) ($exception?->getCode() ?? 0),
        ]);
    }
}
