<?php

declare(strict_types = 1);

use App\Enums\TypeUsers;
use App\Livewire\Customer\Auth\Login;
use App\Models\User;
use Illuminate\Support\Facades\URL;

use function Pest\Livewire\livewire;

it('keeps the intended profile while a remembered customer confirms their email', function (string $profileRoute): void {
    $user = User::factory()->customer()->create(['email_verified_at' => null]);
    $this->get(route($profileRoute))->assertRedirect(route('customer.login'));
    livewire(Login::class)->set('email', ' ' . mb_strtoupper($user->email) . ' ')
        ->set('remember', true)->set('password', '12345678')->call('login')
        ->assertRedirect(route('verification.notice'));
    $this->get(route('verification.notice'))->assertOk()->assertSee($user->email);
    $link = URL::temporarySignedRoute('verification.verify', now()->addMinute(), ['id' => $user->id, 'hash' => sha1($user->email)]);
    $this->get($link)->assertRedirect(route($profileRoute));

    if ($profileRoute === 'profile.edit') {
        $this->get(route($profileRoute))->assertRedirect(route('customer.profile.edit'));
    }

    $this->get(route('customer.profile.edit'))->assertOk()->assertSee($user->email);
    expect($user->refresh()->hasVerifiedEmail())->toBeTrue();
})->with(['profile.edit', 'customer.profile.edit']);

it('resumes a verification link opened by a guest after personal login', function (): void {
    $user = User::factory()->customer()->create(['email_verified_at' => null]);
    $link = URL::temporarySignedRoute('verification.verify', now()->addMinute(), ['id' => $user->id, 'hash' => sha1($user->email)]);
    $this->get($link)->assertRedirect(route('customer.login'));
    livewire(Login::class)->set('email', $user->email)->set('password', '12345678')
        ->call('login')->assertRedirect($link);
    $this->get($link)->assertRedirect(route('customer.dashboard', ['verified' => 1]));
    expect($user->refresh()->hasVerifiedEmail())->toBeTrue();
});

it('returns to the requested profile after a guest opens the verification link twice', function (): void {
    $user = User::factory()->customer()->create(['email_verified_at' => null]);
    $link = URL::temporarySignedRoute('verification.verify', now()->addMinute(), ['id' => $user->id, 'hash' => sha1($user->email)]);

    $this->get(route('customer.profile.edit'))->assertRedirect(route('customer.login'));
    $this->get($link)->assertRedirect(route('customer.login'));
    $this->get($link)->assertRedirect(route('customer.login'));
    livewire(Login::class)->set('email', $user->email)->set('password', '12345678')
        ->call('login')->assertRedirect($link);
    $this->get($link)->assertRedirect(route('customer.profile.edit'));
    $this->get(route('customer.profile.edit'))->assertOk()->assertSee($user->email);
    expect($user->refresh()->hasVerifiedEmail())->toBeTrue();
});

it('authenticates a customer and regenerates the session', function (): void {
    $user      = User::factory()->customer()->create();
    $sessionId = session()->getId();
    livewire(Login::class)->assertSee('Área do cliente')
        ->set('email', $user->email)->set('password', '12345678')->call('login')
        ->assertHasNoErrors()->assertRedirect(route('customer.dashboard'));
    expect(auth()->id())->toBe($user->id);
    expect(session()->getId())->not->toBe($sessionId);
});

it('rejects internal users even with correct credentials', function (TypeUsers $type): void {
    $user = User::factory()->create(['type' => $type]);
    livewire(Login::class)->set('email', $user->email)->set('password', '12345678')
        ->call('login')->assertHasErrors('email');
    $this->assertGuest();
})->with([TypeUsers::Admin, TypeUsers::User, TypeUsers::SupportRemSoft]);

it('does not follow an intended URL outside the customer area', function (): void {
    $user = User::factory()->customer()->create();
    session()->put('url.intended', route('admin.dashboard'));
    livewire(Login::class)->set('email', $user->email)->set('password', '12345678')
        ->call('login')->assertRedirect(route('customer.dashboard'));
});

it('honors an intended customer profile after login', function (): void {
    $user = User::factory()->customer()->create();
    session()->put('url.intended', route('customer.profile.edit'));
    livewire(Login::class)->set('email', $user->email)->set('password', '12345678')
        ->call('login')->assertRedirect(route('customer.profile.edit'));
});
