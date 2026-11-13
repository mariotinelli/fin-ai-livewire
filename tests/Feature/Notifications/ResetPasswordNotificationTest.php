<?php

declare(strict_types = 1);

use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use App\Support\QueueNames;
use Illuminate\Mail\Transport\ArrayTransport;
use Illuminate\Notifications\SendQueuedNotifications;

use Illuminate\Queue\WorkerOptions;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Queue;

it('queues the native email with middleware and after commit', function (): void {
    $user  = User::factory()->create(['email_verified_at' => null]);
    $token = Password::createToken($user);
    Bus::fake([SendQueuedNotifications::class]);

    $user->sendPasswordResetNotification($token);

    Bus::assertDispatched(SendQueuedNotifications::class, fn (SendQueuedNotifications $job): bool => $job->notification instanceof ResetPasswordNotification
        && $job->channels === ['mail']
        && count($job->middleware) === 1
        && $job->afterCommit === true
        && $job->shouldBeEncrypted);
});

it('does not deliver a queued link after the account changes', function (): void {
    $user         = User::factory()->create(['email_verified_at' => null]);
    $token        = Password::createToken($user);
    $notification = new ResetPasswordNotification($token, $user->email);
    expect($notification->shouldSend($user, 'mail'))->toBeTrue();
    $user->update(['email' => 'different@example.com']);

    expect($notification->shouldSend($user, 'mail'))->toBeFalse();
});

it('does not deliver a reset token that expired or was replaced', function (): void {
    $this->freezeTime();
    $user         = User::factory()->create();
    $token        = Password::createToken($user);
    $notification = new ResetPasswordNotification($token, $user->email);
    Password::createToken($user);
    expect($notification->shouldSend($user, 'mail'))->toBeFalse();
    $token        = Password::createToken($user);
    $notification = new ResetPasswordNotification($token, $user->email);
    $this->travel(61)->minutes();
    expect($notification->shouldSend($user, 'mail'))->toBeFalse();
});

it('encrypts the actual reset payload and lets the worker restore the original token and recipient', function (): void {
    $user  = User::factory()->create(['email' => 'PRIVATE_RESET_RSP174@example.com']);
    $token = Password::createToken($user);
    config(['queue.connections.database.connection' => config('database.default')]);
    DB::transaction(fn () => $user->notify(new ResetPasswordNotification($token, $user->email)->onConnection('database')));
    $payload = DB::table('jobs')->sole()->payload;
    expect($payload)->not->toContain($user->email, $token);
    $restored = unserialize(Crypt::decrypt(json_decode($payload, true, flags: JSON_THROW_ON_ERROR)['data']['command']));
    expect($restored->notification->token)->toBe($token);
    expect($restored->notification->email)->toBe($user->email);

    $job = Queue::connection('database')->pop(QueueNames::resolve('low_priority'));
    app('queue.worker')->setCache(Cache::store())->process('database', $job, new WorkerOptions(maxTries: 1));

    $transport = Mail::mailer()->getSymfonyTransport();
    expect($transport)->toBeInstanceOf(ArrayTransport::class);
    $message = $transport->messages()->sole()->getOriginalMessage();
    expect($message->getTo()[0]->getAddress())->toBe($user->email);
    expect($message->getHtmlBody())->toContain($token);
    $this->assertDatabaseCount('jobs', 0);
});
