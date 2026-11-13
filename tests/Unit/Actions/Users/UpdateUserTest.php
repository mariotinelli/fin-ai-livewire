<?php

declare(strict_types = 1);

use App\Actions\Users\UpdateUser;
use App\Enums\TypeUsers;
use App\Models\Role;
use App\Models\User;
use App\Notifications\VerifyEmailNotification as VerifyEmail;
use Illuminate\Database\QueryException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

it('does not coerce a malformed administrator type into a privilege change', function (): void {
    $user = User::factory()->user()->create(['name' => 'Original']);

    expect(fn () => app(UpdateUser::class)->handle(
        user: $user,
        userData: ['name' => 'Changed', 'email' => $user->email, 'type' => '1invalid'],
    ))->toThrow(ValueError::class);

    expect($user->fresh()->type)->toBe(TypeUsers::User);
    expect($user->fresh()->name)->toBe('Original');
});
use Illuminate\Support\Facades\Password;

use function Pest\Laravel\assertDatabaseHas;

it('updates user fields with valid payload', function (): void {
    Notification::fake();
    $originalRole = Role::factory()->create();
    $targetRole   = Role::factory()->create();

    $user = User::factory()->user()->create([
        'name'    => 'Before',
        'email'   => 'before.user.task@example.com',
        'role_id' => $originalRole->id,
    ]);

    app(UpdateUser::class)->handle(
        user: $user,
        userData: [
            'name'    => 'After',
            'email'   => 'after.user.task@example.com',
            'type'    => TypeUsers::User,
            'role_id' => $targetRole->id,
        ],
    );

    assertDatabaseHas('users', [
        'id'                => $user->id,
        'name'              => 'After',
        'email'             => 'after.user.task@example.com',
        'type'              => TypeUsers::User->value,
        'role_id'           => $targetRole->id,
        'email_verified_at' => null,
    ]);

    Notification::assertSentTo($user, VerifyEmail::class, fn (VerifyEmail $notification, array $channels, User $notifiable): bool => $channels === ['mail'] && $notifiable->routeNotificationFor('mail', $notification) === 'after.user.task@example.com');
});

it('accepts a backed user type value when updating a regular user', function (): void {
    $user = User::factory()->user()->create();

    app(UpdateUser::class)->handle(
        user: $user,
        userData: ['name' => 'Scalar Updated', 'email' => $user->email, 'type' => TypeUsers::User->value],
    );

    expect($user->refresh()->name)->toBe('Scalar Updated');
});

it('preserves the current role when role_id is omitted', function (): void {
    $role = Role::factory()->create();
    $user = User::factory()->user()->create(['role_id' => $role->id]);

    app(UpdateUser::class)->handle(
        user: $user,
        userData: [
            'name'  => 'Updated without role',
            'email' => $user->email,
            'type'  => TypeUsers::User,
        ],
    );

    assertDatabaseHas('users', [
        'id'      => $user->id,
        'name'    => 'Updated without role',
        'role_id' => $role->id,
    ]);
});

it('removes the current role when role_id is explicitly null', function (): void {
    $role = Role::factory()->create();
    $user = User::factory()->user()->create(['role_id' => $role->id]);

    app(UpdateUser::class)->handle(
        user: $user,
        userData: [
            'name'    => 'Updated without role',
            'email'   => $user->email,
            'type'    => TypeUsers::User,
            'role_id' => null,
        ],
    );

    assertDatabaseHas('users', [
        'id'      => $user->id,
        'name'    => 'Updated without role',
        'role_id' => null,
    ]);
});

it('preserves verification without notifying when email is unchanged', function (?string $verifiedAt): void {
    Notification::fake();
    $user = User::factory()->user()->create(['email_verified_at' => $verifiedAt === null ? null : Carbon::parse($verifiedAt)]);

    app(UpdateUser::class)->handle(
        user: $user,
        userData: ['name' => 'Updated Name', 'email' => $user->email, 'type' => TypeUsers::User],
    );

    expect($user->fresh()->email_verified_at?->toDateTimeString())->toBe($verifiedAt);
    Notification::assertNothingSent();
})->with(['verified' => '2026-01-01 12:00:00', 'unverified' => null]);

it('requests verification when an unverified user changes email', function (): void {
    Notification::fake();
    $user = User::factory()->user()->create(['email_verified_at' => null]);

    app(UpdateUser::class)->handle(
        user: $user,
        userData: ['name' => $user->name, 'email' => 'new.unverified@example.com', 'type' => TypeUsers::User],
    );

    expect($user->fresh()->email)->toBe('new.unverified@example.com')
        ->and($user->fresh()->email_verified_at)->toBeNull();
    Notification::assertSentTo($user, VerifyEmail::class);
});

it('invalidates only the old invitation when a pending user changes address', function (): void {
    Notification::fake();
    $user       = User::factory()->user()->create(['email' => 'old.invitation@example.com', 'invitation_pending' => true]);
    $oldToken   = Password::createToken($user);
    $other      = User::factory()->user()->create(['invitation_pending' => true]);
    $otherToken = Password::createToken($other);

    $updated = app(UpdateUser::class)->handle(
        user: $user,
        userData: ['name' => $user->name, 'email' => 'new.invitation@example.com', 'type' => $user->type],
    );

    expect($updated->email)->toBe('new.invitation@example.com')
        ->and($updated->invitation_pending)->toBeTrue();
    $this->assertDatabaseMissing('password_reset_tokens', ['email' => 'old.invitation@example.com']);
    expect(Password::tokenExists($other, $otherToken))->toBeTrue();

    $replacement = User::factory()->user()->create(['email' => 'old.invitation@example.com']);
    expect(Password::tokenExists($replacement, $oldToken))->toBeFalse();
});

it('preserves a usable invitation for equivalent addresses and name edits', function (string $email): void {
    Notification::fake();
    $user       = User::factory()->user()->create(['email' => 'Invited.User@Example.com', 'invitation_pending' => true]);
    $verifiedAt = $user->email_verified_at->toDateTimeString();
    $token      = Password::createToken($user);

    $updated = app(UpdateUser::class)->handle(
        user: $user,
        userData: ['name' => 'Updated Name', 'email' => $email, 'type' => $user->type],
    );

    expect($updated->email)->toBe('Invited.User@Example.com')
        ->and($updated->name)->toBe('Updated Name')
        ->and($updated->email_verified_at->toDateTimeString())->toBe($verifiedAt);
    expect(Password::tokenExists($updated, $token))->toBeTrue();
    Notification::assertNothingSent();
})->with([
    'name only'       => 'Invited.User@Example.com',
    'case only'       => 'invited.user@example.com',
    'outer spaces'    => '  Invited.User@Example.com  ',
    'case and spaces' => '  INVITED.USER@EXAMPLE.COM  ',
]);

it('keeps password reset records for accounts without a pending invitation', function (): void {
    Notification::fake();
    $user  = User::factory()->user()->create(['invitation_pending' => false]);
    $token = Password::createToken($user);

    app(UpdateUser::class)->handle(
        user: $user,
        userData: ['name' => $user->name, 'email' => 'changed.account@example.com', 'type' => $user->type],
    );

    expect(Password::tokenExists($user, $token))->toBeTrue();
    expect($user->fresh()->email)->toBe('changed.account@example.com');
});

it('uses the persisted invitation state when the caller has an outdated model', function (bool $pending): void {
    Notification::fake();
    $user  = User::factory()->user()->create(['invitation_pending' => !$pending]);
    $token = Password::createToken($user);
    User::whereKey($user->id)->update(['invitation_pending' => $pending]);

    app(UpdateUser::class)->handle(
        user: $user,
        userData: ['name' => $user->name, 'email' => 'current.state@example.com', 'type' => $user->type],
    );

    expect(Password::tokenExists($user, $token))->toBe(!$pending);
})->with([true, false]);

it('restores the invitation when persisting the new address fails', function (): void {
    Notification::fake();
    $user       = User::factory()->user()->create(['invitation_pending' => true]);
    $other      = User::factory()->user()->create();
    $token      = Password::createToken($user);
    $attributes = $user->fresh()->getAttributes();

    expect(fn () => app(UpdateUser::class)->handle(
        user: $user,
        userData: ['name' => 'Failed Update', 'email' => $other->email, 'type' => $user->type],
    ))->toThrow(QueryException::class);

    expect($user->fresh()->getAttributes())->toBe($attributes);
    expect(Password::tokenExists($user, $token))->toBeTrue();
    Notification::assertNothingSent();
});

it('rolls back both the address change and invitation invalidation without notifying', function (): void {
    Notification::fake();
    $user       = User::factory()->user()->create(['invitation_pending' => true]);
    $token      = Password::createToken($user);
    $attributes = $user->fresh()->getAttributes();

    expect(fn () => DB::transaction(function () use ($user): void {
        app(UpdateUser::class)->handle(
            user: $user,
            userData: ['name' => 'Rolled Back', 'email' => 'rollback.invitation@example.com', 'type' => $user->type],
        );
        Notification::assertNothingSent();

        throw new RuntimeException('Rollback user update');
    }))->toThrow(RuntimeException::class, 'Rollback user update');

    expect($user->fresh()->getAttributes())->toBe($attributes);
    expect(Password::tokenExists($user, $token))->toBeTrue();
    Notification::assertNothingSent();
});
