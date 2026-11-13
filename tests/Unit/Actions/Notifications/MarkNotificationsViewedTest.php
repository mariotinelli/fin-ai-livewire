<?php

declare(strict_types = 1);

use App\Actions\Notifications\MarkNotificationsViewed;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

it('marks a batch viewed without reading and preserves first view timestamps', function (): void {
    $this->travelTo(now()->startOfSecond());
    $user   = User::factory()->create();
    $first  = $user->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => []]);
    $second = $user->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => [], 'viewed_at' => now()->subDay()]);

    app(MarkNotificationsViewed::class)->handle($user, [$first->id, $second->id]);

    expect($first->fresh()->viewed_at)->toEqual(now())->and($first->fresh()->read_at)->toBeNull();
    expect($second->fresh()->viewed_at)->toEqual(now()->subDay())->and($second->fresh()->read_at)->toBeNull();
});

it('rejects a mixed recipient batch atomically', function (): void {
    $owner   = User::factory()->create();
    $other   = User::factory()->create();
    $own     = $owner->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => []]);
    $foreign = $other->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => []]);

    expect(fn () => app(MarkNotificationsViewed::class)->handle($owner, [$own->id, $foreign->id]))->toThrow(ValidationException::class);
    expect($own->fresh()->viewed_at)->toBeNull()->and($foreign->fresh()->viewed_at)->toBeNull();
});

it('rolls view updates back with the surrounding transaction', function (): void {
    $user         = User::factory()->create();
    $notification = $user->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => []]);
    DB::beginTransaction();
    app(MarkNotificationsViewed::class)->handle($user, [$notification->id]);
    DB::rollBack();

    expect($notification->fresh()->viewed_at)->toBeNull();
});
