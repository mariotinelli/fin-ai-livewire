<?php

declare(strict_types = 1);

use App\Enums\TypeUsers;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Notifications\Dispatcher;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

use function Pest\Laravel\post;

beforeEach(function (): void {
    Http::preventStrayRequests();
    Http::fake(['https://api.pwnedpasswords.com/range/*' => Http::response(substr(strtoupper(sha1('LeakedSecure@123')), 5) . ':1')]);
});

it('returns the public registration view', function (): void {
    expect(new RegisteredUserController()->create()->name())->toBe('auth.register');
});

it('registers and authenticates a customer through the reusable create user action', function (): void {
    Event::fake([Registered::class]);

    $response = post(route('register'), [
        'name'                  => 'Cliente Exemplo',
        'email'                 => ' Cliente@Example.com ',
        'password'              => 'CustomerSecure@123456',
        'password_confirmation' => 'CustomerSecure@123456',
    ]);

    $customer = User::query()->where('email', 'cliente@example.com')->firstOrFail();

    $response->assertRedirect(route('verification.notice'));

    expect($customer->type)->toBe(TypeUsers::Customer)
        ->and(Hash::check('CustomerSecure@123456', $customer->password))->toBeTrue()
        ->and(auth()->id())->toBe($customer->id);

    Event::assertDispatched(Registered::class, fn (Registered $event): bool => $event->user->is($customer));
});

it('validates public registration data', function (): void {
    post(route('register'), [
        'name'                  => '',
        'email'                 => 'invalid-email',
        'password'              => 'weak',
        'password_confirmation' => 'different',
    ])->assertSessionHasErrors(['name', 'email', 'password']);

    expect(User::query()->count())->toBe(0);
});

it('keeps the new account signed in and recoverable when verification cannot be queued', function (): void {
    $this->mock(Dispatcher::class)->shouldReceive('send')->once()->andThrow(new RuntimeException('Queue unavailable'));
    post(route('register'), [
        'name'     => 'Cliente Exemplo', 'email' => 'cliente@example.com',
        'password' => 'CustomerSecure@123456', 'password_confirmation' => 'CustomerSecure@123456',
    ])->assertRedirect(route('verification.notice'))->assertSessionHas('status', 'verification-link-failed');
    $customer = User::query()->sole();
    $this->assertAuthenticatedAs($customer);
    expect($customer->hasVerifiedEmail())->toBeFalse();
    $this->get(route('verification.notice'))->assertSee('Não foi possível solicitar o envio')->assertSee('Solicitar novo link');
});

it('ignores supplied privileges during public registration', function (int | string $type): void {
    $role = Role::factory()->create();

    post(route('register'), [
        'name'                  => 'Public Customer',
        'email'                 => 'public@example.com',
        'password'              => 'CustomerSecure@123456',
        'password_confirmation' => 'CustomerSecure@123456',
        'type'                  => $type,
        'role_id'               => $role->id,
        'invitation'            => true,
    ])->assertRedirect(route('verification.notice'));

    $user = User::query()->where('email', 'public@example.com')->sole();
    expect($user->type)->toBe(TypeUsers::Customer);
    expect($user->role_id)->toBeNull();
})->with([TypeUsers::Admin->value, TypeUsers::User->value, TypeUsers::SupportRemSoft->value, 'invalid']);

it('rejects invalid registration passwords without creating an account', function (?string $password): void {
    post(route('register'), [
        'name'                  => 'Policy User',
        'email'                 => 'policy@example.com',
        'password'              => $password,
        'password_confirmation' => $password,
    ])->assertSessionHasErrors('password');

    $this->assertDatabaseMissing('users', ['email' => 'policy@example.com']);
    $this->assertGuest();
})->with([
    'missing'      => null,
    'too short'    => 'Aa1!aaa',
    'no uppercase' => 'lowercase1!',
    'no lowercase' => 'UPPERCASE1!',
    'no number'    => 'NoNumbers!',
    'no symbol'    => 'NoSymbols123',
    'too long'     => str_repeat('Aa1!', 48),
    'compromised'  => 'LeakedSecure@123',
]);

it('rejects duplicate registration emails without changing the existing account', function (): void {
    $user             = User::factory()->create(['email' => 'duplicate@example.com']);
    $originalPassword = $user->password;

    post(route('register'), [
        'name'                  => 'Another User',
        'email'                 => ' DUPLICATE@example.com ',
        'password'              => 'CustomerSecure@123456',
        'password_confirmation' => 'CustomerSecure@123456',
    ])->assertSessionHasErrors('email');

    $this->assertDatabaseCount('users', 1);
    expect($user->fresh()->password)->toBe($originalPassword);
    $this->assertGuest();
});

it('rejects registration names shorter than three characters', function (): void {
    post(route('register'), [
        'name'                  => 'Ab',
        'email'                 => 'short-name@example.com',
        'password'              => 'CustomerSecure@123456',
        'password_confirmation' => 'CustomerSecure@123456',
    ])->assertSessionHasErrors('name');

    $this->assertDatabaseMissing('users', ['email' => 'short-name@example.com']);
});

it('blocks registration floods before creating accounts and allows retry after the window', function (): void {
    $this->freezeTime();
    Event::fake([Registered::class]);

    foreach (range(1, 3) as $attempt) {
        post(route('register'), [])->assertSessionHasErrors('email');
    }

    post(route('register'), [])->assertTooManyRequests()->assertHeader('Retry-After')->assertSee('Limite de cadastros');
    $this->assertDatabaseCount('users', 0);
    Event::assertNotDispatched(Registered::class);
    $this->travel(1)->hours();
    post(route('register'), [])->assertSessionHasErrors('email');
});
