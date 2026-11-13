<?php

declare(strict_types = 1);

use App\Enums\Permissions\Management\UserPermissions;
use App\Enums\TypeUsers;
use App\Livewire\Admin\Management\Users\Delete;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use function Pest\Laravel\assertSoftDeleted;
use function Pest\Livewire\livewire;

beforeEach(function (): void {
    config(['session.driver' => 'database', 'session.connection' => null]);
    $this->loggedUser = actingAsUser(UserPermissions::Delete);

    $this->role = Role::factory()->create();

    $this->user = User::factory()->create([
        'name'    => 'User To Delete',
        'type'    => TypeUsers::User->value,
        'role_id' => $this->role->id,
    ]);
});

it('can delete with user permission', function (): void {
    $this->loggedUser->revokePermissionTo(UserPermissions::Delete);

    livewire(Delete::class)
        ->call('loadUser', $this->user->id)
        ->assertForbidden();

    $this->loggedUser->givePermissionTo(UserPermissions::Delete);

    livewire(Delete::class)
        ->call('loadUser', $this->user->id)
        ->assertOk();
});

it('can load user data into the delete component and open modal', function (): void {
    livewire(Delete::class)
        ->call('loadUser', $this->user->id)
        ->assertSet('user.id', $this->user->id)
        ->assertSet('modalOpen', true);
});

it('can delete a user', function (): void {
    $rememberToken = $this->user->remember_token;
    DB::table('sessions')->insert(['id' => 'old-device', 'user_id' => $this->user->id, 'payload' => '', 'last_activity' => time()]);

    livewire(Delete::class)
        ->call('loadUser', $this->user->id)
        ->assertSet('modalOpen', true)
        ->call('delete')
        ->assertSet('modalOpen', false)
        ->assertDispatched('users::refresh')
        ->assertToast('Usuário desativado com sucesso');

    assertSoftDeleted($this->user);
    expect($this->user->fresh()->remember_token)->not->toBe($rememberToken);
    $this->assertDatabaseMissing('sessions', ['user_id' => $this->user->id]);
});

it('ends the current session when an authorized user deactivates their own account', function (): void {
    $sessionId = session()->getId();
    DB::table('sessions')->insert(['id' => $sessionId, 'user_id' => $this->loggedUser->id, 'payload' => '', 'last_activity' => time()]);

    livewire(Delete::class)
        ->call('loadUser', $this->loggedUser->id)
        ->call('delete')
        ->assertRedirect(route('admin.login'));

    $this->assertGuest();
    assertSoftDeleted($this->loggedUser);
    expect(session()->getId())->not->toBe($sessionId);
    $this->assertDatabaseMissing('sessions', ['user_id' => $this->loggedUser->id]);
});

it('rejects loading targets outside the user domain', function (TypeUsers $type): void {
    $this->user->update(['type' => $type]);

    $component = livewire(Delete::class);

    $component->call('loadUser', $this->user->id)->assertStatus(404);

    expect($this->user->fresh()->type)->toBe($type);
})->with([TypeUsers::Admin, TypeUsers::SupportRemSoft, TypeUsers::Customer]);

it('rejects a target that changed type after opening the modal', function (TypeUsers $type): void {
    $component = livewire(Delete::class)->call('loadUser', $this->user->id);
    $this->user->update(['type' => $type]);
    $attributes = $this->user->fresh()->getAttributes();

    $component->call('delete')->assertStatus(404);

    $component->assertNotDispatched('users::refresh');

    expect($this->user->fresh()->getAttributes())->toBe($attributes);
})->with([TypeUsers::Admin, TypeUsers::SupportRemSoft, TypeUsers::Customer]);

it('reauthorizes the mutation after permission is revoked', function (): void {
    DB::table('sessions')->insert(['id' => 'existing-device', 'user_id' => $this->user->id, 'payload' => '', 'last_activity' => time()]);
    $component  = livewire(Delete::class)->call('loadUser', $this->user->id);
    $attributes = $this->user->fresh()->getAttributes();
    $this->loggedUser->revokePermissionTo(UserPermissions::Delete);

    $component->call('delete')
        ->assertNotDispatched('users::refresh')
        ->assertNotDispatched('toast')
        ->assertForbidden();

    expect($this->user->fresh()->getAttributes())->toBe($attributes);
    $this->assertDatabaseHas('sessions', ['id' => 'existing-device', 'user_id' => $this->user->id]);
});

it('forbids deleting directly without delete permission', function (): void {
    $attributes = $this->user->fresh()->getAttributes();
    $this->loggedUser->revokePermissionTo(UserPermissions::Delete);

    livewire(Delete::class)
        ->set('user', $this->user)
        ->call('delete')
        ->assertNotDispatched('users::refresh')
        ->assertNotDispatched('toast')
        ->assertForbidden();

    expect($this->user->fresh()->getAttributes())->toBe($attributes);
});

it('rejects a privileged id substituted before deletion', function (TypeUsers $type): void {
    $privilegedTarget     = User::factory()->create(['type' => $type]);
    $originalAttributes   = $this->user->fresh()->getAttributes();
    $privilegedAttributes = $privilegedTarget->fresh()->getAttributes();
    $component            = livewire(Delete::class)
        ->call('loadUser', $this->user->id)
        ->set('user', $privilegedTarget);

    $component->call('delete')->assertStatus(404);

    $component
        ->assertNotDispatched('users::refresh')
        ->assertNotDispatched('toast');
    expect($this->user->fresh()->getAttributes())->toBe($originalAttributes);
    expect($privilegedTarget->fresh()->getAttributes())->toBe($privilegedAttributes);
})->with([TypeUsers::Admin, TypeUsers::SupportRemSoft, TypeUsers::Customer]);

it('rejects mutation without a target id', function (): void {
    livewire(Delete::class)->call('delete')->assertStatus(404);
});
