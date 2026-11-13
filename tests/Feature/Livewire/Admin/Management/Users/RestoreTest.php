<?php

declare(strict_types = 1);

use App\Actions\Users\DeleteUser;
use App\Enums\Permissions\Management\UserPermissions;
use App\Enums\TypeUsers;
use App\Livewire\Admin\Management\Users\Restore;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use function Pest\Laravel\assertNotSoftDeleted;
use function Pest\Livewire\livewire;

beforeEach(function (): void {
    $this->loggedUser = actingAsUser(UserPermissions::Restore);

    $this->role = Role::factory()->create();

    $this->userToRestore = User::factory()->create([
        'name'    => 'User To Restore',
        'type'    => TypeUsers::User->value,
        'role_id' => $this->role->id,
    ]);

    $this->userToRestore->delete();
});

it('can access with restore user permission', function (): void {
    $this->loggedUser->revokePermissionTo(UserPermissions::Restore);

    livewire(Restore::class)
        ->call('loadUser', $this->userToRestore->id)
        ->assertForbidden();

    $this->loggedUser->givePermissionTo(UserPermissions::Restore);

    livewire(Restore::class)
        ->call('loadUser', $this->userToRestore->id)
        ->assertOk();
});

it('can restore a soft deleted user successfully', function (): void {
    livewire(Restore::class)
        ->call('loadUser', $this->userToRestore->id)
        ->assertSet('modalOpen', true)
        ->call('restore')
        ->assertDispatched('users::refresh')
        ->assertToast('Usuário ativado com sucesso')
        ->assertSet('modalOpen', false);

    assertNotSoftDeleted($this->userToRestore);
});

it('keeps previous sessions and remember credentials revoked after reactivation', function (): void {
    config(['session.driver' => 'database', 'session.connection' => null]);
    $this->userToRestore->restore();
    $oldToken = $this->userToRestore->remember_token;
    DB::table('sessions')->insert(['id' => 'old-device', 'user_id' => $this->userToRestore->id, 'payload' => '', 'last_activity' => time()]);
    app(DeleteUser::class)->handle(actor: User::factory()->admin()->create(), user: $this->userToRestore);
    $revokedToken = $this->userToRestore->fresh()->remember_token;

    livewire(Restore::class)
        ->call('loadUser', $this->userToRestore->id)
        ->call('restore')
        ->assertDispatched('users::refresh');

    assertNotSoftDeleted($this->userToRestore);
    expect($this->userToRestore->fresh()->remember_token)->toBe($revokedToken)->not->toBe($oldToken);
    $this->assertDatabaseMissing('sessions', ['user_id' => $this->userToRestore->id]);
});

it('rejects loading targets outside the user domain', function (TypeUsers $type): void {
    $this->userToRestore->update(['type' => $type]);

    $component = livewire(Restore::class);

    $component->call('loadUser', $this->userToRestore->id)->assertStatus(404);

    expect($this->userToRestore->fresh()->type)->toBe($type);
})->with([TypeUsers::Admin, TypeUsers::SupportRemSoft, TypeUsers::Customer]);

it('rejects a target that changed type after opening the modal', function (TypeUsers $type): void {
    $component = livewire(Restore::class)->call('loadUser', $this->userToRestore->id);
    $this->userToRestore->update(['type' => $type]);
    $attributes = $this->userToRestore->fresh()->getAttributes();

    $component->call('restore')->assertStatus(404);

    $component->assertNotDispatched('users::refresh');

    expect($this->userToRestore->fresh()->getAttributes())->toBe($attributes);
})->with([TypeUsers::Admin, TypeUsers::SupportRemSoft, TypeUsers::Customer]);

it('reauthorizes the mutation after permission is revoked', function (): void {
    $component  = livewire(Restore::class)->call('loadUser', $this->userToRestore->id);
    $attributes = $this->userToRestore->fresh()->getAttributes();
    $this->loggedUser->revokePermissionTo(UserPermissions::Restore);

    $component->call('restore')
        ->assertNotDispatched('users::refresh')
        ->assertNotDispatched('toast')
        ->assertForbidden();

    expect($this->userToRestore->fresh()->getAttributes())->toBe($attributes);
});

it('forbids restoring directly without restore permission', function (): void {
    $attributes = $this->userToRestore->fresh()->getAttributes();
    $this->loggedUser->revokePermissionTo(UserPermissions::Restore);

    livewire(Restore::class)
        ->set('user', $this->userToRestore)
        ->call('restore')
        ->assertNotDispatched('users::refresh')
        ->assertNotDispatched('toast')
        ->assertForbidden();

    expect($this->userToRestore->fresh()->getAttributes())->toBe($attributes);
});

it('rejects a privileged id substituted before restoration', function (TypeUsers $type): void {
    $privilegedTarget = User::factory()->create(['type' => $type]);
    $privilegedTarget->delete();

    $originalAttributes   = $this->userToRestore->fresh()->getAttributes();
    $privilegedAttributes = $privilegedTarget->fresh()->getAttributes();
    $component            = livewire(Restore::class)
        ->call('loadUser', $this->userToRestore->id)
        ->set('user', $privilegedTarget);

    $component->call('restore')->assertStatus(404);

    $component
        ->assertNotDispatched('users::refresh')
        ->assertNotDispatched('toast');
    expect($this->userToRestore->fresh()->getAttributes())->toBe($originalAttributes);
    expect($privilegedTarget->fresh()->getAttributes())->toBe($privilegedAttributes);
})->with([TypeUsers::Admin, TypeUsers::SupportRemSoft, TypeUsers::Customer]);

it('rejects mutation without a target id', function (): void {
    livewire(Restore::class)->call('restore')->assertStatus(404);
});
