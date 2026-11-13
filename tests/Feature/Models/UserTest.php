<?php

declare(strict_types = 1);

use App\Enums\Status;
use App\Enums\TypeUsers;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;

it('compares full names without accents or case while preserving distinct users', function (): void {
    $first  = User::factory()->create(['name' => 'João Conceição']);
    $second = User::factory()->create(['name' => 'JOAO CONCEICAO']);
    User::factory()->create(['name' => 'João Conceição Silva']);

    expect(User::query()->where('name', 'joao conceicao')->orderBy('id')->pluck('id')->all())
        ->toBe([$first->id, $second->id]);
    expect($first->fresh()->name)->toBe('João Conceição');
});

it('orders names without accents or case with an explicit tie breaker', function (): void {
    $first  = User::factory()->create(['name' => 'Álvaro']);
    $second = User::factory()->create(['name' => 'alvaro']);
    $third  = User::factory()->create(['name' => 'Bruno']);

    expect(User::query()->orderBy('name')->orderBy('id')->pluck('id')->all())
        ->toBe([$first->id, $second->id, $third->id]);
});

it('keeps insensitive name and email alternatives inside filters and soft delete constraints', function (string $term): void {
    $role    = Role::factory()->create();
    $byName  = User::factory()->user()->create(['role_id' => $role->id, 'name' => 'João Silva', 'email' => 'name-match@example.com']);
    $byEmail = User::factory()->user()->create(['role_id' => $role->id, 'name' => 'Maria', 'email' => 'joao@example.com']);
    User::factory()->user()->create(['name' => 'Outro perfil', 'email' => 'joao.outro@example.com']);
    User::factory()->admin()->create(['role_id' => $role->id, 'email' => 'joao.admin@example.com']);
    $deleted = User::factory()->user()->create(['role_id' => $role->id, 'email' => 'joao.deleted@example.com']);
    $deleted->delete();

    expect(User::query()->where('type', TypeUsers::User)->where('role_id', $role->id)->search($term)->orderBy('id')->pluck('id')->all())
        ->toBe([$byName->id, $byEmail->id]);
    expect(User::onlyTrashed()->where('type', TypeUsers::User)->where('role_id', $role->id)->search($term)->pluck('id')->all())
        ->toBe([$deleted->id]);
})->with(['joao', 'JOÃO']);

it('does not ignore a zero search term', function (): void {
    $match = User::factory()->user()->create(['name' => 'Pessoa 0', 'email' => 'zero@example.com']);
    User::factory()->user()->create(['name' => 'Outra pessoa', 'email' => 'outra@example.com']);

    expect(User::query()->search('0')->pluck('id')->all())->toBe([$match->id]);
});

it('returns initials accessor using first two characters uppercase', function (): void {
    $user = User::factory()->create([
        'name' => 'maria silva',
    ]);

    expect($user->initials)->toBe('MA');
});

it('returns formatted name accessor', function (): void {
    $user = User::factory()->create([
        'name' => 'Joao Souza',
    ]);

    expect($user->formatted_name)->toBe('Joao Souza');
});

it('filters users by search scope on name and email', function (): void {
    $matchedByName = User::factory()->create(['name' => 'Carlos Pereira', 'email' => 'carlos@example.com']);
    $matchedByMail = User::factory()->create(['name' => 'Ana Paula', 'email' => 'ana.match@example.com']);
    $notMatched    = User::factory()->create(['name' => 'Bruno Costa', 'email' => 'bruno@example.com']);

    $users = User::query()->search('match')->get();

    expect($users->pluck('id')->all())
        ->toContain($matchedByMail->id)
        ->not->toContain($matchedByName->id, $notMatched->id);

    $usersByName = User::query()->search('Carlos')->get();

    expect($usersByName->pluck('id')->all())
        ->toContain($matchedByName->id)
        ->not->toContain($matchedByMail->id, $notMatched->id);
});

it('returns true only when user type is admin', function (): void {
    $admin = User::factory()->create(['type' => TypeUsers::Admin]);
    $user  = User::factory()->create(['type' => TypeUsers::User]);

    expect($admin->isAdmin())->toBeTrue()
        ->and($user->isAdmin())->toBeFalse();
});

it('identifies each application user type', function (): void {
    expect(User::factory()->make(['type' => TypeUsers::Customer])->isCustomer())->toBeTrue()
        ->and(User::factory()->make(['type' => TypeUsers::User])->isUser())->toBeTrue()
        ->and(User::factory()->make(['type' => TypeUsers::SupportRemSoft])->isSupportRemSoft())->toBeTrue();
});

it('filters trashed users through an aliased table', function (): void {
    $active  = User::factory()->create();
    $deleted = User::factory()->create();
    $deleted->delete();

    $ids       = User::query()->from('users as members')->filterByTrashed(Status::All)->pluck('members.id')->all();
    $activeIds = User::query()->filterByTrashed(Status::Active)->pluck('users.id')->all();

    expect($ids)->toContain($active->id, $deleted->id)
        ->and($activeIds)->toContain($active->id)->not->toContain($deleted->id);
});

it('returns only administrators', function (): void {
    $admin = User::factory()->admin()->create();
    User::factory()->user()->create();

    $admins = User::query()->admins()->get();

    expect($admins)->toHaveCount(1)
        ->and($admins->sole()->is($admin))->toBeTrue();
});

it('audits user creation without persisting credentials', function (): void {
    config(['audit.enabled' => true, 'audit.console' => true, 'audit.queue.enable' => true, 'audit.queue.connection' => 'sync']);

    $user = User::factory()->create([
        'name'           => 'Audited User',
        'email'          => 'audited.creation@example.com',
        'password'       => 'CreationSentinel@123',
        'remember_token' => 'creation-remember-sentinel',
    ]);

    $audit = $user->audits()->where('event', 'created')->sole();

    expect($audit->new_values)->toMatchArray([
        'name'  => 'Audited User',
        'email' => 'audited.creation@example.com',
    ]);

    foreach ([$audit->old_values, $audit->new_values] as $values) {
        expect($values)->not->toHaveKey('password')->not->toHaveKey('remember_token');
        expect(json_encode($values, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES))
            ->not->toContain('CreationSentinel@123', $user->password, 'creation-remember-sentinel');
    }
});

it('audits name and email changes without persisting old or new credentials', function (): void {
    config(['audit.enabled' => true, 'audit.console' => true, 'audit.queue.enable' => true, 'audit.queue.connection' => 'sync']);
    Notification::fake();
    $user = User::factory()->create([
        'name'           => 'Before Audit',
        'email'          => 'before.audit@example.com',
        'password'       => 'OldPasswordSentinel@123',
        'remember_token' => 'old-remember-sentinel',
    ]);
    $oldHash = $user->password;

    $user->update([
        'name'           => 'After Audit',
        'email'          => 'after.audit@example.com',
        'password'       => 'NewPasswordSentinel@456',
        'remember_token' => 'new-remember-sentinel',
    ]);

    $audit = $user->audits()->where('event', 'updated')->sole();

    expect($audit->old_values)->toMatchArray(['name' => 'Before Audit', 'email' => 'before.audit@example.com']);
    expect($audit->new_values)->toMatchArray(['name' => 'After Audit', 'email' => 'after.audit@example.com']);

    foreach ([$audit->old_values, $audit->new_values] as $values) {
        expect($values)->not->toHaveKey('password')->not->toHaveKey('remember_token');
        expect(json_encode($values, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES))->not->toContain(
            'OldPasswordSentinel@123',
            'NewPasswordSentinel@456',
            $oldHash,
            $user->password,
            'old-remember-sentinel',
            'new-remember-sentinel',
        );
    }
});

it('uses the local notification model while preserving native unread relationships', function (): void {
    $user         = User::factory()->create();
    $notification = $user->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => [], 'viewed_at' => now()]);

    expect($notification)->toBeInstanceOf(App\Models\Notification::class);
    expect($notification->fresh()->viewed_at)->toBeInstanceOf(Carbon::class);
    expect($user->unreadNotifications()->count())->toBe(1);
});
