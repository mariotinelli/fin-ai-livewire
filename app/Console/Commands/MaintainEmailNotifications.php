<?php

declare(strict_types = 1);

namespace App\Console\Commands;

use App\Jobs\NotifyEmailDeliveryFailureJob;
use Closure;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use stdClass;
use Throwable;

#[Signature('email:maintain-notifications')]
#[Description('Recupera avisos pendentes e aplica a retenção dos registros de e-mail')]
class MaintainEmailNotifications extends Command
{
    private int $failures = 0;

    public function handle(): int
    {
        $this->failures = 0;
        $days           = config()->integer('mail.tracking_retention_days');

        if ($days < 1) {
            $this->error('A retenção dos registros de e-mail deve ser de pelo menos um dia.');

            return self::FAILURE;
        }

        try {
            $result = Cache::lock('email-maintenance:' . app()->environment(), 3600)
                ->get(fn (): int => $this->maintain($days));
        } catch (Throwable $throwable) {
            $this->recordFailure(null, $throwable);

            return self::FAILURE;
        }

        if ($result === false) {
            $this->info('A manutenção de e-mails já está em execução.');

            return self::SUCCESS;
        }

        return is_int($result) ? $result : self::FAILURE;
    }

    private function maintain(int $days): int
    {
        $cutoff         = now()->subMinutes(5);
        $discordEnabled = (bool) config('alerts.discord.enabled');
        $this->process($this->unconfirmed($cutoff), function (stdClass $record) use ($cutoff): void {
            DB::transaction(function () use ($record, $cutoff): void {
                $pending = $this->unconfirmed($cutoff)->where('id', $record->id)->lockForUpdate()->first();

                if ($pending === null) {
                    return;
                }

                $result = $pending->processing_started_at !== null || $pending->attempt_count > 0 ? 'uncertain_at' : 'failed_at';
                $this->records()->where('id', $pending->id)->whereNull('completed_at')->update([
                    $result => now(), 'completed_at' => now(), 'updated_at' => now(), 'last_failure_type' => RuntimeException::class,
                ]);
            });
        });
        $this->process($this->pendingAlerts($discordEnabled), function (stdClass $record): void {
            DB::afterCommit(function () use ($record): void {
                try {
                    $id         = $record->id;
                    $connection = $record->connection ?? 'database';

                    if (!is_string($id) || !is_string($connection)) {
                        throw new RuntimeException('Registro de entrega inválido.');
                    }

                    NotifyEmailDeliveryFailureJob::dispatch($id)->onConnection($connection);
                } catch (Throwable $throwable) {
                    $this->recordFailure(is_string($record->id) ? $record->id : null, $throwable);
                }
            });
        });
        $cutoff = now()->subDays($days);
        $this->process($this->removable($cutoff, $discordEnabled), function (stdClass $record) use ($cutoff, $discordEnabled): void {
            $this->removable($cutoff, $discordEnabled)->where('id', $record->id)->delete();
        });

        $this->info("Manutenção de e-mails concluída. Falhas: {$this->failures}.");

        return $this->failures === 0 ? self::SUCCESS : self::FAILURE;
    }

    private function records(): Builder
    {
        return DB::table('email_notifications')->where('environment', app()->environment())->where('created_at', '<=', now());
    }

    private function unconfirmed(Carbon $cutoff): Builder
    {
        return $this->records()->whereNull('queued_at')->whereNull('completed_at')->where('created_at', '<=', $cutoff)
            ->where(fn (Builder $query): Builder => $query->whereNull('processing_started_at')->orWhere('processing_started_at', '<=', now()->subMinutes(2)));
    }

    private function pendingAlerts(bool $discordEnabled): Builder
    {
        return $this->records()->whereNotNull('failed_at')->whereNull('accepted_at')->whereNull('skipped_at')->whereNull('uncertain_at')
            ->where(function (Builder $query) use ($discordEnabled): void {
                $query->whereNull('notified_at');

                if ($discordEnabled) {
                    $query->orWhereNull('discord_notified_at');
                }
            });
    }

    private function removable(Carbon $cutoff, bool $discordEnabled): Builder
    {
        return $this->records()->where('completed_at', '<', $cutoff)->where('updated_at', '<', $cutoff)
            ->whereNull('processing_started_at')->whereNull('uncertain_at')
            ->where(function (Builder $query) use ($discordEnabled): void {
                $query->whereNotNull('accepted_at')->orWhereNotNull('skipped_at')->orWhere(function (Builder $failed) use ($discordEnabled): void {
                    $failed->whereNotNull('failed_at')->whereNotNull('notified_at');

                    if ($discordEnabled) {
                        $failed->whereNotNull('discord_notified_at');
                    }
                });
            });
    }

    /** @param Closure(stdClass): void $operation */
    private function process(Builder $query, Closure $operation): void
    {
        foreach ($query->lazyById(100) as $record) {
            try {
                $operation($record);
            } catch (Throwable $exception) {
                $this->recordFailure(is_string($record->id) ? $record->id : null, $exception);
            }
        }
    }

    private function recordFailure(?string $id, Throwable $exception): void
    {
        $this->failures++;
        Log::warning('Falha na manutenção de registros de e-mail.', [
            'email_notification_id' => $id, 'exception' => get_debug_type($exception),
        ]);
    }
}
