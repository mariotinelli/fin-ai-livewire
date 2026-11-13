<?php

declare(strict_types = 1);

use App\Models\User;
use App\Notifications\VerifyEmailNotification as VerifyEmail;
use Illuminate\Notifications\SendQueuedNotifications;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;

it('invalidates verification in the update and notifies only after the outer transaction commits', function (): void {
    Notification::fake();
    $user = User::factory()->create();

    DB::transaction(function () use ($user): void {
        DB::transaction(function () use ($user): void {
            $user->update(['email' => 'changed@example.com']);

            expect($user->fresh()->email)->toBe('changed@example.com')
                ->and($user->fresh()->email_verified_at)->toBeNull();
            Notification::assertNothingSent();
        });

        Notification::assertNothingSent();
    });

    Notification::assertSentTo($user, VerifyEmail::class, fn (VerifyEmail $notification, array $channels, User $notifiable): bool => $channels === ['mail'] && $notifiable->email === 'changed@example.com');
    Notification::assertCount(1);
});

it('restores the email and verification without notifying on rollback', function (): void {
    Notification::fake();
    $user          = User::factory()->create(['email_verified_at' => Carbon::parse('2026-01-01 12:00:00')]);
    $originalEmail = $user->email;

    expect(fn () => DB::transaction(function () use ($user): void {
        $user->update(['email' => 'rolled-back@example.com']);

        throw new RuntimeException('Rollback');
    }))->toThrow(RuntimeException::class, 'Rollback');

    expect($user->fresh()->email)->toBe($originalEmail)
        ->and($user->fresh()->email_verified_at?->toDateTimeString())->toBe('2026-01-01 12:00:00');
    Notification::assertNothingSent();
});

it('discards the notification from a rolled back savepoint when the outer transaction commits', function (): void {
    Notification::fake();
    $user = User::factory()->create();

    DB::transaction(function () use ($user): void {
        $user->update(['email' => 'committed@example.com']);

        expect(fn () => DB::transaction(function () use ($user): void {
            $user->update(['email' => 'discarded@example.com']);

            throw new RuntimeException('Rollback savepoint');
        }))->toThrow(RuntimeException::class, 'Rollback savepoint');

        Notification::assertNothingSent();
    });

    expect($user->fresh()->email)->toBe('committed@example.com');
    Notification::assertSentTo($user, VerifyEmail::class, fn (VerifyEmail $notification, array $channels, User $notifiable): bool => $notifiable->email === 'committed@example.com');
    Notification::assertCount(1);
});

it('preserves verification and does not notify for an unchanged address', function (?string $verifiedAt): void {
    Notification::fake();
    $user = User::factory()->create(['email_verified_at' => $verifiedAt === null ? null : Carbon::parse($verifiedAt)]);

    $user->update(['name' => 'Changed Name', 'email' => $user->email]);

    expect($user->fresh()->email_verified_at?->toDateTimeString())->toBe($verifiedAt);
    Notification::assertNothingSent();
})->with(['verified' => '2026-01-01 12:00:00', 'unverified' => null]);

it('does not send change notifications when a user is created', function (): void {
    Notification::fake();

    User::factory()->create(['email_verified_at' => null]);

    Notification::assertNothingSent();
});

it('preserves each changed address for notification when email changes twice before commit', function (): void {
    Queue::fake([SendQueuedNotifications::class]);
    $user = User::factory()->create();

    DB::transaction(function () use ($user): void {
        $user->update(['email' => 'intermediate@example.com']);
        $user->update(['email' => 'final@example.com']);
    });

    Queue::assertPushed(SendQueuedNotifications::class, fn (SendQueuedNotifications $job): bool => $job->notification instanceof VerifyEmail && $job->notifiables->sole()->email === 'intermediate@example.com');
    Queue::assertPushed(SendQueuedNotifications::class, fn (SendQueuedNotifications $job): bool => $job->notification instanceof VerifyEmail && $job->notifiables->sole()->email === 'final@example.com');
    Queue::assertPushed(SendQueuedNotifications::class, 2);
});

it('keeps the scheduled notification when the new address is verified before commit', function (): void {
    Queue::fake([SendQueuedNotifications::class]);
    $user = User::factory()->create();

    DB::transaction(function () use ($user): void {
        $user->update(['email' => 'verified@example.com']);
        $user->markEmailAsVerified();
    });

    expect($user->fresh()->hasVerifiedEmail())->toBeTrue();
    Queue::assertPushed(SendQueuedNotifications::class, fn (SendQueuedNotifications $job): bool => $job->notification instanceof VerifyEmail);
});

it('keeps the captured recipient when the user is removed before commit', function (): void {
    Queue::fake([SendQueuedNotifications::class]);
    $user = User::factory()->create();

    DB::transaction(function () use ($user): void {
        $user->update(['email' => 'deleted@example.com']);
        $user->forceDelete();
    });

    expect($user->fresh())->toBeNull();
    Queue::assertPushed(SendQueuedNotifications::class, fn (SendQueuedNotifications $job): bool => $job->notification instanceof VerifyEmail && $job->notifiables->sole()->email === 'deleted@example.com');
});
