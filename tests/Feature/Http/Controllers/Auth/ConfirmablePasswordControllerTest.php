<?php

declare(strict_types = 1);

use App\Models\User;
use Illuminate\Support\Facades\Hash;

beforeEach(function (): void {
    $this->withoutVite();
});

it('renders the password confirmation form for authenticated users', function (): void {
    $this->actingAs(User::factory()->customer()->create())
        ->get(route('password.confirm'))
        ->assertOk()
        ->assertViewIs('auth.confirm-password');
});

it('records a successful password confirmation and redirects', function (): void {
    $user = User::factory()->customer()->create(['password' => Hash::make('correct-password')]);

    $this->actingAs($user)->post(route('password.confirm'), ['password' => 'correct-password'])
        ->assertRedirect(route('customer.dashboard'))
        ->assertSessionHas('auth.password_confirmed_at');
});

it('rejects an invalid password without confirming the session', function (): void {
    $user = User::factory()->customer()->create(['password' => Hash::make('correct-password')]);

    $this->actingAs($user)->from(route('password.confirm'))
        ->post(route('password.confirm'), ['password' => 'wrong-password'])
        ->assertRedirect(route('password.confirm'))
        ->assertSessionHasErrors('password');

    expect(session()->has('auth.password_confirmed_at'))->toBeFalse();
});

it('keeps confirmed customers inside their area', function (string $path, string $expected): void {
    $customer = User::factory()->customer()->create();
    session()->put('url.intended', str_starts_with($path, 'https://') ? $path : url($path));

    $this->actingAs($customer)->post(route('password.confirm'), ['password' => '12345678'])
        ->assertRedirect(url($expected))->assertSessionHas('auth.password_confirmed_at');
})->with([
    ['/cliente/meu-perfil', '/cliente/meu-perfil'],
    ['/admin/dashboard', '/cliente/dashboard'],
    ['https://external.example/cliente/dashboard', '/cliente/dashboard'],
]);
