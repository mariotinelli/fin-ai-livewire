<?php

declare(strict_types = 1);

use App\Models\User;
use App\Notifications\NewPasswordNotification;
use App\Notifications\NewUserNotification;
use Illuminate\Notifications\SendQueuedNotifications;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;

it('shares a fixed mail budget and releases excess notifications until the next second', function (): void {
    $this->travelTo(now()->startOfSecond());
    $user          = User::factory()->make();
    $processed     = 0;
    $notifications = [new NewPasswordNotification('reset'), new NewUserNotification('invitation', $user->email)];

    foreach ($notifications as $notification) {
        $job = new SendQueuedNotifications($user, $notification, ['mail'])->withFakeQueueInteractions();
        app(Pipeline::class)->send($job)->through($notification->middleware($user, 'mail'))->then(function () use (&$processed): void {
            $processed++;
        });
    }

    expect($processed)->toBe(1);
    $job->assertReleased(1);
    $this->travel(1)->seconds();
    $job = new SendQueuedNotifications($user, $notifications[1], ['mail'])->withFakeQueueInteractions();
    app(Pipeline::class)->send($job)->through($notifications[1]->middleware($user, 'mail'))->then(function () use (&$processed): void {
        $processed++;
    });
    expect($processed)->toBe(2);
    $job->assertNotReleased();
});

it('does not throttle other notification channels', function (): void {
    expect(new NewPasswordNotification('reset')->middleware(new User(), 'database'))->toBeEmpty();
});

it('expires access mail through validation instead of failing the worker on a deadline', function (): void {
    $this->travelTo(now()->startOfSecond());
    $user = User::factory()->create();
    $job  = new SendQueuedNotifications($user, new NewPasswordNotification('reset'), ['mail']);
    config(['queue.connections.database.connection' => config('database.default')]);
    $id      = app('queue')->connection('database')->push($job);
    $payload = json_decode(DB::table('jobs')->where('id', $id)->value('payload'), true, flags: JSON_THROW_ON_ERROR);

    expect($payload['retryUntil'])->toBeNull();
    expect($payload['maxTries'])->toBe(0);
    expect($payload['maxExceptions'])->toBe(3);
});
