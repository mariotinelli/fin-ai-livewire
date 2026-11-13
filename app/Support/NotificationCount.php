<?php

declare(strict_types = 1);

namespace App\Support;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NotificationCount
{
    private const int CACHE_SECONDS = 30;

    public static function unviewed(User $recipient): int
    {
        $connection = $recipient->getConnectionName() ?? config()->string('database.default');
        $count      = fn (): int => $recipient->notifications()->whereNull('viewed_at')->count();

        if (DB::connection($connection)->transactionLevel() > 0) {
            return $count();
        }

        $key = self::key($recipient->getMorphClass(), (string) $recipient->id, $connection);
        /** @var string $generation */
        $generation = Cache::remember($key . ':generation', self::CACHE_SECONDS * 2, static fn (): string => (string) Str::uuid());

        $countKey    = $key . ':' . $generation;
        $cachedCount = Cache::get($countKey);

        if (is_numeric($cachedCount)) {
            return (int) $cachedCount;
        }

        $currentCount = $count();
        Cache::put($countKey, $currentCount, self::CACHE_SECONDS);

        return $currentCount;
    }

    public static function forgetFor(User $recipient): void
    {
        self::forget($recipient->getMorphClass(), (string) $recipient->id, $recipient->getConnectionName());
    }

    /** A nova geração impede reutilizar uma leitura antiga que termine após a invalidação. */
    public static function forget(string $type, string $id, ?string $connection = null): void
    {
        $connection ??= config()->string('database.default');
        $key = self::key($type, $id, $connection);
        DB::connection($connection)->afterCommit(static function () use ($key): void {
            Cache::put($key . ':generation', (string) Str::uuid(), self::CACHE_SECONDS * 2);
        });
    }

    private static function key(string $type, string $id, string $connection): string
    {
        return 'notifications:unviewed:' . hash('sha256', json_encode([
            config('app.key'), app()->environment(), config('queue.prefix.value'), $connection,
            config('database.connections.' . $connection . '.database'), $type, $id,
        ], JSON_THROW_ON_ERROR));
    }
}
