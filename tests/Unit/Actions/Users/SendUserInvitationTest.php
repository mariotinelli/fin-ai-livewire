<?php

declare(strict_types = 1);

use App\Actions\Users\SendUserInvitation;
use App\Exceptions\InvitationPublicationFailed;
use App\Models\User;
use App\Notifications\NewUserNotification;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Queue;

it('sends a valid invitation only after the outer transaction commits', function (): void {
    Notification::fake();
    $user = User::factory()->create();

    DB::transaction(function () use ($user): void {
        $result = app(SendUserInvitation::class)->handle(user: $user);
        expect($result)->toBe(Password::RESET_LINK_SENT);
        Notification::assertNothingSent();
    });

    Notification::assertSentTo($user, NewUserNotification::class, function (NewUserNotification $notification) use ($user): bool {
        $stored = DB::table('password_reset_tokens')->where('email', $user->email)->value('token');
        expect($stored)->not->toBe($notification->token);

        return $notification->email === $user->email && Password::tokenExists($user, $notification->token);
    });
});

it('throttles resends and replaces the previous token after the cooldown', function (): void {
    Notification::fake();
    $user = User::factory()->create();
    app(SendUserInvitation::class)->handle(user: $user);
    $first = Notification::sent($user, NewUserNotification::class)->sole();

    $throttled = app(SendUserInvitation::class)->handle(user: $user);
    expect($throttled)->toBe(Password::RESET_THROTTLED);
    expect(Password::tokenExists($user, $first->token))->toBeTrue();
    Notification::assertCount(1);

    $this->travel(61)->seconds();
    $resent = app(SendUserInvitation::class)->handle(user: $user);
    $second = Notification::sent($user, NewUserNotification::class)->last();

    expect($resent)->toBe(Password::RESET_LINK_SENT);
    expect(Password::tokenExists($user, $first->token))->toBeFalse();
    expect(Password::tokenExists($user, $second->token))->toBeTrue();
    expect($user->fresh()->password)->toBe($user->password);
    Notification::assertCount(2);
});

it('rolls back the token without sending an invitation', function (): void {
    Notification::fake();
    $user = User::factory()->create();

    expect(fn () => DB::transaction(function () use ($user): void {
        app(SendUserInvitation::class)->handle(user: $user);

        throw new RuntimeException('Rollback invitation');
    }))->toThrow(RuntimeException::class, 'Rollback invitation');

    $this->assertDatabaseMissing('password_reset_tokens', ['email' => $user->email]);
    Notification::assertNothingSent();
});

it('requires a persisted recipient', function (): void {
    expect(fn () => app(SendUserInvitation::class)->handle(user: User::factory()->make()))->toThrow(ModelNotFoundException::class);
});

it('does not invite a deleted recipient', function (): void {
    Notification::fake();
    $user = User::factory()->create();
    $user->delete();

    expect(fn () => app(SendUserInvitation::class)->handle(user: $user))->toThrow(ModelNotFoundException::class);
    Notification::assertNothingSent();
});

it('restores the previous token and its cooldown when queue publication fails', function (): void {
    $user   = User::factory()->user()->create(['invitation_pending' => true]);
    $token  = Password::createToken($user);
    $stored = (array) DB::table('password_reset_tokens')->where('email', $user->email)->first();
    $this->travel(61)->seconds();
    Queue::partialMock()->shouldReceive('connection')->andThrow(new RuntimeException('Queue unavailable'));

    expect(fn () => app(SendUserInvitation::class)->handle(user: $user))->toThrow(InvitationPublicationFailed::class, 'Queue unavailable');

    expect(Password::tokenExists($user, $token))->toBeTrue();
    $this->assertDatabaseHas('password_reset_tokens', $stored);
});

it('removes an undeliverable token when there was no previous invitation', function (): void {
    $user = User::factory()->create();
    Queue::partialMock()->shouldReceive('connection')->andThrow(new RuntimeException('Queue unavailable'));

    expect(fn () => app(SendUserInvitation::class)->handle(user: $user))->toThrow(RuntimeException::class, 'Queue unavailable');

    $this->assertDatabaseMissing('password_reset_tokens', ['email' => $user->email]);
});

it('does not overwrite a newer token when an earlier publication fails', function (): void {
    $user     = User::factory()->create();
    $oldToken = Password::createToken($user);
    $this->travel(61)->seconds();
    $newToken = null;
    Queue::partialMock()->shouldReceive('connection')->andReturnUsing(function () use ($user, &$newToken): never {
        $newToken = Password::createToken($user);

        throw new RuntimeException('Earlier publication failed');
    });

    expect(fn () => app(SendUserInvitation::class)->handle(user: $user))->toThrow(RuntimeException::class, 'Earlier publication failed');

    expect(Password::tokenExists($user, $oldToken))->toBeFalse();
    expect(Password::tokenExists($user, $newToken))->toBeTrue();
});
