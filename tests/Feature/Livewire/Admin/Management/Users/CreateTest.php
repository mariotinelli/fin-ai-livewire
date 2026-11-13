<?php

declare(strict_types = 1);

use App\Enums\Permissions\Management\UserPermissions;
use App\Enums\TypeUsers;
use App\Livewire\Admin\Management\Users\Create;
use App\Models\Role;
use App\Models\User;
use App\Notifications\NewUserNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Livewire\livewire;

beforeEach(function (): void {
    Http::preventStrayRequests();
    Http::fake(['https://api.pwnedpasswords.com/range/*' => Http::response(substr(strtoupper(sha1('LeakedSecure@123')), 5) . ':1')]);
});

it('rejects a repeated submission without creating another account or invitation', function (): void {
    Notification::fake();
    $component = livewire(Create::class)->call('loadUser')
        ->set('user.name', 'Repeated User')->set('user.email', 'repeated@example.com')
        ->set('user.role_id', Role::factory()->create()->id);

    $component->call('save')->assertHasNoErrors();
    $component->call('save')->assertHasErrors(['user.email' => 'unique']);

    expect(User::query()->where('email', 'repeated@example.com')->count())->toBe(1);
    Notification::assertCount(1);
});

it('shows validation when the database detects a duplicate after form validation', function (): void {
    Notification::fake();
    $component = livewire(Create::class)->call('loadUser')
        ->set('user.name', 'Concurrent User')->set('user.email', 'concurrent@example.com')
        ->set('user.role_id', Role::factory()->create()->id);

    User::creating(function (User $user): void {
        if ($user->email === 'concurrent@example.com') {
            DB::table('users')->insert($user->getAttributes());
        }
    });

    $component->call('save')->assertHasErrors(['user.email'])
        ->assertSee('Este e-mail já está cadastrado.')
        ->assertNotDispatched('users::refresh');
    $this->assertDatabaseMissing('users', ['email' => 'concurrent@example.com']);
    $this->assertDatabaseCount('password_reset_tokens', 0);
    Notification::assertNothingSent();
});

beforeEach(function (): void {
    $this->user = User::factory()->create(['type' => TypeUsers::SupportRemSoft]);
    $this->user->givePermissionTo(UserPermissions::Create);
    $this->actingAs($this->user);
});

it('can access with create user permission', function (): void {
    $this->user->revokePermissionTo(UserPermissions::Create);

    livewire(Create::class)
        ->call('loadUser')
        ->assertForbidden();

    $this->user->givePermissionTo(UserPermissions::Create);

    livewire(Create::class)
        ->call('loadUser')
        ->assertOk();
});

it('can create a user', function (): void {
    Notification::fake();

    $role = Role::factory()->create();

    livewire(Create::class)
        ->call('loadUser')
        ->assertSet('modalOpen', true)
        ->set('user', [
            'name'    => 'John Doe',
            'email'   => '8YH2R@example.com',
            'role_id' => $role->id,
        ])
        ->call('save')
        ->assertHasNoErrors()
        ->assertToast('Usuário cadastrado com sucesso')
        ->assertDispatched('users::refresh')
        ->assertSet('modalOpen', false);

    $newUser = User::query()->where('email', '8YH2R@example.com')->first();

    expect($newUser)->not->toBeNull()
        ->and($newUser->type)->toBe(TypeUsers::User)
        ->and($newUser->role_id)->toBe($role->id);

    assertDatabaseHas('users', [
        'email'   => '8YH2R@example.com',
        'name'    => 'John Doe',
        'type'    => TypeUsers::User->value,
        'role_id' => $role->id,
    ]);

    Notification::assertSentTo($newUser, NewUserNotification::class, function (NewUserNotification $notification) use ($newUser): bool {
        expect($notification)->not->toHaveProperty('password');
        expect($notification->email)->toBe($newUser->email);
        expect(Password::tokenExists($newUser, $notification->token))->toBeTrue();
        expect(Hash::check($notification->token, $newUser->password))->toBeFalse();

        return true;
    });
    Http::assertNothingSent();
});

it('rejects assigning a role outside support scope without sending an invitation', function (): void {
    Notification::fake();
    $role = Role::factory()->withPermissions([UserPermissions::Edit])->create();

    livewire(Create::class)
        ->call('loadUser')
        ->set('user', [
            'name'    => 'Elevated User',
            'email'   => 'elevated@example.com',
            'role_id' => $role->id,
        ])
        ->call('save')
        ->assertForbidden()
        ->assertNotDispatched('users::refresh')
        ->assertNotDispatched('toast');

    assertDatabaseMissing('users', ['email' => 'elevated@example.com']);
    Notification::assertNothingSent();
});

it('forbids saving directly without create permission', function (): void {
    Notification::fake();
    $role = Role::factory()->create();
    $this->user->revokePermissionTo(UserPermissions::Create);

    livewire(Create::class)
        ->set('user', [
            'name'    => 'Blocked User',
            'email'   => 'blocked@example.com',
            'role_id' => $role->id,
        ])
        ->call('save')
        ->assertNotDispatched('users::refresh')
        ->assertNotDispatched('toast')
        ->assertForbidden();

    assertDatabaseMissing('users', ['email' => 'blocked@example.com']);
    Notification::assertNothingSent();
});

it('reauthorizes saving valid data after the modal was opened', function (): void {
    Notification::fake();
    $role      = Role::factory()->create();
    $component = livewire(Create::class)
        ->call('loadUser')
        ->set('user', [
            'name'    => 'Blocked User',
            'email'   => 'blocked@example.com',
            'role_id' => $role->id,
        ]);
    $this->user->revokePermissionTo(UserPermissions::Create);

    $component->call('save')
        ->assertNotDispatched('users::refresh')
        ->assertNotDispatched('toast')
        ->assertForbidden();

    assertDatabaseMissing('users', ['email' => 'blocked@example.com']);
    Notification::assertNothingSent();
});

it('does not accept a privileged user type from form state', function (): void {
    Notification::fake();
    $role = Role::factory()->create();

    livewire(Create::class)
        ->set('user', [
            'name'    => 'Invited User',
            'email'   => 'invited@example.com',
            'role_id' => $role->id,
            'type'    => TypeUsers::Admin->value,
        ])
        ->call('save')
        ->assertHasNoErrors();

    $user = User::query()->where('email', 'invited@example.com')->sole();
    expect($user->type)->toBe(TypeUsers::User);
    Notification::assertSentTo($user, NewUserNotification::class);
});

test('name', function (int | string | null $name, string $rule): void {
    livewire(Create::class)
        ->call('loadUser')
        ->set('user.name', $name)
        ->call('save')
        ->assertHasErrors(['user.name' => $rule]);
})->with([
    [null, 'required'],
    [154, 'string'],
    [str_repeat('a', 192), 'max'],
    ['aa', 'min'],
]);

test('email', function (?string $email, string $rule): void {
    Notification::fake();
    User::factory()->create(['email' => '8YH2R@example.com']);

    livewire(Create::class)
        ->call('loadUser')
        ->set('user.email', $email)
        ->call('save')
        ->assertHasErrors(['user.email' => $rule]);

    $this->assertDatabaseCount('password_reset_tokens', 0);
    Notification::assertNothingSent();
})->with([
    [null, 'required'],
    ['aaa123', 'email'],
    [str_repeat('a', 192) . '@gmail.com', 'max'],
    ['8YH2R@example.com', 'unique'],
]);

test('role_id', function (?int $roleId, string $rule): void {
    livewire(Create::class)
        ->call('loadUser')
        ->set('user.role_id', $roleId)
        ->call('save')
        ->assertHasErrors(['user.role_id' => $rule]);
})->with([
    [null, 'required'],
    [-1, 'exists'],
]);

it('ignores a supplied password when creating an invited user', function (): void {
    Notification::fake();
    $role = Role::factory()->create();

    livewire(Create::class)
        ->set('user', [
            'name'     => 'Invited User',
            'email'    => 'password-override@example.com',
            'role_id'  => $role->id,
            'password' => 'Secret@123',
        ])
        ->call('save')
        ->assertHasNoErrors();

    $user = User::query()->where('email', 'password-override@example.com')->sole();
    expect(Hash::check('Secret@123', $user->password))->toBeFalse();
    Notification::assertSentTo($user, NewUserNotification::class);
});
