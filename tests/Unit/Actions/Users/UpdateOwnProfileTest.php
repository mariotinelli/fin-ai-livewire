<?php

declare(strict_types = 1);

use App\Actions\Users\UpdateOwnProfile;
use App\Enums\TypeUsers;
use App\Models\User;
use App\Notifications\VerifyEmailNotification as VerifyEmail;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

it('persists only the allowed profile fields', function (): void {
    $this->freezeTime();
    Notification::fake();
    $user            = User::factory()->user()->create();
    $other           = User::factory()->user()->create();
    $attributes      = $user->fresh()->getAttributes();
    $otherAttributes = $other->fresh()->getAttributes();

    app(UpdateOwnProfile::class)->handle(user: $user, profileData: [
        'name'              => 'Updated Name',
        'email'             => $user->email,
        'id'                => $other->id,
        'type'              => TypeUsers::Admin,
        'password'          => 'InjectedPass@123',
        'role_id'           => $other->role_id,
        'remember_token'    => 'injected-token',
        'email_verified_at' => null,
        'deleted_at'        => now(),
    ]);

    $expected = array_replace($attributes, ['name' => 'Updated Name']);
    expect($user->fresh()->getAttributes())->toBe($expected);
    expect($other->fresh()->getAttributes())->toBe($otherAttributes);
    Notification::assertNothingSent();
});

it('normalizes a new email and sends one verification after commit', function (): void {
    Notification::fake();
    $user = User::factory()->user()->create();

    DB::transaction(function () use ($user): void {
        $updated = app(UpdateOwnProfile::class)->handle(user: $user, profileData: [
            'name' => 'Updated Name', 'email' => ' NEW@EXAMPLE.COM ',
        ]);

        expect($updated->email)->toBe('new@example.com');
        expect($updated->email_verified_at)->toBeNull();
        Notification::assertNothingSent();
    });

    Notification::assertSentTo($user, VerifyEmail::class, fn (VerifyEmail $notification, array $channels, User $notifiable): bool => $notifiable->email === 'new@example.com');
    Notification::assertCount(1);
});

it('preserves verification when the email differs only in case or surrounding spaces', function (): void {
    Notification::fake();
    $user       = User::factory()->user()->create(['email' => 'Original@Example.com']);
    $verifiedAt = $user->fresh()->email_verified_at->toDateTimeString();

    $updated = app(UpdateOwnProfile::class)->handle(user: $user, profileData: [
        'name' => 'Updated Name', 'email' => ' ORIGINAL@EXAMPLE.COM ',
    ]);

    expect($updated->email)->toBe('Original@Example.com');
    expect($updated->email_verified_at->toDateTimeString())->toBe($verifiedAt);
    Notification::assertNothingSent();
});

it('rejects a deactivated account even when the caller holds an active model', function (): void {
    Notification::fake();
    $user = User::factory()->user()->create();
    User::whereKey($user->id)->delete();
    $attributes = $user->fresh()->getAttributes();

    expect(fn () => app(UpdateOwnProfile::class)->handle(user: $user, profileData: [
        'name' => 'Rejected Name', 'email' => 'rejected@example.com',
    ]))->toThrow(AuthorizationException::class);

    expect($user->fresh()->getAttributes())->toBe($attributes);
    Notification::assertNothingSent();
});

it('rejects an email conflict without partially updating the profile', function (): void {
    Notification::fake();
    $user       = User::factory()->user()->create();
    $other      = User::factory()->user()->create();
    $attributes = $user->fresh()->getAttributes();

    expect(fn () => app(UpdateOwnProfile::class)->handle(user: $user, profileData: [
        'name' => 'Rejected Name', 'email' => $other->email,
    ]))->toThrow(UniqueConstraintViolationException::class);

    expect($user->fresh()->getAttributes())->toBe($attributes);
    Notification::assertNothingSent();
});

it('rolls back profile changes without sending verification', function (): void {
    Notification::fake();
    $user       = User::factory()->user()->create();
    $attributes = $user->fresh()->getAttributes();

    expect(fn () => DB::transaction(function () use ($user): void {
        app(UpdateOwnProfile::class)->handle(user: $user, profileData: [
            'name' => 'Rolled Back Name', 'email' => 'rollback@example.com',
        ]);

        throw new RuntimeException('Rollback own profile');
    }))->toThrow(RuntimeException::class, 'Rollback own profile');

    expect($user->fresh()->getAttributes())->toBe($attributes);
    Notification::assertNothingSent();
});
