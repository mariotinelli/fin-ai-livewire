<?php

declare(strict_types = 1);

use App\Actions\Notifications\DeleteNotification;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

it('soft deletes an owned notification and preserves its payload and timestamps on repeated requests', function (): void {
    $this->travelTo(now()->startOfSecond());
    $user   = User::factory()->create();
    $note   = $user->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => ['title' => 'Keep history'], 'read_at' => now()->subDay(), 'viewed_at' => now()->subDays(2)]);
    $read   = $note->read_at;
    $viewed = $note->viewed_at;
    app(DeleteNotification::class)->handle($user, $note->id);
    $deleted = $note->fresh()->deleted_at;
    $this->travel(5)->minutes();
    app(DeleteNotification::class)->handle($user, $note->id);

    $this->assertSoftDeleted($note);
    expect(Notification::withTrashed()->findOrFail($note->id)->data)->toBe(['title' => 'Keep history']);
    expect($note->fresh()->read_at)->toEqual($read)->and($note->fresh()->viewed_at)->toEqual($viewed)->and($note->fresh()->deleted_at)->toEqual($deleted);
    expect($user->notifications()->count())->toBe(0);
});

it('rejects notifications belonging to another recipient', function (): void {
    $user  = User::factory()->create();
    $other = User::factory()->create();
    $note  = $other->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => []]);

    expect(fn () => app(DeleteNotification::class)->handle($user, $note->id))->toThrow(ModelNotFoundException::class);
    expect($note->fresh()->deleted_at)->toBeNull();
});
