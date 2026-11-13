<?php

declare(strict_types = 1);

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

it('captures old and new recipients before mutable models are synchronized', function (bool $commit): void {
    $first  = User::factory()->create();
    $second = User::factory()->create();
    $third  = User::factory()->create();
    $note   = $first->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => []]);
    $before = Cache::getStore()->all();
    DB::beginTransaction();
    $note->update(['notifiable_id' => $second->id]);
    $note->update(['notifiable_id' => $third->id]);

    expect(Cache::getStore()->all())->toBe($before);

    if ($commit) {
        DB::commit();
        $keys = array_filter(array_keys(Cache::getStore()->all()), fn (string $key): bool => str_starts_with($key, 'notifications:unviewed:'));
        expect($keys)->toHaveCount(3);

        foreach ($before as $key => $generation) {
            expect(Cache::get($key))->not->toBe($generation);
        }
    } else {
        DB::rollBack();
        expect(Cache::getStore()->all())->toBe($before);
        expect($note->fresh()->notifiable_id)->toBe($first->id);
    }
})->with([true, false]);

it('invalidates counts for soft delete restore and force delete through model events', function (): void {
    $user       = User::factory()->create();
    $note       = $user->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => []]);
    $key        = array_values(array_filter(array_keys(Cache::getStore()->all()), fn (string $key): bool => str_starts_with($key, 'notifications:unviewed:')))[0];
    $generation = Cache::get($key);
    $note->delete();
    expect(Cache::get($key))->not->toBe($generation);
    $generation = Cache::get($key);
    $note->restore();
    expect(Cache::get($key))->not->toBe($generation);
    $generation = Cache::get($key);
    $note->forceDelete();
    expect(Cache::get($key))->not->toBe($generation);
});
