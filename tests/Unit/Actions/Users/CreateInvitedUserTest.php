<?php

declare(strict_types = 1);

use App\Actions\Users\CreateInvitedUser;
use App\Enums\TypeUsers;
use App\Models\Role;
use App\Models\User;
use App\Notifications\NewUserNotification;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

it('creates the intended common user before sending its invitation', function (): void {
    Notification::fake();
    Http::preventStrayRequests();
    $role = Role::factory()->create();

    $result = app(CreateInvitedUser::class)->handle(
        userData: ['name' => 'Invited User', 'email' => 'invited@example.com', 'type' => TypeUsers::User, 'role_id' => $role->id],
    );

    $user = User::query()->where('email', 'invited@example.com')->sole();
    expect($user->type)->toBe(TypeUsers::User);
    expect($user->role_id)->toBe($role->id);
    expect($user->email_verified_at)->toBeNull();
    expect($user->invitation_pending)->toBeTrue();
    expect($result['status'])->toBe(Password::RESET_LINK_SENT);
    expect($result['user']->is($user))->toBeTrue();

    Notification::assertSentTo($user, NewUserNotification::class, fn (NewUserNotification $notification): bool => Password::tokenExists($user, $notification->token));
    Http::assertNothingSent();
});

it('ignores password and invitation overrides inside user data', function (): void {
    Notification::fake();
    $result = app(CreateInvitedUser::class)->handle(
        userData: ['name' => 'Invited User', 'email' => 'invited@example.com', 'type' => TypeUsers::User, 'password' => 'Secret@123', 'invitation' => false, 'invitation_pending' => false],
    );

    expect(Hash::check('Secret@123', $result['user']->password))->toBeFalse();
    expect($result['user']->fresh()->invitation_pending)->toBeTrue();
    Notification::assertSentTo($result['user'], NewUserNotification::class);
});

it('rolls back the account and token without sending when its outer transaction fails', function (): void {
    Notification::fake();

    expect(fn () => DB::transaction(function (): void {
        app(CreateInvitedUser::class)->handle(
            userData: ['name' => 'Invited User', 'email' => 'rollback@example.com', 'type' => TypeUsers::User],
        );
        Notification::assertNothingSent();

        throw new RuntimeException('Rollback account');
    }))->toThrow(RuntimeException::class, 'Rollback account');

    $this->assertDatabaseMissing('users', ['email' => 'rollback@example.com']);
    $this->assertDatabaseMissing('password_reset_tokens', ['email' => 'rollback@example.com']);
    Notification::assertNothingSent();
});

it('rolls back the new user when creating the invitation token fails', function (): void {
    Notification::fake();
    DB::listen(function (QueryExecuted $query): void {
        if (str_contains(strtolower($query->sql), 'insert into') && str_contains($query->sql, 'password_reset_tokens')) {
            throw new RuntimeException('Invitation token failure');
        }
    });

    expect(fn () => app(CreateInvitedUser::class)->handle(
        userData: ['name' => 'Invited User', 'email' => 'failed-invitation@example.com', 'type' => TypeUsers::User],
    ))->toThrow(RuntimeException::class, 'Invitation token failure');

    $this->assertDatabaseMissing('users', ['email' => 'failed-invitation@example.com']);
    $this->assertDatabaseMissing('password_reset_tokens', ['email' => 'failed-invitation@example.com']);
    Notification::assertNothingSent();
});

it('creates an invited account without exposing its unusable random password', function (): void {
    Notification::fake();
    Http::preventStrayRequests();
    Str::createRandomStringsUsing(fn (int $length): string => str_repeat('Z', $length));

    try {
        $result = app(CreateInvitedUser::class)->handle(
            userData: ['name' => 'Invited User', 'email' => 'invited@example.com', 'type' => TypeUsers::User],
        );
        $user = $result['user'];

        expect(Hash::check(str_repeat('Z', 64), $user->password))->toBeTrue();
        expect($user->toJson())->not->toContain(str_repeat('Z', 64));
        expect($user->toArray())->not->toHaveKey('password');
        Notification::assertSentTo($user, NewUserNotification::class);
        Http::assertNothingSent();
    } finally {
        Str::createRandomStringsNormally();
    }
});
