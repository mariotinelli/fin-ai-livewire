<?php

declare(strict_types = 1);

use App\Enums\TypeUsers;
use App\Livewire\Auth\Logout;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function Pest\Livewire\livewire;

it('logs out only the current device and redirects to the existing login', function (TypeUsers $type): void {
    config(['session.driver' => 'database', 'session.connection' => null]);
    $user = User::factory()->create(['type' => $type]);
    Auth::guard('web')->login($user, remember: true);
    session()->regenerateToken();
    session()->put('private-data', 'current-device');

    $sessionId     = session()->getId();
    $csrfToken     = session()->token();
    $rememberToken = $user->fresh()->remember_token;
    DB::table('sessions')->insert([
        ['id' => $sessionId, 'user_id' => $user->id, 'payload' => '', 'last_activity' => time()],
        ['id' => 'other-device', 'user_id' => $user->id, 'payload' => '', 'last_activity' => time()],
    ]);

    livewire(Logout::class)
        ->call('logout')
        ->assertRedirect(route(match ($type) {
            TypeUsers::Customer => 'customer.login', TypeUsers::SupportRemSoft => 'support.login', default => 'admin.login'
        }));

    $this->assertGuest();
    expect($user->fresh()->remember_token)->toBe($rememberToken);
    expect(session()->getId())->not->toBe($sessionId);
    expect(session()->token())->not->toBe($csrfToken);
    expect(session()->has('private-data'))->toBeFalse();
    $this->assertDatabaseMissing('sessions', ['id' => $sessionId]);
    $this->assertDatabaseHas('sessions', ['id' => 'other-device', 'user_id' => $user->id]);
})->with(TypeUsers::cases());

it('allows logout without an authenticated user', function (): void {
    session()->regenerateToken();
    $sessionId = session()->getId();
    $csrfToken = session()->token();

    livewire(Logout::class)->call('logout')->assertRedirect(route('admin.login'));

    $this->assertGuest();
    expect(session()->getId())->not->toBe($sessionId);
    expect(session()->token())->not->toBe($csrfToken);
});
