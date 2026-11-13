<?php

declare(strict_types = 1);

use App\Livewire\Auth\Profile\Partials\UpdatePasswordForm;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

beforeEach(function (): void {
    config(['session.driver' => 'database', 'session.connection' => null]);
    Http::preventStrayRequests();
    Http::fake(['https://api.pwnedpasswords.com/range/*' => Http::response(substr(strtoupper(sha1('LeakedSecure@123')), 5) . ':1')]);
});

it('requires authentication to update a password', function (): void {
    livewire(UpdatePasswordForm::class)
        ->call('updatePassword')
        ->assertForbidden();
});

it('updates password with correct current password', function (): void {
    /** @var User $user */
    $user = User::factory()->create([
        'password' => Hash::make('OldPass@123'),
    ]);

    actingAs($user);

    $currentSessionId = session()->getId();
    $rememberToken    = $user->remember_token;
    DB::table('sessions')->insert([
        ['id' => $currentSessionId, 'user_id' => $user->id, 'payload' => '', 'last_activity' => time()],
        ['id' => 'other-device', 'user_id' => $user->id, 'payload' => '', 'last_activity' => time()],
    ]);

    livewire(UpdatePasswordForm::class)
        ->set('current_password', 'OldPass@123')
        ->set('password', 'NewPass@123')
        ->set('password_confirmation', 'NewPass@123')
        ->call('updatePassword')
        ->assertDispatched('toast')
        ->assertSet('current_password', '')
        ->assertSet('password', '')
        ->assertSet('password_confirmation', '');

    expect(Hash::check('NewPass@123', $user->fresh()->password))->toBeTrue();
    expect($user->fresh()->remember_token)->not->toBe($rememberToken);
    $this->assertDatabaseHas('sessions', ['id' => $currentSessionId, 'user_id' => $user->id]);
    $this->assertDatabaseMissing('sessions', ['id' => 'other-device']);
    $this->assertAuthenticatedAs($user);
    $this->get(route($user->type->profileRouteName()))->assertSuccessful();
});

it('throws validation error when current password is invalid', function (): void {
    /** @var User $user */
    $user = User::factory()->create([
        'password' => Hash::make('OldPass@123'),
    ]);

    actingAs($user);

    livewire(UpdatePasswordForm::class)
        ->set('current_password', 'WrongPass')
        ->set('password', 'NewPass@123')
        ->set('password_confirmation', 'NewPass@123')
        ->call('updatePassword')
        ->assertHasErrors('current_password');
});

it('preserves credentials and authentication when password validation fails', function (string $current, string $password, string $confirmation, string $field): void {
    $user          = User::factory()->create(['password' => 'OldPass@123']);
    $hash          = $user->password;
    $rememberToken = $user->remember_token;
    DB::table('sessions')->insert(['id' => 'existing-device', 'user_id' => $user->id, 'payload' => '', 'last_activity' => time()]);
    actingAs($user);

    livewire(UpdatePasswordForm::class)
        ->set('current_password', $current)
        ->set('password', $password)
        ->set('password_confirmation', $confirmation)
        ->call('updatePassword')
        ->assertHasErrors($field)
        ->assertNotDispatched('toast');

    expect($user->fresh()->password)->toBe($hash)
        ->and($user->fresh()->remember_token)->toBe($rememberToken);
    $this->assertAuthenticatedAs($user);
    $this->assertDatabaseHas('sessions', ['id' => 'existing-device', 'user_id' => $user->id]);
})->with([
    'weak password previously accepted' => ['OldPass@123', 'password', 'password', 'password'],
    'missing confirmation'              => ['OldPass@123', 'NewPass@123', '', 'password'],
    'different confirmation'            => ['OldPass@123', 'NewPass@123', 'OtherPass@123', 'password'],
    'missing current password'          => ['', 'NewPass@123', 'NewPass@123', 'current_password'],
    'incorrect current password'        => ['wrong', 'NewPass@123', 'NewPass@123', 'current_password'],
]);

it('rejects a compromised password in the profile', function (): void {
    $password = 'LeakedSecure@123';
    $user     = User::factory()->create(['password' => 'OldPass@123']);
    actingAs($user);

    livewire(UpdatePasswordForm::class)
        ->set('current_password', 'OldPass@123')
        ->set('password', $password)
        ->set('password_confirmation', $password)
        ->call('updatePassword')
        ->assertHasErrors('password')
        ->assertNotDispatched('toast');

    expect($user->fresh()->password)->toBe($user->password);
    Http::assertSentCount(1);
});
