<?php

declare(strict_types = 1);

use App\Actions\Notifications\MarkNotificationsRead;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

it('reads one owned notification without changing first viewed or read timestamps', function (): void {
    $this->travelTo(now()->startOfSecond());
    $user         = User::factory()->create();
    $notification = $user->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => [], 'viewed_at' => now()->subDay()]);

    app(MarkNotificationsRead::class)->handle($user, $notification->id);
    app(MarkNotificationsRead::class)->handle($user, $notification->id);

    expect($notification->fresh()->read_at)->toEqual(now())->and($notification->fresh()->viewed_at)->toEqual(now()->subDay());
});

it('marks all owned notifications both viewed and read without touching another recipient', function (): void {
    $user    = User::factory()->create();
    $other   = User::factory()->create();
    $own     = $user->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => []]);
    $foreign = $other->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => []]);

    app(MarkNotificationsRead::class)->handle($user);

    expect($own->fresh()->read_at)->not->toBeNull()->and($own->fresh()->viewed_at)->not->toBeNull();
    expect($foreign->fresh()->read_at)->toBeNull()->and($foreign->fresh()->viewed_at)->toBeNull();
});

it('rejects reading a notification from another recipient', function (): void {
    $user    = User::factory()->create();
    $other   = User::factory()->create();
    $foreign = $other->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => []]);

    expect(fn () => app(MarkNotificationsRead::class)->handle($user, $foreign->id))->toThrow(ModelNotFoundException::class);
    expect($foreign->fresh()->read_at)->toBeNull();
});
