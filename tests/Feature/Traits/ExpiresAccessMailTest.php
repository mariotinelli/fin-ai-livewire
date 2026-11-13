<?php

declare(strict_types = 1);

use App\Models\User;
use App\Notifications\NewPasswordNotification;
use App\Notifications\NewUserNotification;
use App\Notifications\ResetPasswordNotification;
use App\Notifications\VerifyEmailNotification;
use App\Support\QueueNames;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\WorkerOptions;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Exceptions;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Queue;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\Transport\TransportInterface;

it('snapshots the configurable queue deadline and caps it by token validity', function (): void {
    $this->freezeTime();
    config(['auth.access_mail_queue_minutes' => 2]);
    $notification = new NewUserNotification('token', 'user@example.com');
    $this->travel(1)->minutes();
    config(['auth.access_mail_queue_minutes' => 120]);
    expect($notification->isExpired())->toBeFalse();
    $this->travel(1)->minutes();
    expect($notification->isExpired())->toBeTrue();
    config(['auth.passwords.users.expire' => 1]);
    $notification = new ResetPasswordNotification('token', 'user@example.com');
    $this->travel(1)->minutes();
    expect($notification->isExpired())->toBeTrue();
});

it('sends valid access mail and quietly skips invalidated or expired mail at the worker', function (string $kind, string $state): void {
    $this->freezeTime();
    config(['auth.access_mail_queue_minutes' => 2, 'queue.connections.database.connection' => config('database.default')]);
    $sent   = 0;
    $failed = 0;
    Event::listen(MessageSent::class, function () use (&$sent): void {
        $sent++;
    });
    Event::listen(JobFailed::class, function () use (&$failed): void {
        $failed++;
    });
    $user  = User::factory()->create(['email_verified_at' => null]);
    $token = Password::createToken($user);

    if ($state === 'expired-token') {
        $this->travel(30)->minutes();
        config(['auth.access_mail_queue_minutes' => 60]);
    }

    $notification = match ($kind) {
        'invitation'   => new NewUserNotification($token, $user->email),
        'reset'        => new ResetPasswordNotification($token, $user->email),
        'password'     => new NewPasswordNotification($token),
        'verification' => new VerifyEmailNotification(),
    };
    DB::transaction(fn () => $user->notify($notification->onConnection('database')));

    match ($state) {
        'expired-queue'    => $this->travel(121)->seconds(),
        'very-late-worker' => $this->travel(2)->days(),
        'expired-token'    => $this->travel(31)->minutes(),
        'replaced-token'   => Password::createToken($user),
        'used-token'       => Password::deleteToken($user),
        'changed-email'    => User::query()->whereKey($user->id)->update(['email' => 'changed@example.com']),
        'deleted'          => $user->delete(),
        'removed'          => $user->forceDelete(),
        'verified'         => $user->markEmailAsVerified(),
        default            => null,
    };

    if ($state === 'expired-queue') {
        config(['auth.access_mail_queue_minutes' => 120]);
    }

    $job = Queue::connection('database')->pop(QueueNames::resolve('low_priority'));
    expect($job)->not->toBeNull();
    app('queue.worker')->setCache(Cache::store())->process('database', $job, new WorkerOptions(maxTries: 1));

    $record = DB::table('email_notifications')->sole();
    expect($failed)->toBe(0);
    expect($record->failed_at)->toBeNull();
    expect($record->last_failure_type)->toBeNull();

    if ($state === 'valid') {
        expect($sent)->toBe(1);
        expect($record->accepted_at)->not->toBeNull();
        expect($record->attempt_count)->toBe(1);
    } else {
        expect($sent)->toBe(0);
        expect($record->skipped_at)->not->toBeNull();
        expect($record->attempt_count)->toBe(0);
        expect($record->accepted_at)->toBeNull();
    }

    $this->assertDatabaseCount('jobs', 0);
})->with(function (): array {
    $cases = [];

    foreach (['invitation', 'reset', 'password', 'verification'] as $kind) {
        foreach (['valid', 'expired-queue', 'very-late-worker', 'changed-email', 'deleted', 'removed'] as $state) {
            $cases[$kind . ' ' . $state] = [$kind, $state];
        }

        if ($kind !== 'verification') {
            foreach (['expired-token', 'replaced-token', 'used-token'] as $state) {
                $cases[$kind . ' ' . $state] = [$kind, $state];
            }
        }
    }

    $cases['verification verified'] = ['verification', 'verified'];

    return $cases;
});

it('discards an expired access mail after a transient failure without a terminal failure alert', function (): void {
    $this->freezeTime();
    Exceptions::fake();
    $transport = Mockery::mock(TransportInterface::class);
    $transport->shouldReceive('send')->once()->andThrow(new TransportException('Temporary failure'));
    Mail::extend('access-failure', fn (): TransportInterface => $transport);
    config([
        'mail.default'                          => 'access-failure',
        'mail.mailers.access-failure'           => ['transport' => 'access-failure'],
        'auth.access_mail_queue_minutes'        => 1,
        'queue.connections.database.connection' => config('database.default'),
    ]);
    $failed = 0;
    Event::listen(JobFailed::class, function () use (&$failed): void {
        $failed++;
    });
    $user  = User::factory()->create();
    $token = Password::createToken($user);
    DB::transaction(fn () => $user->notify(new ResetPasswordNotification($token, $user->email)->onConnection('database')));
    $worker = app('queue.worker')->setCache(Cache::store());
    $queue  = Queue::connection('database');
    $worker->process('database', $queue->pop(QueueNames::resolve('low_priority')), new WorkerOptions(maxTries: 1));
    $this->travel(61)->seconds();
    $worker->process('database', $queue->pop(QueueNames::resolve('low_priority')), new WorkerOptions(maxTries: 1));

    $record = DB::table('email_notifications')->sole();
    expect($record->attempt_count)->toBe(1);
    expect($record->skipped_at)->not->toBeNull();
    expect($record->failed_at)->toBeNull();
    expect($record->accepted_at)->toBeNull();
    expect($failed)->toBe(0);
    $this->assertDatabaseCount('jobs', 0);
});
