<?php

declare(strict_types = 1);

use App\Actions\Users\CreateInvitedUser;
use App\Enums\TypeUsers;
use App\Livewire\Auth\ResetPassword;
use App\Models\User;
use App\Notifications\NewUserNotification;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Livewire;

use function Pest\Livewire\livewire;

beforeEach(function (): void {
    config(['session.driver' => 'database', 'session.connection' => null]);
    Http::preventStrayRequests();
    Http::fake(['https://api.pwnedpasswords.com/range/*' => Http::response(substr(strtoupper(sha1('LeakedSecure@123')), 5) . ':1')]);
});

it('mounts the reset token and email', function (): void {
    livewire(ResetPassword::class, ['token' => 'reset-token'])
        ->assertSet('token', 'reset-token')
        ->assertSet('email', '');
});

it('validates reset password data', function (): void {
    livewire(ResetPassword::class, ['token' => ''])
        ->call('save')
        ->assertHasErrors([
            'token'    => 'required',
            'email'    => 'required',
            'password' => 'required',
        ]);
});

it('resets passwords for user types allowed in the admin area', function (TypeUsers $type): void {
    $user          = User::factory()->user()->create(['type' => $type]);
    $token         = Password::createToken($user);
    $rememberToken = $user->remember_token;
    DB::table('sessions')->insert([
        ['id' => 'first-device', 'user_id' => $user->id, 'payload' => '', 'last_activity' => time()],
        ['id' => 'second-device', 'user_id' => $user->id, 'payload' => '', 'last_activity' => time()],
    ]);

    livewire(ResetPassword::class, ['token' => $token])
        ->set('email', $user->email)
        ->set('password', 'NewSecure@123456')
        ->set('password_confirmation', 'NewSecure@123456')
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect(route(match ($type) {
            TypeUsers::Customer => 'customer.login', TypeUsers::SupportRemSoft => 'support.login', default => 'admin.login'
        }));

    expect(Hash::check('NewSecure@123456', $user->fresh()->password))->toBeTrue()
        ->and($user->fresh()->remember_token)->not->toBe($rememberToken)
        ->and(Password::tokenExists($user, $token))->toBeFalse();
    $this->assertDatabaseMissing('sessions', ['user_id' => $user->id]);
    $this->assertGuest();
})->with([
    'admin'   => TypeUsers::Admin,
    'user'    => TypeUsers::User,
    'support' => TypeUsers::SupportRemSoft,
]);

it('resets a customer password with a valid token', function (): void {
    $customer = User::factory()->customer()->create();
    $token    = Password::createToken($customer);

    livewire(ResetPassword::class, ['token' => $token])
        ->set('email', $customer->email)
        ->set('password', 'NewSecure@123456')
        ->set('password_confirmation', 'NewSecure@123456')
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect(route('customer.login'));

    expect(Hash::check('NewSecure@123456', $customer->fresh()->password))->toBeTrue();
});

it('rejects invalid passwords without consuming the token or changing credentials', function (string $password, string $confirmation): void {
    $user  = User::factory()->user()->create(['invitation_pending' => true]);
    $token = Password::createToken($user);
    Event::fake([PasswordReset::class]);

    livewire(ResetPassword::class, ['token' => $token])
        ->set('email', $user->email)
        ->set('password', $password)
        ->set('password_confirmation', $confirmation)
        ->call('save')
        ->assertHasErrors('password');

    expect($user->fresh()->invitation_pending)->toBeTrue();
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
    $user  = User::factory()->user()->create(['invitation_pending' => true]);
    $token = 'invalid-token';
    DB::table('sessions')->insert(['id' => 'existing-device', 'user_id' => $user->id, 'payload' => '', 'last_activity' => time()]);
    Event::fake([PasswordReset::class]);

    livewire(ResetPassword::class, ['token' => $token])
        ->set('email', $user->email)
        ->set('password', 'NewSecure@123456')
        ->set('password_confirmation', 'NewSecure@123456')
        ->call('save')
        ->assertHasErrors('email');

    expect($user->fresh()->invitation_pending)->toBeTrue();
    expect($user->fresh()->password)->toBe($user->password)
        ->and($user->fresh()->remember_token)->toBe($user->remember_token);
    $this->assertDatabaseHas('sessions', ['id' => 'existing-device', 'user_id' => $user->id]);
    Event::assertNotDispatched(PasswordReset::class);
    Http::assertNothingSent();
});

it('rejects an expired token without changing credentials', function (): void {
    $user  = User::factory()->user()->create(['invitation_pending' => true]);
    $token = Password::createToken($user);
    DB::table('sessions')->insert(['id' => 'existing-device', 'user_id' => $user->id, 'payload' => '', 'last_activity' => time()]);
    $this->travel(config('auth.passwords.users.expire') + 1)->minutes();

    livewire(ResetPassword::class, ['token' => $token])
        ->set('email', $user->email)
        ->set('password', 'NewSecure@123456')
        ->set('password_confirmation', 'NewSecure@123456')
        ->call('save')
        ->assertHasErrors('email');

    expect($user->fresh()->invitation_pending)->toBeTrue();
    expect($user->fresh()->password)->toBe($user->password)
        ->and($user->fresh()->remember_token)->toBe($user->remember_token);
    $this->assertDatabaseHas('sessions', ['id' => 'existing-device', 'user_id' => $user->id]);
    Http::assertNothingSent();
});

it('consumes an invitation once without changing the identity role or type', function (TypeUsers $type): void {
    Notification::fake();
    $user = app(CreateInvitedUser::class)->handle(
        userData: ['name' => 'Invited User', 'email' => 'invited@example.com', 'type' => $type],
    )['user'];
    $invitation = Notification::sent($user, NewUserNotification::class)->sole();

    $this->get($invitation->toMail($user)->actionUrl)->assertOk()->assertSee('Solicitar novo link');

    livewire(ResetPassword::class, ['token' => $invitation->token])
        ->set('email', $user->email)
        ->set('password', 'FirstAccess@123')
        ->set('password_confirmation', 'FirstAccess@123')
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect(route(match ($type) {
            TypeUsers::Customer => 'customer.login', TypeUsers::SupportRemSoft => 'support.login', default => 'admin.login'
        }));

    $updated = $user->fresh();
    expect($updated->invitation_pending)->toBeFalse();
    expect(Hash::check('FirstAccess@123', $updated->password))->toBeTrue();
    expect($updated->only('id', 'name', 'email', 'type', 'role_id'))->toBe($user->only('id', 'name', 'email', 'type', 'role_id'));
    DB::table('sessions')->insert(['id' => 'new-login', 'user_id' => $user->id, 'payload' => '', 'last_activity' => time()]);

    livewire(ResetPassword::class, ['token' => $invitation->token])
        ->set('email', $user->email)
        ->set('password', 'SecondAttempt@123')
        ->set('password_confirmation', 'SecondAttempt@123')
        ->call('save')
        ->assertHasErrors('email');

    expect($user->fresh()->password)->toBe($updated->password)
        ->and($user->fresh()->remember_token)->toBe($updated->remember_token);
    $this->assertDatabaseHas('sessions', ['id' => 'new-login', 'user_id' => $user->id]);
    $this->assertGuest();
})->with(TypeUsers::cases());

it('does not accept an invitation for a different email', function (): void {
    $owner = User::factory()->user()->create();
    $other = User::factory()->user()->create();
    $token = Password::createToken($owner);

    livewire(ResetPassword::class, ['token' => $token])
        ->set('email', $other->email)
        ->set('password', 'FirstAccess@123')
        ->set('password_confirmation', 'FirstAccess@123')
        ->call('save')
        ->assertHasErrors('email');

    expect($other->fresh()->password)->toBe($other->password);
    expect(Password::tokenExists($owner, $token))->toBeTrue();
});

it('rolls back both credentials and token consumption without firing a reset event', function (): void {
    $user  = User::factory()->user()->create(['invitation_pending' => true]);
    $token = Password::createToken($user);
    Event::fake([PasswordReset::class]);

    expect(fn () => DB::transaction(function () use ($user, $token): void {
        livewire(ResetPassword::class, ['token' => $token])
            ->set('email', $user->email)
            ->set('password', 'FirstAccess@123')
            ->set('password_confirmation', 'FirstAccess@123')
            ->call('save')
            ->assertHasNoErrors();

        Event::assertNotDispatched(PasswordReset::class);

        throw new RuntimeException('Rollback password');
    }))->toThrow(RuntimeException::class, 'Rollback password');

    expect($user->fresh()->invitation_pending)->toBeTrue();
    expect($user->fresh()->password)->toBe($user->password);
    expect($user->fresh()->remember_token)->toBe($user->remember_token);
    expect(Password::tokenExists($user, $token))->toBeTrue();
    Event::assertNotDispatched(PasswordReset::class);
});

it('limits normalized email attempts before password checks and releases them after sixty seconds', function (): void {
    $this->freezeTime();
    app()->setLocale('pt_BR');
    $user       = User::factory()->user()->create(['email' => 'limited@example.com']);
    $attributes = $user->fresh()->getAttributes();
    $token      = Password::createToken($user);
    DB::table('sessions')->insert(['id' => 'existing-device', 'user_id' => $user->id, 'payload' => '', 'last_activity' => time()]);

    foreach (['limited@example.com', 'LIMITED@example.com', ' limited@example.com ', 'Limited@Example.com', ' LIMITED@EXAMPLE.COM '] as $email) {
        $attempt = livewire(ResetPassword::class, ['token' => 'invalid-token'])
            ->set('email', $email)
            ->set('password', 'NewSecure@123456')
            ->set('password_confirmation', 'NewSecure@123456')
            ->call('save')
            ->assertHasErrors('email');

        expect($attempt->errors()->first('email'))->toBe(__(Password::INVALID_TOKEN));
    }

    $component = livewire(ResetPassword::class, ['token' => $token])
        ->set('email', $user->email)
        ->set('password', 'NewSecure@123456')
        ->set('password_confirmation', 'NewSecure@123456')
        ->call('save')
        ->assertHasErrors('email');

    expect($component->errors()->first('email'))->toBe('Muitas tentativas de redefinição de senha. Tente novamente em 60 segundos.');
    expect($user->fresh()->getAttributes())->toBe($attributes);
    $this->assertDatabaseHas('sessions', ['id' => 'existing-device', 'user_id' => $user->id]);
    expect(Password::tokenExists($user, $token))->toBeTrue();
    Http::assertNothingSent();

    $this->travel(59)->seconds();
    $component->call('save')->assertHasErrors('email');
    expect($component->errors()->first('email'))->toBe('Muitas tentativas de redefinição de senha. Tente novamente em 1 segundo.');

    $this->travel(1)->seconds();
    $component->call('save')->assertHasNoErrors()->assertRedirect(route('admin.login'));
    expect(Hash::check('NewSecure@123456', $user->fresh()->password))->toBeTrue();
    Http::assertSentCount(1);
});

it('clears previous failed attempts after a successful reset', function (): void {
    $this->freezeTime();
    $user  = User::factory()->user()->create();
    $token = Password::createToken($user);
    $key   = 'password-reset|' . $user->email . '|127.0.0.1';
    RateLimiter::increment($key, decaySeconds: 60, amount: 4);

    livewire(ResetPassword::class, ['token' => $token])
        ->set('email', $user->email)
        ->set('password', 'NewSecure@123456')
        ->set('password_confirmation', 'NewSecure@123456')
        ->call('save')->assertHasNoErrors();

    expect(RateLimiter::attempts($key))->toBe(0);
    expect(Hash::check('NewSecure@123456', $user->fresh()->password))->toBeTrue();
});

it('isolates reset limits by email and IP', function (string $email, string $ip): void {
    $this->freezeTime();
    $user  = User::factory()->user()->create(['email' => $email]);
    $token = Password::createToken($user);
    RateLimiter::increment('password-reset|limited@example.com|192.0.2.1', decaySeconds: 60, amount: 5);

    Livewire::withHeaders(['REMOTE_ADDR' => $ip])->test(ResetPassword::class, ['token' => $token])
        ->set('email', $user->email)
        ->set('password', 'NewSecure@123456')
        ->set('password_confirmation', 'NewSecure@123456')
        ->call('save')->assertHasNoErrors()->assertRedirect(route('admin.login'));

    expect(Hash::check('NewSecure@123456', $user->fresh()->password))->toBeTrue();
})->with([
    'another email' => ['another@example.com', '192.0.2.1'],
    'another IP'    => ['limited@example.com', '192.0.2.2'],
]);

it('rejects an unknown account before checking the password policy', function (): void {
    $component = livewire(ResetPassword::class, ['token' => 'invalid-token'])
        ->set('email', 'missing@example.com')
        ->set('password', 'LeakedSecure@123')
        ->set('password_confirmation', 'LeakedSecure@123')
        ->call('save')->assertHasErrors('email')->assertHasNoErrors('password');

    expect($component->errors()->first('email'))->toBe(__(Password::INVALID_TOKEN));
    Http::assertNothingSent();
});
