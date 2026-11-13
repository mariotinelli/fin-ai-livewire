<?php

declare(strict_types = 1);

namespace App\Providers;

use App\Customs\CustomDispatcher;
use App\Support\Mail\DeliverEmailOnce;
use App\Support\Mail\EmailNotificationTracker;
use App\Support\Mail\ExpiringAccessMail;
use Illuminate\Bus\Dispatcher;
use Illuminate\Container\Container;
use Illuminate\Contracts\Bus\Dispatcher as BusDispatcher;
use Illuminate\Contracts\Bus\QueueingDispatcher;
use Illuminate\Notifications\SendQueuedNotifications;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;
use RuntimeException;

class QueueServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(EmailNotificationTracker::class);

        $this->app->extend(Dispatcher::class, fn (Dispatcher $dispatcher, Container $app): CustomDispatcher => $this->decorateDispatcher($dispatcher, $app));

        $this->app->extend(BusDispatcher::class, fn (mixed $dispatcher, Container $app): CustomDispatcher => $this->decorateDispatcher($dispatcher, $app));

        $this->app->extend(QueueingDispatcher::class, fn (mixed $dispatcher, Container $app): CustomDispatcher => $this->decorateDispatcher($dispatcher, $app));
    }

    public function boot(): void
    {
        $this->configureQueuedMail();
        Event::subscribe(EmailNotificationTracker::class);

        Queue::before(function (JobProcessing $event): void {
            $queueName = (string) $event->job->getQueue();

            Cache::put(
                key: $this->lastProcessedJobCacheKey($event->connectionName, $queueName),
                value: [
                    'connection'  => $event->connectionName,
                    'queue'       => $queueName,
                    'name'        => $event->job->resolveName(),
                    'uuid'        => $event->job->uuid(),
                    'attempts'    => $event->job->attempts(),
                    'reserved_at' => now()->toIso8601String(),
                ],
                ttl: now()->addMinutes(10),
            );
        });
    }

    private function configureQueuedMail(): void
    {
        Queue::createPayloadUsing(function (?string $connection, ?string $queue, array $payload): array {
            $data    = $payload['data'] ?? null;
            $command = is_array($data) ? ($data['command'] ?? null) : null;

            if ($connection === 'sync' || !$command instanceof SendQueuedNotifications || !in_array('mail', $command->channels ?? [], true)) {
                return [];
            }

            $id = $payload['uuid'] ?? null;

            if (!is_string($id)) {
                throw new \InvalidArgumentException('Identificador do job de e-mail inválido.');
            }

            $isAccessMail                         = $command->notification instanceof ExpiringAccessMail;
            $command->middleware                  = ['email-delivery' => new DeliverEmailOnce($id)] + $command->middleware;
            $command->middleware['outgoing-mail'] = new RateLimited('outgoing-mail')->releaseAfter(1);

            return [
                'email_notification' => app(EmailNotificationTracker::class)->prepare($id, $command, $connection, $queue),
                'retryUntil'         => $isAccessMail ? null : ($payload['retryUntil'] ?? now()->addHour()->timestamp),
                'maxTries'           => $isAccessMail ? 0 : $payload['maxTries'],
                'maxExceptions'      => $payload['maxExceptions'] ?? 3,
            ];
        });
    }

    private function decorateDispatcher(mixed $dispatcher, Container $app): CustomDispatcher
    {
        if ($dispatcher instanceof CustomDispatcher) {
            return $dispatcher;
        }

        if (!$dispatcher instanceof Dispatcher) {
            throw new RuntimeException('Queue dispatcher precisa ser uma instância de Illuminate\\Bus\\Dispatcher.');
        }

        return new CustomDispatcher($app, $dispatcher);
    }

    private function lastProcessedJobCacheKey(string $connection, string $queue): string
    {
        return "alerts:queue:last-job:{$connection}:{$queue}";
    }
}
