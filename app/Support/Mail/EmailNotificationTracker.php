<?php

declare(strict_types = 1);

namespace App\Support\Mail;

use App\Jobs\NotifyEmailDeliveryFailureJob;
use App\Models\User;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Query\Builder;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Notifications\Events\NotificationFailed;
use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Notifications\Events\NotificationSkipped;
use Illuminate\Notifications\SendQueuedNotifications;
use Illuminate\Queue\Events\JobExceptionOccurred;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Queue\Events\JobQueued;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Throwable;

class EmailNotificationTracker
{
    private ?string $jobId = null;

    private ?string $notificationId = null;

    private bool $attemptStarted = false;

    private bool $transportAccepted = false;

    /** @return array<class-string, string> */
    public function subscribe(Dispatcher $events): array
    {
        return [
            JobQueued::class            => 'queued',
            JobProcessing::class        => 'processing',
            MessageSending::class       => 'attempt',
            MessageSent::class          => 'accepted',
            NotificationSent::class     => 'sent',
            NotificationSkipped::class  => 'skipped',
            NotificationFailed::class   => 'notificationFailed',
            JobExceptionOccurred::class => 'exception',
            JobFailed::class            => 'failed',
            JobProcessed::class         => 'processed',
        ];
    }

    /** @return array{id: string, notification_id: string} */
    public function prepare(string $id, SendQueuedNotifications $job, ?string $connection, ?string $queue): array
    {
        if ($job->notification instanceof ExpiringAccessMail) {
            $recipient = $job->notifiables->sole();

            if (!$recipient instanceof User) {
                throw new InvalidArgumentException('A mensagem de acesso exige um usuário destinatário.');
            }

            $job->notification->captureRecipient($recipient);
        }

        $job->notification->id ??= (string) Str::uuid();
        DB::table('email_notifications')->insertOrIgnore([
            'id'                => $id, 'notification_id' => $job->notification->id,
            'notification_type' => $job->notification::class,
            'environment'       => app()->environment(), 'connection' => $connection, 'queue' => $queue,
            'requester_id'      => Auth::check() ? User::query()->whereKey(Auth::id())->value('id') : null,
            'created_at'        => now(), 'updated_at' => now(),
        ]);

        return ['id' => $id, 'notification_id' => $job->notification->id];
    }

    public function queued(JobQueued $event): void
    {
        $id = $this->metadata($event->payload())['id'];

        if (is_string($id)) {
            DB::table('email_notifications')->where('id', $id)->whereNull('queued_at')->update(['queued_at' => now(), 'updated_at' => now()]);
        }
    }

    public function processing(JobProcessing $event): void
    {
        $context                 = $this->metadata($event->job->payload());
        $this->jobId             = $context['id'];
        $this->notificationId    = $context['notification_id'];
        $this->attemptStarted    = false;
        $this->transportAccepted = false;
    }

    public function attempt(MessageSending $event): void
    {
        if (!$this->matches($event->data) || $this->attemptStarted) {
            return;
        }

        $this->record()->increment('attempt_count', 1, ['updated_at' => now()]);
        $this->attemptStarted = true;
    }

    public function accepted(MessageSent $event): void
    {
        if ($this->matches($event->data)) {
            $this->transportAccepted = true;
            $this->record()->whereNull('accepted_at')->update(['accepted_at' => now(), 'completed_at' => now(), 'processing_started_at' => null, 'uncertain_at' => null, 'failed_at' => null, 'updated_at' => now()]);
        }
    }

    public function sent(NotificationSent $event): void
    {
        if ($event->channel === 'mail' && $event->notification->id === $this->notificationId && $event->response === null) {
            $this->skip();
        }
    }

    public function skipped(NotificationSkipped $event): void
    {
        if ($event->channel === 'mail' && $event->notification->id === $this->notificationId) {
            $this->skip();
        }
    }

    public function notificationFailed(NotificationFailed $event): void
    {
        if ($event->channel === 'mail' && $event->notification->id === $this->notificationId && !$this->transportAccepted && ($event->data['exception'] ?? null) instanceof Throwable) {
            $this->failure($event->data['exception']);
        }
    }

    public function exception(JobExceptionOccurred $event): void
    {
        $this->failure($event->exception);
        $this->reset();
    }

    public function failed(JobFailed $event): void
    {
        $id = $this->metadata($event->job->payload())['id'];

        if (!is_string($id)) {
            return;
        }

        $record = DB::table('email_notifications')->where('id', $id)->first();

        if ($record === null || $record->completed_at !== null) {
            return;
        }

        $result  = $record->processing_started_at === null ? 'failed_at' : 'uncertain_at';
        $changed = DB::table('email_notifications')->where('id', $id)->whereNull('completed_at')
            ->update([$result => now(), 'completed_at' => now(), 'last_failure_type' => substr(get_debug_type($event->exception), 0, 191), 'updated_at' => now()]);

        if ($changed === 1 && $result === 'failed_at') {
            $connection = $event->connectionName;
            DB::afterCommit(function () use ($id, $connection): void {
                try {
                    NotifyEmailDeliveryFailureJob::dispatch($id)->onConnection($connection);
                } catch (Throwable $throwable) {
                    Log::error('Não foi possível publicar o alerta de falha de e-mail.', [
                        'email_notification_id' => $id, 'exception' => get_debug_type($throwable),
                    ]);
                }
            });
        }
    }

    public function processed(JobProcessed $event): void
    {
        if ($event->job->isDeleted() && !$event->job->isReleased() && !$this->attemptStarted) {
            $this->skip();
        }

        $this->reset();
    }

    public function transportAttempted(): bool
    {
        return $this->attemptStarted;
    }

    public function transportAccepted(): bool
    {
        return $this->transportAccepted;
    }

    private function skip(): void
    {
        if ($this->jobId === null) {
            return;
        }

        if ($this->attemptStarted) {
            $this->record()->where('attempt_count', '>', 0)->decrement('attempt_count');
            $this->attemptStarted = false;
        }

        $this->record()->whereNull('completed_at')->update(['skipped_at' => now(), 'completed_at' => now(), 'processing_started_at' => null, 'updated_at' => now()]);
    }

    private function failure(Throwable $exception): void
    {
        if ($this->jobId !== null && !$this->transportAccepted) {
            $this->record()->whereNull('completed_at')->update(['processing_started_at' => null, 'last_failed_at' => now(), 'last_failure_type' => substr(get_debug_type($exception), 0, 191), 'updated_at' => now()]);
        }
    }

    /** @param array<array-key, mixed> $data */
    private function matches(array $data): bool
    {
        $id = $data['__laravel_notification_id'] ?? null;

        return $this->jobId !== null
            && ($id === $this->notificationId || ($id === null && isset($data['__laravel_mailable'])));
    }

    private function record(): Builder
    {
        return DB::table('email_notifications')->where('id', $this->jobId);
    }

    private function reset(): void
    {
        $this->jobId             = null;
        $this->notificationId    = null;
        $this->attemptStarted    = false;
        $this->transportAccepted = false;
    }

    /**
     * @param array<array-key, mixed> $payload
     * @return array{id: string|null, notification_id: string|null}
     */
    private function metadata(array $payload): array
    {
        $context = $payload['email_notification'] ?? null;

        if (!is_array($context)) {
            return ['id' => null, 'notification_id' => null];
        }

        return [
            'id'              => is_string($context['id'] ?? null) ? $context['id'] : null,
            'notification_id' => is_string($context['notification_id'] ?? null) ? $context['notification_id'] : null,
        ];
    }
}
