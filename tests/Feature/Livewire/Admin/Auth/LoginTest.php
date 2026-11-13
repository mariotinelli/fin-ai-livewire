<?php

declare(strict_types = 1);

use App\Enums\TypeUsers;
use App\Livewire\Admin\Auth\Login;
use App\Models\User;
use Illuminate\Support\Facades\RateLimiter;

use function Pest\Livewire\livewire;

it('starts without prefilled credentials and renders the admin form', function (): void {
    livewire(Login::class)
        ->assertSet('email', '')
        ->assertSet('password', '')
        ->assertSet('remember', false)
        ->assertSee('Área administrativa')
        ->assertSee('Lembrar-me')
        ->assertSee('Esqueceu sua senha?');
});

it('validates the credentials before authentication', function (): void {
    livewire(Login::class)
        ->call('login')
        ->assertHasErrors([
            'email'    => 'required',
            'password' => 'required',
        ]);
});

it('authenticates user types allowed in the admin area', function (TypeUsers $type): void {
    $user = User::factory()->create([
        'email' => fake()->unique()->safeEmail(),
        'type'  => $type,
    ]);

    livewire(Login::class)
        ->set('email', $user->email)
        ->set('password', '12345678')
        ->set('remember', true)
        ->call('login')
        ->assertHasNoErrors()
        ->assertRedirect(route('admin.dashboard'));

    expect(auth()->id())->toBe($user->id);
})->with([
    'admin' => TypeUsers::Admin,
    'user'  => TypeUsers::User,
]);

it('rejects types outside the admin area with the generic credentials message', function (TypeUsers $type): void {
    $customer = User::factory()->create(['type' => $type]);

    $component = livewire(Login::class)
        ->set('email', $customer->email)
        ->set('password', '12345678')
        ->call('login')
        ->assertHasErrors('email');

    expect($component->errors()->first('email'))->toBe(__('auth.failed'))
        ->and(auth()->check())->toBeFalse();
})->with([TypeUsers::Customer, TypeUsers::SupportRemSoft]);

it('rejects invalid credentials with the same generic message', function (): void {
    $user = User::factory()->admin()->create();

    $component = livewire(Login::class)
        ->set('email', $user->email)
        ->set('password', 'invalid-password')
        ->call('login')
        ->assertHasErrors('email');

    expect($component->errors()->first('email'))->toBe(__('auth.failed'))
        ->and(auth()->check())->toBeFalse();
});

it('rate limits repeated failed login attempts', function (): void {
    app()->setLocale('pt_BR');
    $email = 'limited@example.com';
    $key   = $email . '|127.0.0.1';

    RateLimiter::clear($key);

    foreach (range(1, 5) as $attempt) {
        livewire(Login::class)
            ->set('email', $email)
            ->set('password', 'invalid-password')
            ->call('login')
            ->assertHasErrors('email');
    }

    $component = livewire(Login::class)
        ->set('email', $email)
        ->set('password', 'invalid-password')
        ->call('login')
        ->assertHasErrors('email');

    expect($component->errors()->first('email'))->toContain('muitas tentativas');

    RateLimiter::clear($key);
});

it('only honors intended destinations inside the admin area', function (): void {
    $user        = User::factory()->admin()->create();
    $intendedUrl = route('admin.dashboard');

    session()->put('url.intended', $intendedUrl);

    livewire(Login::class)
        ->set('email', $user->email)
        ->set('password', '12345678')
        ->call('login')
        ->assertRedirect($intendedUrl);
});

it('ignores intended destinations outside the admin area', function (): void {
    $user = User::factory()->admin()->create();

    session()->put('url.intended', route('dashboard'));

    livewire(Login::class)
        ->set('email', $user->email)
        ->set('password', '12345678')
        ->call('login')
        ->assertRedirect(route('admin.dashboard'));
});
