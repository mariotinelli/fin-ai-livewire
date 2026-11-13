<?php

declare(strict_types = 1);

use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Carbon;

it('casts the viewed timestamp to a date', function (): void {
    $notification = new Notification();
    $notification->setAttribute('viewed_at', '2026-09-17 12:00:00');

    expect($notification->getAttribute('viewed_at'))
        ->toEqual(Carbon::parse('2026-09-17 12:00:00'));
});

it('keeps soft deleted history while native notification relationships exclude it', function (): void {
    $user = User::factory()->create();
    $note = $user->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => ['title' => 'History']]);
    $note->delete();

    $this->assertSoftDeleted($note);
    expect($user->notifications()->count())->toBe(0)->and($user->unreadNotifications()->count())->toBe(0);
    expect($user->notifications()->withTrashed()->first()->data)->toBe(['title' => 'History']);
});
