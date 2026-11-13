<?php

declare(strict_types = 1);

use App\Actions\Users\ResetUserPassword;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

beforeEach(function (): void {
    config(['session.driver' => 'database', 'session.connection' => null]);
});

it('resets credentials and revokes sessions without affecting another user', function (): void {
    $user  = User::factory()->create(['invitation_pending' => true]);
    $other = User::factory()->create();
    $token = Password::createToken($user);
    DB::table('sessions')->insert([
        ['id' => 'old-device', 'user_id' => $user->id, 'payload' => '', 'last_activity' => time()],
        ['id' => 'other-user', 'user_id' => $other->id, 'payload' => '', 'last_activity' => time()],
    ]);
    Event::fake([PasswordReset::class]);

    $status = app(ResetUserPassword::class)->handle(email: $user->email, password: 'NewSecure@123456', token: $token);

    expect($status)->toBe(Password::PASSWORD_RESET);
    expect(Hash::check('NewSecure@123456', $user->fresh()->password))->toBeTrue();
    expect($user->fresh()->remember_token)->not->toBe($user->remember_token);
    expect($user->fresh()->invitation_pending)->toBeFalse();
    expect(Password::tokenExists($user, $token))->toBeFalse();
    expect($other->fresh()->remember_token)->toBe($other->remember_token);
    $this->assertDatabaseMissing('sessions', ['user_id' => $user->id]);
    $this->assertDatabaseHas('sessions', ['id' => 'other-user', 'user_id' => $other->id]);
    Event::assertDispatched(PasswordReset::class, fn (PasswordReset $event): bool => $event->user instanceof User && $event->user->is($user)
        && $event->user->remember_token === $user->fresh()->remember_token);
});

it('rolls back credentials and preserves the recovery token when session deletion fails', function (): void {
    $user       = User::factory()->create(['invitation_pending' => true]);
    $attributes = $user->fresh()->getAttributes();
    $token      = Password::createToken($user);
    DB::table('sessions')->insert(['id' => 'old-device', 'user_id' => $user->id, 'payload' => '', 'last_activity' => time()]);
    config(['session.table' => 'missing_sessions']);
    Event::fake([PasswordReset::class]);

    expect(fn () => app(ResetUserPassword::class)->handle(email: $user->email, password: 'NewSecure@123456', token: $token))
        ->toThrow(QueryException::class);

    expect($user->fresh()->getAttributes())->toBe($attributes);
    expect(Password::tokenExists($user, $token))->toBeTrue();
    $this->assertDatabaseHas('sessions', ['id' => 'old-device', 'user_id' => $user->id]);
    Event::assertNotDispatched(PasswordReset::class);
});

it('restores sessions and credentials when consuming the recovery token fails', function (): void {
    $user       = User::factory()->create(['invitation_pending' => true]);
    $attributes = $user->fresh()->getAttributes();
    $token      = Password::createToken($user);
    DB::table('sessions')->insert(['id' => 'old-device', 'user_id' => $user->id, 'payload' => '', 'last_activity' => time()]);
    Event::fake([PasswordReset::class]);
    DB::listen(function (QueryExecuted $query): void {
        if (str_contains(strtolower($query->sql), 'delete from') && str_contains($query->sql, 'password_reset_tokens')) {
            throw new RuntimeException('Recovery token deletion failure');
        }
    });

    expect(fn () => app(ResetUserPassword::class)->handle(email: $user->email, password: 'NewSecure@123456', token: $token))
        ->toThrow(RuntimeException::class, 'Recovery token deletion failure');

    expect($user->fresh()->getAttributes())->toBe($attributes);
    expect(Password::tokenExists($user, $token))->toBeTrue();
    $this->assertDatabaseHas('sessions', ['id' => 'old-device', 'user_id' => $user->id]);
    Event::assertNotDispatched(PasswordReset::class);
});
