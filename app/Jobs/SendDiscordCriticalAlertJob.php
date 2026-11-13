<?php

declare(strict_types = 1);

namespace App\Jobs;

use App\Enums\Queues;
use App\Models\SystemErrorAlert;
use App\Support\Alerts\AlertSanitizer;
use App\Support\Alerts\DiscordAlert;
use App\Support\Alerts\DiscordAlertDeliveryException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\Attributes\Backoff;
use Illuminate\Queue\Attributes\Queue;
use Illuminate\Queue\Attributes\Tries;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

#[Queue(Queues::HighPriority)]
#[Tries(3)]
#[Backoff([10, 30, 60])]
class SendDiscordCriticalAlertJob implements ShouldQueue, ShouldBeEncrypted
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * @param array{content: string, embeds: array<int, array<string, mixed>>} $payload
     */
    public function __construct(
        public int $systemErrorAlertId,
        public array $payload,
    ) {
    }

    public function handle(DiscordAlert $discordAlert): void
    {
        try {
            $delivered = $discordAlert->send($this->payload);
        } catch (Throwable $throwable) {
            throw new DiscordAlertDeliveryException(
                message: 'Falha ao enviar alerta crítico para o Discord.',
                previous: $throwable,
            );
        }

        if (!$delivered) {
            return;
        }

        SystemErrorAlert::query()
            ->whereKey($this->systemErrorAlertId)
            ->update(['last_notified_at' => now()]);
    }

    public function failed(?Throwable $throwable): void
    {
        $failure = $throwable;

        while ($failure?->getPrevious() instanceof Throwable) {
            $failure = $failure->getPrevious();
        }

        $webhook    = config('alerts.discord.webhook_url');
        $webhookUrl = is_string($webhook) ? $webhook : '';
        preg_match('~/webhooks/[^/]+/([^/]+)~', (string) parse_url($webhookUrl, PHP_URL_PATH), $matches);
        $sanitizer = new AlertSanitizer([
            'webhook_secret' => $webhookUrl,
            'webhook_token'  => rawurldecode($matches[1] ?? ''),
        ]);

        Log::error('Esgotadas as tentativas de envio do alerta crítico para o Discord.', [
            'system_error_alert_id' => $this->systemErrorAlertId,
            'exception'             => $failure instanceof Throwable ? $failure::class : null,
            'message'               => $sanitizer->text($failure?->getMessage()),
        ]);
    }
}
