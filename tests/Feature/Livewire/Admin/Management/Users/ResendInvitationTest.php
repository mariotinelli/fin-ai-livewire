<?php

declare(strict_types = 1);

use App\Enums\Permissions\Management\UserPermissions;
use App\Enums\TypeUsers;
use App\Exceptions\InvitationPublicationFailed;
use App\Livewire\Admin\Management\Users\ResendInvitation;
use App\Models\User;
use App\Notifications\NewUserNotification;
use Illuminate\Support\Facades\Exceptions;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Queue;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

it('confirms the recipient and requests an invitation resend', function (): void {
    actingAsAdmin();
    Notification::fake();
    $user = User::factory()->user()->create(['invitation_pending' => true]);

    livewire(ResendInvitation::class)
        ->dispatch('users::resend-invitation', id: $user->id)
        ->assertSet('modalOpen', true)
        ->assertSee($user->email)
        ->call('resend')
        ->assertHasNoErrors()
        ->assertSet('modalOpen', false)
        ->assertDispatched('users::refresh')
        ->assertToast('Reenvio do convite solicitado', 'O convite será enviado em segundo plano.');

    Notification::assertSentTo($user, NewUserNotification::class);
});

it('explains the cooldown and leaves the modal open without replacing the token', function (): void {
    actingAsAdmin();
    Notification::fake();
    $user  = User::factory()->user()->create(['invitation_pending' => true]);
    $token = Password::createToken($user);

    livewire(ResendInvitation::class)
        ->call('loadUser', $user->id)
        ->call('resend')
        ->assertHasErrors('invitation')
        ->assertSee('Aguarde 60 segundos entre os envios de convite.')
        ->assertSet('modalOpen', true)
        ->assertNotDispatched('users::refresh');

    expect(Password::tokenExists($user, $token))->toBeTrue();
    Notification::assertNothingSent();
});

it('forbids direct submission without permission', function (): void {
    actingAsUser(UserPermissions::View);
    Notification::fake();
    $user = User::factory()->user()->create(['invitation_pending' => true]);

    livewire(ResendInvitation::class)->set('user', $user)->call('resend')->assertForbidden();

    $this->assertDatabaseMissing('password_reset_tokens', ['email' => $user->email]);
    Notification::assertNothingSent();
});

it('rechecks permission after the modal opens', function (): void {
    $actor = User::factory()->create(['type' => TypeUsers::SupportRemSoft]);
    $actor->givePermissionTo(UserPermissions::Edit);
    actingAs($actor);
    Notification::fake();
    $user      = User::factory()->user()->create(['invitation_pending' => true]);
    $component = livewire(ResendInvitation::class)->call('loadUser', $user->id);
    $actor->revokePermissionTo(UserPermissions::Edit);

    $component->call('resend')->assertForbidden();

    $this->assertDatabaseMissing('password_reset_tokens', ['email' => $user->email]);
    Notification::assertNothingSent();
});

it('rejects targets that became ineligible after opening the modal', function (array $changes): void {
    actingAsAdmin();
    Notification::fake();
    $user  = User::factory()->user()->create(['invitation_pending' => true]);
    $token = Password::createToken($user);
    $this->travel(61)->seconds();
    $component = livewire(ResendInvitation::class)->call('loadUser', $user->id);
    User::whereKey($user->id)->update($changes);

    $component->call('resend')->assertForbidden()->assertNotDispatched('users::refresh');

    expect(Password::tokenExists($user, $token))->toBeTrue();
    Notification::assertNothingSent();
})->with([
    'inactive'   => [['deleted_at' => '2026-01-01 00:00:00']],
    'accepted'   => [['invitation_pending' => false]],
    'privileged' => [['type' => TypeUsers::Admin]],
]);

it('reports publication failure without claiming success or losing the old invitation', function (): void {
    actingAsAdmin();
    Exceptions::fake();
    $user  = User::factory()->user()->create(['invitation_pending' => true]);
    $token = Password::createToken($user);
    $this->travel(61)->seconds();
    Queue::partialMock()->shouldReceive('connection')->andThrow(new RuntimeException('Queue unavailable'));

    livewire(ResendInvitation::class)
        ->call('loadUser', $user->id)
        ->call('resend')
        ->assertHasErrors('invitation')
        ->assertSee('Não foi possível solicitar o reenvio. Tente novamente.')
        ->assertSet('modalOpen', true)
        ->assertNotDispatched('users::refresh');

    expect(Password::tokenExists($user, $token))->toBeTrue();
    Exceptions::assertReported(fn (InvitationPublicationFailed $exception): bool => $exception->getPrevious() instanceof RuntimeException);
});
