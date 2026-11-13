<?php

declare(strict_types = 1);

namespace App\Support\Mail;

use Illuminate\Notifications\Events\NotificationSkipped;
use Illuminate\Notifications\SendQueuedNotifications;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Throwable;

class DeliverEmailOnce extends WithoutOverlapping
{
    public function __construct(private readonly string $id)
    {
        parent::__construct('outgoing-mail:' . $id, releaseAfter: 1, expiresAfter: 120);
        $this->shared();
    }

    /**
     * @param SendQueuedNotifications $job
     * @param callable $next
     */
    public function handle(mixed $job, mixed $next): void
    {
        parent::handle($job, function (SendQueuedNotifications $command) use ($next): void {
            $record = DB::table('email_notifications')->where('id', $this->id)->first();

            if ($record === null) {
                throw new RuntimeException('Registro de envio de e-mail ausente.');
            }

            if ($record->completed_at !== null) {
                return;
            }

            if ($record->processing_started_at !== null) {
                DB::table('email_notifications')->where('id', $this->id)->whereNull('completed_at')
                    ->update(['uncertain_at' => now(), 'completed_at' => now(), 'updated_at' => now()]);

                return;
            }

            if ($command->notification instanceof ExpiringAccessMail && $command->notification->isExpired()) {
                Event::dispatch(new NotificationSkipped($command->notifiables->sole(), $command->notification, 'mail'));

                return;
            }

            if ($record->attempt_count >= 3) {
                $command->fail(new RuntimeException('Limite de tentativas de envio atingido.'));

                return;
            }

            DB::table('email_notifications')->where('id', $this->id)->update(['processing_started_at' => now(), 'updated_at' => now()]);
            $tracker = app(EmailNotificationTracker::class);

            try {
                $next($command);
            } catch (Throwable $throwable) {
                if ($tracker->transportAccepted()) {
                    report($throwable);

                    return;
                }

                if (!$tracker->transportAttempted()) {
                    throw $throwable;
                }

                $storedAttempts = DB::table('email_notifications')->where('id', $this->id)->value('attempt_count');
                $attempts       = is_numeric($storedAttempts) ? (int) $storedAttempts : 0;
                Log::warning('Falha em tentativa de envio de e-mail.', [
                    'email_notification_id' => $this->id, 'attempts' => $attempts, 'exception' => get_debug_type($throwable),
                ]);

                if ($attempts >= 3) {
                    $command->fail($throwable);
                } else {
                    $value   = $command->job?->payload()['backoff'] ?? '10,30,60';
                    $backoff = explode(',', is_string($value) || is_int($value) ? (string) $value : '10,30,60');
                    $command->release((int) ($backoff[$attempts - 1] ?? end($backoff)));
                }
            } finally {
                if (!$tracker->transportAttempted() || $command->job?->isReleased()) {
                    DB::table('email_notifications')->where('id', $this->id)->whereNull('completed_at')
                        ->update(['processing_started_at' => null, 'updated_at' => now()]);
                }
            }
        });
    }
}
