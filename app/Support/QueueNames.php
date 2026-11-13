<?php

declare(strict_types = 1);

namespace App\Support;

use App\Enums\Queues;
use InvalidArgumentException;

class QueueNames
{
    public static function resolve(string $queue): string
    {
        $prefix          = config('queue.prefix.value');
        $prefixIsMissing = !is_string($prefix) || trim($prefix) === '';

        if ($prefixIsMissing) {
            return $queue;
        }

        $environment = app()->environment();

        if (!preg_match('/\A[a-zA-Z0-9_-]+\z/', $prefix) || !preg_match('/\A[a-zA-Z0-9_-]+\z/', $environment)) {
            throw new InvalidArgumentException('QUEUE_PREFIX e APP_ENV devem conter apenas letras, números, hífens e sublinhados.');
        }

        $namespace = $prefix . '_' . $environment . '_';

        if (str_starts_with($queue, $namespace)) {
            return $queue;
        }

        if (!self::shouldBePrefixed($queue)) {
            return $queue;
        }

        return $namespace . $queue;
    }

    public static function shouldBePrefixed(?string $queue): bool
    {
        return !empty($queue)
            && !in_array($queue, config()->array('queue.prefix.excluded_queues', []), true)
            && (in_array($queue, config()->array('queue.prefix.allowed_queues', ['*']), true)
                || in_array('*', config()->array('queue.prefix.allowed_queues', ['*']), true));
    }

    /** @return list<string> */
    public static function all(): array
    {
        return array_map(fn (Queues $queue): string => self::resolve($queue->value), Queues::cases());
    }
}
