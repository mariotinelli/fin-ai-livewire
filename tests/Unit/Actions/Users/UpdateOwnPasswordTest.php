<?php

declare(strict_types = 1);

use App\Actions\Users\UpdateOwnPassword;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

beforeEach(function (): void {
    config(['session.driver' => 'database', 'session.connection' => null]);
});

it('rolls back password and token when session deletion fails', function (): void {
    $user       = User::factory()->create(['password' => 'OldPass@123']);
    $attributes = $user->fresh()->getAttributes();
    DB::table('sessions')->insert(['id' => 'old-device', 'user_id' => $user->id, 'payload' => '', 'last_activity' => time()]);
    config(['session.table' => 'missing_sessions']);

    expect(fn () => app(UpdateOwnPassword::class)->handle(
        user: $user,
        currentPassword: 'OldPass@123',
        password: 'NewPass@123',
        currentSessionId: 'current-device',
    ))->toThrow(QueryException::class);

    expect($user->fresh()->getAttributes())->toBe($attributes);
    $this->assertDatabaseHas('sessions', ['id' => 'old-device', 'user_id' => $user->id]);
});

it('checks the persisted password when the caller holds an outdated user', function (): void {
    $user        = User::factory()->create(['password' => 'OldPass@123']);
    $currentUser = User::findOrFail($user->id);
    $currentUser->update(['password' => 'ChangedPass@123']);

    $attributes = $currentUser->getAttributes();

    expect(fn () => app(UpdateOwnPassword::class)->handle(
        user: $user,
        currentPassword: 'OldPass@123',
        password: 'NewPass@123',
        currentSessionId: 'current-device',
    ))->toThrow(ValidationException::class);

    expect($user->fresh()->getAttributes())->toBe($attributes);
});

it('does not change credentials when session storage is unsupported', function (): void {
    $user       = User::factory()->create(['password' => 'OldPass@123']);
    $attributes = $user->fresh()->getAttributes();
    config(['session.driver' => 'file']);

    expect(fn () => app(UpdateOwnPassword::class)->handle(
        user: $user,
        currentPassword: 'OldPass@123',
        password: 'NewPass@123',
        currentSessionId: 'current-device',
    ))->toThrow(LogicException::class);

    expect($user->fresh()->getAttributes())->toBe($attributes);
});
