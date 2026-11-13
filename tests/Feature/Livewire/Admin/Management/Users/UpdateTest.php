<?php

declare(strict_types = 1);

use App\Enums\Permissions\Management\UserPermissions;
use App\Enums\TypeUsers;
use App\Livewire\Admin\Management\Users\Update;
use App\Models\Role;
use App\Models\User;
use App\Notifications\VerifyEmailNotification as VerifyEmail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Livewire\livewire;

beforeEach(function (): void {
    $this->user = User::factory()->create(['type' => TypeUsers::SupportRemSoft]);
    $this->user->givePermissionTo(UserPermissions::Edit);
    $this->actingAs($this->user);

    $role = Role::factory()->create();

    $this->userToEdit = User::factory()->create([
        'name'    => 'John Doe',
        'email'   => '8YH2R@example.com',
        'type'    => TypeUsers::User->value,
        'role_id' => $role->id,
    ]);
});

it('cannot access update component without edit permission', function (): void {
    $this->user->revokePermissionTo(UserPermissions::Edit);

    livewire(Update::class)
        ->call('loadUser', $this->userToEdit->id)
        ->assertForbidden();

    $this->user->givePermissionTo(UserPermissions::Edit);

    livewire(Update::class)
        ->call('loadUser', $this->userToEdit->id)
        ->assertOk();
});

it('can load user data into the component', function (): void {
    livewire(Update::class)
        ->call('loadUser', $this->userToEdit->id)
        ->assertSet('user.name', $this->userToEdit->name)
        ->assertSet('user.email', $this->userToEdit->email)
        ->assertSet('user.role_id', $this->userToEdit->role_id)
        ->assertSet('modalOpen', true);
});

it('can update user data successfully', function (): void {
    Notification::fake();
    $this->userToEdit->update(['invitation_pending' => true]);
    $token      = Password::createToken($this->userToEdit);
    $targetRole = Role::factory()->create();

    livewire(Update::class)
        ->call('loadUser', $this->userToEdit->id)
        ->set('user.name', 'Updated Name')
        ->set('user.email', 'updated@example.com')
        ->set('user.role_id', $targetRole->id)
        ->call('save')
        ->assertHasNoErrors()
        ->assertToast('Usuário atualizado com sucesso')
        ->assertDispatched('users::refresh')
        ->assertSet('modalOpen', false);

    assertDatabaseHas('users', [
        'id'                => $this->userToEdit->id,
        'name'              => 'Updated Name',
        'email'             => 'updated@example.com',
        'type'              => TypeUsers::User->value,
        'role_id'           => $targetRole->id,
        'email_verified_at' => null,
    ]);

    Notification::assertSentTo($this->userToEdit, VerifyEmail::class);
    expect(Password::tokenExists($this->userToEdit, $token))->toBeFalse();
});

it('rejects assigning a role outside support scope without changing the user', function (): void {
    Notification::fake();
    $targetRole     = Role::factory()->withPermissions([UserPermissions::Delete])->create();
    $originalRoleId = $this->userToEdit->role_id;

    livewire(Update::class)
        ->call('loadUser', $this->userToEdit->id)
        ->set('user.name', 'Elevated User')
        ->set('user.email', 'elevated@example.com')
        ->set('user.role_id', $targetRole->id)
        ->call('save')
        ->assertForbidden()
        ->assertNotDispatched('users::refresh')
        ->assertNotDispatched('toast');

    assertDatabaseHas('users', [
        'id'      => $this->userToEdit->id,
        'name'    => 'John Doe',
        'email'   => '8YH2R@example.com',
        'role_id' => $originalRoleId,
    ]);
    Notification::assertNothingSent();
});

test('name validation', function (int | string | null $name, string $rule): void {
    livewire(Update::class)
        ->call('loadUser', $this->userToEdit->id)
        ->set('user.name', $name)
        ->call('save')
        ->assertHasErrors(['user.name' => $rule]);
})->with([
    [null, 'required'],
    [154, 'string'],
    [str_repeat('a', 192), 'max'],
    ['aa', 'min'],
]);

test('email validation', function (?string $email, string $rule): void {
    User::factory()->create(['email' => 'existing@example.com']);

    livewire(Update::class)
        ->call('loadUser', $this->userToEdit->id)
        ->set('user.email', $email)
        ->call('save')
        ->assertHasErrors(['user.email' => $rule]);
})->with([
    [null, 'required'],
    ['invalid-email', 'email'],
    [str_repeat('a', 192) . '@gmail.com', 'max'],
    ['existing@example.com', 'unique'],
]);

test('role_id validation', function (?int $roleId, string $rule): void {
    livewire(Update::class)
        ->call('loadUser', $this->userToEdit->id)
        ->set('user.role_id', $roleId)
        ->call('save')
        ->assertHasErrors(['user.role_id' => $rule]);
})->with([
    [null, 'required'],
    [-1, 'exists'],
]);

it('rejects loading targets outside the user domain', function (TypeUsers $type): void {
    $this->userToEdit->update(['type' => $type]);

    $component = livewire(Update::class);

    $component->call('loadUser', $this->userToEdit->id)->assertStatus(404);

    expect($this->userToEdit->fresh()->type)->toBe($type);
})->with([TypeUsers::Admin, TypeUsers::SupportRemSoft, TypeUsers::Customer]);

it('rejects a target that changed type after opening the modal', function (TypeUsers $type): void {
    $component = livewire(Update::class)->call('loadUser', $this->userToEdit->id);
    $this->userToEdit->update(['type' => $type]);
    $attributes = $this->userToEdit->fresh()->getAttributes();

    $component->call('save')->assertStatus(404);

    $component->assertNotDispatched('users::refresh');

    expect($this->userToEdit->fresh()->getAttributes())->toBe($attributes);
})->with([TypeUsers::Admin, TypeUsers::SupportRemSoft, TypeUsers::Customer]);

it('reauthorizes the mutation after permission is revoked', function (): void {
    Notification::fake();
    $this->userToEdit->update(['invitation_pending' => true]);
    $token      = Password::createToken($this->userToEdit);
    $targetRole = Role::factory()->create();
    $component  = livewire(Update::class)->call('loadUser', $this->userToEdit->id);
    $attributes = $this->userToEdit->fresh()->getAttributes();
    $component
        ->set('user.name', 'Blocked Update')
        ->set('user.email', 'blocked-update@example.com')
        ->set('user.role_id', $targetRole->id);
    $this->user->revokePermissionTo(UserPermissions::Edit);

    $component->call('save')
        ->assertNotDispatched('users::refresh')
        ->assertNotDispatched('toast')
        ->assertForbidden();

    expect($this->userToEdit->fresh()->getAttributes())->toBe($attributes);
    expect(Password::tokenExists($this->userToEdit, $token))->toBeTrue();
    Notification::assertNothingSent();
});

it('forbids saving valid data directly without edit permission', function (): void {
    Notification::fake();
    $targetRole = Role::factory()->create();
    $attributes = $this->userToEdit->fresh()->getAttributes();
    $this->user->revokePermissionTo(UserPermissions::Edit);

    livewire(Update::class)
        ->set('user', $this->userToEdit)
        ->set('user.name', 'Blocked Update')
        ->set('user.email', 'blocked-update@example.com')
        ->set('user.role_id', $targetRole->id)
        ->call('save')
        ->assertNotDispatched('users::refresh')
        ->assertNotDispatched('toast')
        ->assertForbidden();

    expect($this->userToEdit->fresh()->getAttributes())->toBe($attributes);
    Notification::assertNothingSent();
});

it('rejects a privileged id substituted into valid form data', function (TypeUsers $type): void {
    Notification::fake();
    $privilegedTarget     = User::factory()->create(['type' => $type]);
    $targetRole           = Role::factory()->create();
    $originalAttributes   = $this->userToEdit->fresh()->getAttributes();
    $privilegedAttributes = $privilegedTarget->fresh()->getAttributes();

    $component = livewire(Update::class)
        ->call('loadUser', $this->userToEdit->id)
        ->set('user', $privilegedTarget)
        ->set('user.name', 'Tampered Update')
        ->set('user.email', 'tampered-update@example.com')
        ->set('user.role_id', $targetRole->id);

    $component->call('save')->assertStatus(404);

    $component
        ->assertNotDispatched('users::refresh')
        ->assertNotDispatched('toast');
    expect($this->userToEdit->fresh()->getAttributes())->toBe($originalAttributes);
    expect($privilegedTarget->fresh()->getAttributes())->toBe($privilegedAttributes);
    Notification::assertNothingSent();
})->with([TypeUsers::Admin, TypeUsers::SupportRemSoft, TypeUsers::Customer]);

it('rejects mutation without a target id', function (): void {
    livewire(Update::class)->call('save')->assertStatus(404);
});

it('preserves verification and does not notify when the new email is invalid', function (string $email, string $rule): void {
    Notification::fake();
    User::factory()->create(['email' => 'duplicate-update@example.com']);
    $verifiedAt    = $this->userToEdit->email_verified_at;
    $originalEmail = $this->userToEdit->email;

    livewire(Update::class)
        ->call('loadUser', $this->userToEdit->id)
        ->set('user.email', $email)
        ->call('save')
        ->assertHasErrors(['user.email' => $rule])
        ->assertNotDispatched('users::refresh');

    expect($this->userToEdit->fresh()->email)->toBe($originalEmail);
    expect($this->userToEdit->fresh()->email_verified_at?->toDateTimeString())->toBe($verifiedAt?->toDateTimeString());
    Notification::assertNothingSent();
})->with([
    'malformed' => ['invalid', 'email'],
    'duplicate' => ['duplicate-update@example.com', 'unique'],
]);

it('ignores a forged type when updating a regular user', function (): void {
    livewire(Update::class)
        ->call('loadUser', $this->userToEdit->id)
        ->set('user', [
            'id'      => $this->userToEdit->id,
            'name'    => 'Updated Name',
            'email'   => $this->userToEdit->email,
            'role_id' => $this->userToEdit->role_id,
            'type'    => TypeUsers::Admin->value,
        ])
        ->call('save')
        ->assertHasNoErrors();

    expect($this->userToEdit->fresh()->type)->toBe(TypeUsers::User);
    expect($this->userToEdit->fresh()->name)->toBe('Updated Name');
});
