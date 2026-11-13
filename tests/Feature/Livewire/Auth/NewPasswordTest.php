<?php

declare(strict_types = 1);

use App\Livewire\Auth\ResetPassword;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Password;
use Livewire\Livewire;

beforeEach(function (): void {
    config(['session.driver' => 'database', 'session.connection' => null]);
    Http::preventStrayRequests();
    Http::fake(['https://api.pwnedpasswords.com/range/*' => Http::response(substr(strtoupper(sha1('LeakedSecure@123')), 5) . ':1')]);
});

it('removes the legacy password component', function (): void {
    expect(file_exists(app_path('Livewire/Auth/NewPassword.php')))->toBeFalse();
});

it('sets a password with a valid token and requires a new login', function (): void {
    $user          = User::factory()->user()->create();
    $rememberToken = $user->remember_token;
    $token         = Password::createToken($user);
    Event::fake([PasswordReset::class]);

    Livewire::withQueryParams(['email' => $user->email])->test(ResetPassword::class, ['token' => $token])
        ->assertSet('email', $user->email)
        ->assertSet('token', $token)
        ->set('password', 'NewSecure@123456')
        ->set('password_confirmation', 'NewSecure@123456')
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect(route('admin.login'));

    expect(Hash::check('NewSecure@123456', $user->fresh()->password))->toBeTrue()
        ->and($user->fresh()->remember_token)->not->toBe($rememberToken)
        ->and(Password::tokenExists($user, $token))->toBeFalse();
    $this->assertGuest();
    Event::assertDispatched(PasswordReset::class, fn (PasswordReset $event): bool => $event->user->is($user));
    Http::assertSentCount(1);
});

it('rejects invalid passwords without consuming the token or changing credentials', function (string $password, string $confirmation): void {
    $user  = User::factory()->user()->create();
    $token = Password::createToken($user);
    Event::fake([PasswordReset::class]);

    Livewire::withQueryParams(['email' => $user->email])->test(ResetPassword::class, ['token' => $token])
        ->set('email', $user->email)
        ->set('password', $password)
        ->set('password_confirmation', $confirmation)
        ->call('save')
        ->assertHasErrors('password');

    expect($user->fresh()->password)->toBe($user->password)
        ->and($user->fresh()->remember_token)->toBe($user->remember_token)
        ->and(Password::tokenExists($user, $token))->toBeTrue();
    Event::assertNotDispatched(PasswordReset::class);
    $this->assertGuest();
})->with([
    'weak password'          => ['password', 'password'],
    'compromised password'   => ['LeakedSecure@123', 'LeakedSecure@123'],
    'missing confirmation'   => ['NewSecure@123456', ''],
    'different confirmation' => ['NewSecure@123456', 'OtherSecure@123456'],
]);

it('rejects an invalid reset token without changing credentials', function (): void {
    $user  = User::factory()->user()->create();
    $token = 'invalid-token';
    Event::fake([PasswordReset::class]);

    Livewire::withQueryParams(['email' => $user->email])->test(ResetPassword::class, ['token' => $token])
        ->set('email', $user->email)
        ->set('password', 'NewSecure@123456')
        ->set('password_confirmation', 'NewSecure@123456')
        ->call('save')
        ->assertHasErrors('email');

    expect($user->fresh()->password)->toBe($user->password)
        ->and($user->fresh()->remember_token)->toBe($user->remember_token);
    Event::assertNotDispatched(PasswordReset::class);
});

it('rejects an expired token without changing credentials', function (): void {
    $user  = User::factory()->user()->create();
    $token = Password::createToken($user);
    $this->travel(config('auth.passwords.users.expire') + 1)->minutes();

    Livewire::withQueryParams(['email' => $user->email])->test(ResetPassword::class, ['token' => $token])
        ->set('email', $user->email)
        ->set('password', 'NewSecure@123456')
        ->set('password_confirmation', 'NewSecure@123456')
        ->call('save')
        ->assertHasErrors('email');

    expect($user->fresh()->password)->toBe($user->password);
});

it('cannot reuse a consumed invitation through the consolidated component', function (): void {
    $user  = User::factory()->user()->create();
    $token = Password::createToken($user);

    Livewire::withQueryParams(['email' => $user->email])->test(ResetPassword::class, ['token' => $token])
        ->set('password', 'FirstAccess@123')
        ->set('password_confirmation', 'FirstAccess@123')
        ->call('save')->assertHasNoErrors();

    Livewire::withQueryParams(['email' => $user->email])->test(ResetPassword::class, ['token' => $token])
        ->set('password', 'SecondAttempt@123')
        ->set('password_confirmation', 'SecondAttempt@123')
        ->call('save')->assertHasErrors('email');

    expect(Hash::check('FirstAccess@123', $user->fresh()->password))->toBeTrue();
});

it('restores credentials and the token when an outer transaction rolls back', function (): void {
    $user  = User::factory()->user()->create();
    $token = Password::createToken($user);
    Event::fake([PasswordReset::class]);

    expect(fn () => DB::transaction(function () use ($user, $token): void {
        Livewire::withQueryParams(['email' => $user->email])->test(ResetPassword::class, ['token' => $token])
            ->set('password', 'FirstAccess@123')
            ->set('password_confirmation', 'FirstAccess@123')
            ->call('save')->assertHasNoErrors();

        Event::assertNotDispatched(PasswordReset::class);

        throw new RuntimeException('Rollback legacy password');
    }))->toThrow(RuntimeException::class, 'Rollback legacy password');

    expect($user->fresh()->password)->toBe($user->password);
    expect(Password::tokenExists($user, $token))->toBeTrue();
    Event::assertNotDispatched(PasswordReset::class);
});
