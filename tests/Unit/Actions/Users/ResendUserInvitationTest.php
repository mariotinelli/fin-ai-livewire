<?php

declare(strict_types = 1);

use App\Actions\Users\ResendUserInvitation;
use App\Enums\TypeUsers;
use App\Models\User;
use App\Notifications\NewUserNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

it('replaces an eligible invitation after the cooldown without changing the account', function (): void {
    Notification::fake();
    $user       = User::factory()->user()->create(['invitation_pending' => true]);
    $oldToken   = Password::createToken($user);
    $attributes = $user->fresh()->getAttributes();
    $this->travel(61)->seconds();

    $status = app(ResendUserInvitation::class)->handle(user: $user);

    expect($status)->toBe(Password::RESET_LINK_SENT);
    expect(Password::tokenExists($user, $oldToken))->toBeFalse();
    expect($user->fresh()->getAttributes())->toBe($attributes);
    Notification::assertSentTo($user, NewUserNotification::class, fn (NewUserNotification $notification): bool => Password::tokenExists($user, $notification->token));
});

it('preserves the existing invitation during the cooldown', function (): void {
    Notification::fake();
    $user  = User::factory()->user()->create(['invitation_pending' => true]);
    $token = Password::createToken($user);

    expect(app(ResendUserInvitation::class)->handle(user: $user))->toBe(Password::RESET_THROTTLED);
    expect(Password::tokenExists($user, $token))->toBeTrue();
    Notification::assertNothingSent();
});

it('rechecks eligibility from persistence before replacing a token', function (array $changes): void {
    Notification::fake();
    $user  = User::factory()->user()->create(['invitation_pending' => true]);
    $token = Password::createToken($user);
    $this->travel(61)->seconds();
    User::whereKey($user->id)->update($changes);

    expect(fn () => app(ResendUserInvitation::class)->handle(user: $user))->toThrow(ValidationException::class);
    expect(Password::tokenExists($user, $token))->toBeTrue();
    Notification::assertNothingSent();
})->with([
    'inactive'   => [['deleted_at' => '2026-01-01 00:00:00']],
    'accepted'   => [['invitation_pending' => false]],
    'privileged' => [['type' => TypeUsers::Admin]],
]);

it('restores the previous invitation on an outer rollback without publishing a replacement', function (): void {
    Notification::fake();
    $user  = User::factory()->user()->create(['invitation_pending' => true]);
    $token = Password::createToken($user);
    $this->travel(61)->seconds();

    expect(fn () => DB::transaction(function () use ($user): void {
        app(ResendUserInvitation::class)->handle(user: $user);
        Notification::assertNothingSent();

        throw new RuntimeException('Rollback resend');
    }))->toThrow(RuntimeException::class, 'Rollback resend');

    expect(Password::tokenExists($user, $token))->toBeTrue();
    Notification::assertNothingSent();
});
