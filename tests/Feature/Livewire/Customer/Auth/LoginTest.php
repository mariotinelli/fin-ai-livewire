<?php

declare(strict_types = 1);

use App\Enums\TypeUsers;
use App\Livewire\Customer\Auth\Login;
use App\Models\User;

use function Pest\Livewire\livewire;

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
