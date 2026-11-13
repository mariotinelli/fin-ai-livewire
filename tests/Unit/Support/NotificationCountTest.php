<?php

declare(strict_types = 1);

use App\Actions\Notifications\MarkNotificationsRead;
use App\Actions\Notifications\MarkNotificationsViewed;
use App\Models\User;
use App\Support\NotificationCount;
use Illuminate\Database\Connection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/** Exercita o caminho sem transação ignorando apenas o wrapper do teste; as consultas do model continuam reais. */
function notificationCountAutocommit(Closure $callback): mixed
{
    $manager    = DB::getFacadeRoot();
    $connection = Mockery::mock(Connection::class);
    $connection->shouldReceive('transactionLevel')->andReturn(0);
    $connection->shouldReceive('afterCommit')->andReturnUsing(fn (callable $callback): mixed => $callback());
    DB::partialMock()->shouldReceive('connection')->with((string) config('database.default'))->andReturn($connection);

    try {
        return $callback();
    } finally {
        DB::swap($manager);
    }
}

it('caches unviewed active counts separately by recipient and avoids repeated queries', function (): void {
    $first  = User::factory()->create();
    $second = User::factory()->create();
    $first->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => []]);

    foreach (range(1, 2) as $number) {
        $second->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => []]);
    }

    $first->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => [], 'viewed_at' => now()]);
    $first->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => [], 'deleted_at' => now()]);
    $db = DB::connection();
    $db->enableQueryLog();
    $db->flushQueryLog();
    notificationCountAutocommit(function () use ($first, $second): void {
        expect(NotificationCount::unviewed($first))->toBe(1);
        expect(NotificationCount::unviewed($second))->toBe(2);
        expect(NotificationCount::unviewed($first))->toBe(1);
        expect(NotificationCount::unviewed($second))->toBe(2);
    });
    $queries = collect($db->getQueryLog())->filter(fn (array $query): bool => str_contains($query['query'], 'notifications'));
    $db->disableQueryLog();
    expect($queries)->toHaveCount(2);
});

it('normalizes counts returned as numeric strings by Redis cache stores', function (): void {
    $user = User::factory()->create();
    $user->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => []]);

    notificationCountAutocommit(function () use ($user): void {
        expect(NotificationCount::unviewed($user))->toBe(1);
        $keys = array_filter(array_keys(Cache::getStore()->all()), fn (string $key): bool => str_starts_with($key, 'notifications:unviewed:') && !str_ends_with($key, ':generation'));
        Cache::put(array_values($keys)[0], '1', 30);

        expect(NotificationCount::unviewed($user))->toBe(1);
    });
});

it('uses current transactional state without publishing it and invalidates only on commit', function (bool $commit): void {
    $user = User::factory()->create();
    $note = $user->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => []]);
    notificationCountAutocommit(fn (): int => NotificationCount::unviewed($user));
    $cached = Cache::getStore()->all();
    DB::beginTransaction();
    app(MarkNotificationsViewed::class)->handle($user, [$note->id]);
    expect(NotificationCount::unviewed($user))->toBe(0);
    expect(Cache::getStore()->all())->toBe($cached);

    if ($commit) {
        DB::commit();
    } else {
        DB::rollBack();
    }

    expect(notificationCountAutocommit(fn (): int => NotificationCount::unviewed($user)))->toBe($commit ? 0 : 1);
    expect($note->fresh()->read_at)->toBeNull();
})->with([true, false]);

it('does not reuse an old count written after invalidation', function (): void {
    $user = User::factory()->create();
    $user->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => []]);
    notificationCountAutocommit(fn (): int => NotificationCount::unviewed($user));
    $dataKeys = array_filter(array_keys(Cache::getStore()->all()), fn (string $key): bool => str_starts_with($key, 'notifications:unviewed:') && !str_ends_with($key, ':generation'));
    $user->notifications()->update(['viewed_at' => now()]);
    NotificationCount::forgetFor($user);
    Cache::put(array_values($dataKeys)[0], 99, 30);

    expect(notificationCountAutocommit(fn (): int => NotificationCount::unviewed($user)))->toBe(0);
});

it('invalidates mass reading and expires the cached count', function (): void {
    $user = User::factory()->create();
    $user->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => []]);
    notificationCountAutocommit(fn (): int => NotificationCount::unviewed($user));
    app(MarkNotificationsRead::class)->handle($user);
    expect(notificationCountAutocommit(fn (): int => NotificationCount::unviewed($user)))->toBe(0);
    $user->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => []]);
    expect(notificationCountAutocommit(fn (): int => NotificationCount::unviewed($user)))->toBe(1);
    $user->notifications()->update(['viewed_at' => now()]);
    $this->travel(31)->seconds();
    expect(notificationCountAutocommit(fn (): int => NotificationCount::unviewed($user)))->toBe(0);
});

it('isolates cache namespaces between environments', function (): void {
    $user = User::factory()->create();
    $user->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => []]);
    notificationCountAutocommit(fn (): int => NotificationCount::unviewed($user));
    $original = app()->environment();
    $user->notifications()->update(['viewed_at' => now()]);
    app()->instance('env', 'different-environment');

    try {
        expect(notificationCountAutocommit(fn (): int => NotificationCount::unviewed($user)))->toBe(0);
    } finally {
        app()->instance('env', $original);
    }
});
