<?php

declare(strict_types = 1);

use App\Actions\Users\CreateUser;
use App\Enums\TypeUsers;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

use function Pest\Laravel\assertDatabaseHas;

it('rejects invalid user type strings before persisting an account', function (string $type): void {
    expect(fn () => app(CreateUser::class)->handle(
        userData: ['name' => 'Invalid Type', 'email' => 'invalid-type@example.test', 'type' => $type],
        password: 'Secret@123',
    ))->toThrow(ValueError::class);

    $this->assertDatabaseMissing('users', ['email' => 'invalid-type@example.test']);
})->with(['2invalid', '999']);

it('creates user with provided password and role', function (): void {
    $role = Role::factory()->create();

    $user = app(CreateUser::class)->handle(
        userData: [
            'name'    => 'John Doe',
            'email'   => 'john.doe.task@example.com',
            'type'    => TypeUsers::User,
            'role_id' => $role->id,
        ],
        password: 'Secret@123',
    );

    expect($user->name)->toBe('John Doe')
        ->and($user->fresh()->invitation_pending)->toBeFalse()
        ->and($user->email)->toBe('john.doe.task@example.com')
        ->and($user->type)->toBe(TypeUsers::User)
        ->and($user->role_id)->toBe($role->id)
        ->and(Hash::check('Secret@123', $user->password))->toBeTrue();

    assertDatabaseHas('users', [
        'id'      => $user->id,
        'name'    => 'John Doe',
        'email'   => 'john.doe.task@example.com',
        'type'    => TypeUsers::User->value,
        'role_id' => $role->id,
    ]);
});

it('creates a customer with null role', function (): void {
    $user = app(CreateUser::class)->handle(
        userData: [
            'name'  => 'Mary Smith',
            'email' => 'mary.smith.task@example.com',
            'type'  => TypeUsers::Customer,
        ],
        password: 'Admin@123',
    );

    expect($user->name)->toBe('Mary Smith')
        ->and($user->email)->toBe('mary.smith.task@example.com')
        ->and($user->type)->toBe(TypeUsers::Customer)
        ->and($user->role_id)->toBeNull()
        ->and(Hash::check('Admin@123', $user->password))->toBeTrue();

    assertDatabaseHas('users', [
        'id'      => $user->id,
        'name'    => 'Mary Smith',
        'email'   => 'mary.smith.task@example.com',
        'type'    => TypeUsers::Customer->value,
        'role_id' => null,
    ]);
});

it('accepts a backed user type value for customer self-registration', function (): void {
    $user = app(CreateUser::class)->handle(
        userData: ['name' => 'Scalar Customer', 'email' => 'scalar@example.com', 'type' => TypeUsers::Customer->value],
        password: 'Secret@123',
    );

    expect($user->type)->toBe(TypeUsers::Customer);
});

it('returns a user without serializing the supplied password', function (): void {
    $user = app(CreateUser::class)->handle(
        userData: ['name' => 'Sensitive User', 'email' => 'sensitive@example.com', 'type' => TypeUsers::User],
        password: 'Sensitive@123',
    );

    expect(Hash::check('Sensitive@123', $user->password))->toBeTrue();
    expect($user->toArray())->not->toHaveKey('password');
    expect($user->toJson())->not->toContain('Sensitive@123');
});
