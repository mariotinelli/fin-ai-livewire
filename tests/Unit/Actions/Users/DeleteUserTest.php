<?php

declare(strict_types = 1);

use App\Actions\Users\DeleteUser;
use App\Enums\TypeUsers;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;

beforeEach(function (): void {
    config(['session.driver' => 'database', 'session.connection' => null]);
});

it('deactivates a user and revokes every session without affecting other accounts', function (): void {
    $actor = User::factory()->admin()->create();
    $user  = User::factory()->user()->create();
    DB::table('sessions')->insert([
        ['id' => 'first-device', 'user_id' => $user->id, 'payload' => '', 'last_activity' => time()],
        ['id' => 'second-device', 'user_id' => $user->id, 'payload' => '', 'last_activity' => time()],
        ['id' => 'actor-device', 'user_id' => $actor->id, 'payload' => '', 'last_activity' => time()],
    ]);

    app(DeleteUser::class)->handle(actor: $actor, user: $user);

    $this->assertSoftDeleted($user);
    expect($user->fresh()->remember_token)->not->toBe($user->remember_token);
    expect($actor->fresh()->remember_token)->toBe($actor->remember_token);
    $this->assertDatabaseMissing('sessions', ['user_id' => $user->id]);
    $this->assertDatabaseHas('sessions', ['id' => 'actor-device', 'user_id' => $actor->id]);
});

it('authorizes the explicit actor instead of the authenticated administrator', function (): void {
    actingAsAdmin();
    $actor      = User::factory()->user()->create();
    $user       = User::factory()->user()->create();
    $attributes = $user->fresh()->getAttributes();
    DB::table('sessions')->insert(['id' => 'existing-device', 'user_id' => $user->id, 'payload' => '', 'last_activity' => time()]);

    expect(fn () => app(DeleteUser::class)->handle(actor: $actor, user: $user))->toThrow(AuthorizationException::class);

    expect($user->fresh()->getAttributes())->toBe($attributes);
    $this->assertDatabaseHas('sessions', ['id' => 'existing-device', 'user_id' => $user->id]);
});

it('uses the current target type when the caller holds an outdated user', function (): void {
    $actor = User::factory()->admin()->create();
    $user  = User::factory()->user()->create();
    User::whereKey($user->id)->update(['type' => TypeUsers::Admin]);
    $attributes = $user->fresh()->getAttributes();

    expect(fn () => app(DeleteUser::class)->handle(actor: $actor, user: $user))->toThrow(AuthorizationException::class);

    expect($user->fresh()->getAttributes())->toBe($attributes);
});

it('rejects an actor who was deactivated after being loaded', function (): void {
    $actor = User::factory()->admin()->create();
    $user  = User::factory()->user()->create();
    User::whereKey($actor->id)->delete();
    $attributes = $user->fresh()->getAttributes();

    expect(fn () => app(DeleteUser::class)->handle(actor: $actor, user: $user))->toThrow(ModelNotFoundException::class);

    expect($user->fresh()->getAttributes())->toBe($attributes);
});

it('rolls back credentials sessions and deactivation when persistence fails', function (string $failure): void {
    $actor      = User::factory()->admin()->create();
    $user       = User::factory()->user()->create();
    $attributes = $user->fresh()->getAttributes();
    DB::table('sessions')->insert(['id' => 'existing-device', 'user_id' => $user->id, 'payload' => '', 'last_activity' => time()]);
    DB::listen(function (QueryExecuted $query) use ($failure): void {
        $sql    = strtolower($query->sql);
        $failed = $failure === 'sessions'
            ? str_contains($sql, 'delete from') && str_contains($sql, 'sessions')
            : str_contains($sql, 'update') && str_contains($sql, 'users') && str_contains($sql, 'deleted_at');

        if ($failed) {
            throw new RuntimeException('Deactivation persistence failure');
        }
    });

    expect(fn () => app(DeleteUser::class)->handle(actor: $actor, user: $user))
        ->toThrow(RuntimeException::class, 'Deactivation persistence failure');

    expect($user->fresh()->getAttributes())->toBe($attributes);
    $this->assertDatabaseHas('sessions', ['id' => 'existing-device', 'user_id' => $user->id]);
})->with(['session deletion' => 'sessions', 'soft deletion' => 'user']);

it('restores sessions and token when a model event cancels deactivation', function (): void {
    $actor      = User::factory()->admin()->create();
    $user       = User::factory()->user()->create();
    $attributes = $user->fresh()->getAttributes();
    DB::table('sessions')->insert(['id' => 'existing-device', 'user_id' => $user->id, 'payload' => '', 'last_activity' => time()]);
    User::deleting(fn (User $user): bool => false);

    expect(fn () => app(DeleteUser::class)->handle(actor: $actor, user: $user))
        ->toThrow(RuntimeException::class, 'Não foi possível desativar o usuário.');

    expect($user->fresh()->getAttributes())->toBe($attributes);
    $this->assertDatabaseHas('sessions', ['id' => 'existing-device', 'user_id' => $user->id]);
});
