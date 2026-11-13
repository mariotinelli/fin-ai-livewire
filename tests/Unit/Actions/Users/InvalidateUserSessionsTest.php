<?php

declare(strict_types = 1);

use App\Actions\Users\InvalidateUserSessions;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

beforeEach(function (): void {
    config(['session.driver' => 'database', 'session.connection' => null]);
});

it('revokes only the target users sessions and rotates their remember token', function (?string $exceptSessionId): void {
    $user  = User::factory()->create();
    $other = User::factory()->create();
    $token = $user->remember_token;
    DB::table('sessions')->insert([
        ['id' => 'current-device', 'user_id' => $user->id, 'payload' => '', 'last_activity' => time()],
        ['id' => 'old-device', 'user_id' => $user->id, 'payload' => '', 'last_activity' => time()],
        ['id' => 'unrelated-device', 'user_id' => $other->id, 'payload' => '', 'last_activity' => time()],
    ]);

    app(InvalidateUserSessions::class)->handle(user: $user, exceptSessionId: $exceptSessionId);

    expect(DB::table('sessions')->where('user_id', $user->id)->pluck('id')->all())
        ->toBe($exceptSessionId === null ? [] : ['current-device']);
    expect($user->fresh()->remember_token)->not->toBe($token)->toHaveLength(60);
    expect($other->fresh()->remember_token)->toBe($other->remember_token);
    $this->assertDatabaseHas('sessions', ['id' => 'unrelated-device', 'user_id' => $other->id]);
})->with(['all sessions' => null, 'except current session' => 'current-device']);

it('rejects unsupported session storage without rotating the token', function (string $driver, ?string $connection): void {
    $user = User::factory()->create();
    config(['session.driver' => $driver, 'session.connection' => $connection]);

    expect(fn () => app(InvalidateUserSessions::class)->handle(user: $user))
        ->toThrow(LogicException::class, 'driver database na mesma conexão');

    expect($user->fresh()->remember_token)->toBe($user->remember_token);
})->with([
    'file storage'        => ['file', null],
    'array storage'       => ['array', null],
    'redis storage'       => ['redis', null],
    'separate connection' => ['database', 'separate-sessions'],
]);

it('rolls back token rotation when deleting sessions fails', function (): void {
    $user = User::factory()->create();
    config(['session.table' => 'missing_sessions']);

    expect(fn () => app(InvalidateUserSessions::class)->handle(user: $user))->toThrow(QueryException::class);

    expect($user->fresh()->remember_token)->toBe($user->remember_token);
});
