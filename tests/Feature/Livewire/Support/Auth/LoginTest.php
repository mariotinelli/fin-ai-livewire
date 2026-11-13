<?php

declare(strict_types = 1);

use App\Enums\TypeUsers;
use App\Livewire\Support\Auth\Login;
use App\Models\User;
use Illuminate\Support\Facades\RateLimiter;

use function Pest\Livewire\livewire;

it('authenticates support and regenerates its session', function (): void {
    $user      = User::factory()->create(['type' => TypeUsers::SupportRemSoft]);
    $sessionId = session()->getId();
    livewire(Login::class)->assertSee('Área de suporte')
        ->set('email', $user->email)->set('password', '12345678')->call('login')
        ->assertHasNoErrors()->assertRedirect(route('support.system-error-alerts.index'));
    expect(auth()->id())->toBe($user->id);
    expect(session()->getId())->not->toBe($sessionId);
});

it('rejects other user types without authenticating', function (TypeUsers $type): void {
    $user = User::factory()->create(['type' => $type]);
    livewire(Login::class)->set('email', $user->email)->set('password', '12345678')
        ->call('login')->assertHasErrors('email');
    $this->assertGuest();
})->with([TypeUsers::Admin, TypeUsers::User, TypeUsers::Customer]);

it('accepts only local support destinations after authentication', function (string $destination, string $expected): void {
    $user = User::factory()->create(['type' => TypeUsers::SupportRemSoft]);
    session()->put('url.intended', str_starts_with($destination, 'https://') ? $destination : url($destination));
    livewire(Login::class)->set('email', $user->email)->set('password', '12345678')
        ->call('login')->assertRedirect(url($expected));
})->with([
    ['/suporte/meu-perfil', '/suporte/meu-perfil'],
    ['/admin/dashboard', '/suporte/alertas-erros'],
    ['https://external.example/suporte/alertas-erros', '/suporte/alertas-erros'],
    ['/suporte-other/path', '/suporte/alertas-erros'],
]);

it('limits repeated failed support login attempts', function (): void {
    RateLimiter::hit('support@example.test|127.0.0.1');

    foreach (range(1, 4) as $attempt) {
        RateLimiter::hit('support@example.test|127.0.0.1');
    }

    livewire(Login::class)->set('email', 'support@example.test')->set('password', 'invalid')
        ->call('login')->assertHasErrors('email');
    $this->assertGuest();
});
