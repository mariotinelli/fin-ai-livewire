<?php

declare(strict_types = 1);

use App\Enums\Permissions\Management\UserPermissions;
use App\Enums\Status;
use App\Enums\TypeUsers;
use App\Livewire\Admin\Management\Users\Index;
use App\Models\Role;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Features\SupportLockedProperties\CannotUpdateLockedPropertyException;
use Livewire\Livewire;

use function Pest\Livewire\livewire;

beforeEach(function (): void {
    $this->user = actingAsUser(UserPermissions::View);

    $this->roleAdmin = Role::factory()->create(['name' => 'Admin']);
    $this->roleUser  = Role::factory()->create(['name' => 'User']);

    $this->users = User::factory()
        ->count(5)
        ->sequence(
            ['name' => 'Alice', 'type' => TypeUsers::User->value, 'role_id' => $this->roleAdmin->id],
            ['name' => 'Bob', 'type' => TypeUsers::User->value, 'role_id' => $this->roleUser->id],
            ['name' => 'Charlie', 'type' => TypeUsers::User->value, 'role_id' => $this->roleUser->id],
            ['name' => 'Dave', 'type' => TypeUsers::Admin->value, 'role_id' => $this->roleAdmin->id],
            ['name' => 'Eve', 'type' => TypeUsers::User->value, 'role_id' => $this->roleAdmin->id],
        )
        ->create()
        ->sortBy('name');
});

it('can access with view users permission', function (): void {
    $this->user->revokePermissionTo(UserPermissions::View);

    livewire(Index::class)
        ->assertForbidden();

    $this->user->givePermissionTo(UserPermissions::View);

    livewire(Index::class)
        ->assertOk();
});

it('can list all users filtered by type User', function (): void {
    livewire(Index::class)
        ->assertSet('users', function (LengthAwarePaginator $paginator): bool {
            $items = collect($paginator->items());

            $types      = $items->pluck('type')->sort()->values()->toArray();
            $otherTypes = [TypeUsers::Admin->value, TypeUsers::Customer->value];

            expect($paginator->total())->toBe(5)
                ->and($types)->not->toContain($otherTypes);

            return true;
        });
});

it('can search users by name', function (): void {
    livewire(Index::class)
        ->set('search', 'Alice')
        ->assertSet('users', function (LengthAwarePaginator $paginator): bool {
            $items = collect($paginator->items());

            expect($items)->toHaveCount(1)
                ->and($items->first()->name)->toBe('Alice');

            return true;
        });
});

it('searches users without accents while retaining the selected role and active status', function (): void {
    $match = User::factory()->user()->create(['name' => 'João Silva', 'role_id' => $this->roleUser->id]);
    User::factory()->user()->create(['name' => 'João Outro', 'role_id' => $this->roleAdmin->id]);
    User::factory()->user()->create(['name' => 'João Inativo', 'role_id' => $this->roleUser->id, 'deleted_at' => now()]);

    livewire(Index::class)->set('filterDraft.roles', [$this->roleUser->id])->set('filterDraft.status', Status::Active->value)
        ->call('applyFilters')
        ->set('search', 'JOAO')
        ->assertSet('users', fn (LengthAwarePaginator $users): bool => $users->total() === 1 && $users->first()->id === $match->id);
});

it('renders the search empty state and clears the search', function (): void {
    livewire(Index::class)
        ->set('search', 'Usuário inexistente')
        ->assertSee('Nenhum usuário encontrado')
        ->assertSee('Tente ajustar a busca ou os filtros aplicados.')
        ->assertSee('Limpar busca')
        ->call('$set', 'search', '')
        ->assertDontSee('Nenhum usuário encontrado');
});

it('renders the no data empty state when there are no users', function (): void {
    actingAsAdmin();
    User::query()->where('type', TypeUsers::User)->forceDelete();

    livewire(Index::class)
        ->assertSee('Nenhum usuário cadastrado')
        ->assertSee('Os usuários cadastrados aparecerão aqui.')
        ->assertDontSee('Limpar busca');
});

it('renders the results empty state when filters match no users', function (): void {
    livewire(Index::class)
        ->set('filterDraft.roles', [PHP_INT_MAX])
        ->call('applyFilters')
        ->assertSee('Nenhum usuário encontrado')
        ->assertDontSee('Nenhum usuário cadastrado')
        ->assertDontSee('Limpar busca');
});

it('can filter users by roles', function (): void {
    livewire(Index::class)
        ->set('filterDraft.roles', [$this->roleAdmin->id])
        ->call('applyFilters')
        ->assertSet('users', function (LengthAwarePaginator $paginator): bool {
            $items = collect($paginator->items());

            $names = $items->pluck('name')->sort()->values()->toArray();

            expect($paginator->total())->toBe(2)
                ->and($names)->toMatchArray(['Alice', 'Eve']);

            return true;
        });
});

it('can filter users by status', function (): void {
    $userToDeactivate = $this->users->first();
    $userToDeactivate->delete();

    livewire(Index::class)
        ->set('filterDraft.status', Status::Deactivated->value)
        ->call('applyFilters')
        ->assertSet('users', function (LengthAwarePaginator $paginator) use ($userToDeactivate): bool {
            $items = collect($paginator->items());

            expect($paginator->total())->toBe(1)
                ->and($items->first()->id)->toBe($userToDeactivate->id);

            return true;
        });

    livewire(Index::class)
        ->set('filterDraft.status', Status::Active->value)
        ->call('applyFilters')
        ->assertSet('users', function (LengthAwarePaginator $paginator) use ($userToDeactivate): bool {
            $items = collect($paginator->items());

            expect($items->pluck('id'))->not->toContain($userToDeactivate->id);

            return true;
        });
});

it('resets user filters to their defaults', function (): void {
    livewire(Index::class)
        ->set('filterDraft.roles', [$this->roleAdmin->id])
        ->set('filterDraft.status', Status::Active->value)
        ->call('applyFilters')
        ->call('resetFilters')
        ->assertSet('filters', ['roles' => [], 'status' => Status::All->value])
        ->assertSet('filterDraft', ['roles' => [], 'status' => Status::All->value]);
});

it('keeps draft edits separate and resets only pagination when applying or clearing', function (): void {
    User::factory()->user()->count(22)->create(['name' => 'Unique person', 'role_id' => $this->roleUser->id]);
    $component = livewire(Index::class)->set('search', 'Unique')->call('sortBy', 'email')->call('setPage', 2);

    $component->set('filterDraft.roles', [$this->roleUser->id])->set('filterDraft.status', Status::Active->value)
        ->assertSet('filters', ['roles' => [], 'status' => 'all'])
        ->assertSet('paginators.page', 2)
        ->assertSet('activeFilterCount', 0)
        ->assertSet('users', fn (LengthAwarePaginator $users): bool => $users->total() === 22 && $users->currentPage() === 2)
        ->call('applyFilters')->assertHasNoErrors()
        ->assertSet('paginators.page', 1)->assertSet('activeFilterCount', 2)
        ->assertSet('filters', ['roles' => [$this->roleUser->id], 'status' => 'active'])
        ->set('filterDraft.roles', [$this->roleAdmin->id])
        ->assertSet('users', fn (LengthAwarePaginator $users): bool => $users->total() === 22)
        ->call('setPage', 2)->call('resetFilters')
        ->assertSet('paginators.page', 1)->assertSet('activeFilterCount', 0)
        ->assertSet('filterDraft', ['roles' => [], 'status' => 'all'])
        ->assertSet('filters', ['roles' => [], 'status' => 'all'])
        ->assertSet('search', 'Unique')->assertSet('sortKeyName', 'email')->assertSet('sortDirection', 'asc');
});

it('does not apply invalid drafts or reset the current page on validation failure', function (array $draft, string $error): void {
    livewire(Index::class)->call('setPage', 2)->set('filterDraft', $draft)->call('applyFilters')
        ->assertHasErrors($error)
        ->assertSet('filters', ['roles' => [], 'status' => 'all'])
        ->assertSet('paginators.page', 2)
        ->call('resetFilters')->assertHasNoErrors()
        ->assertSet('filterDraft', ['roles' => [], 'status' => 'all']);
})->with([
    [['roles' => [], 'status' => 'invalid'], 'filterDraft.status'],
    [['roles' => 'invalid', 'status' => 'all'], 'filterDraft.roles'],
    [['roles' => ['unexpected' => 1], 'status' => 'all'], 'filterDraft.roles'],
    [['roles' => ['1 OR 1=1'], 'status' => 'all'], 'filterDraft.roles.0'],
    [['roles' => [-1], 'status' => 'all'], 'filterDraft.roles.0'],
    [['roles' => [], 'status' => 'all', 'unexpected' => true], 'filterDraft'],
]);

it('prevents modifying the applied state directly from the client', function (): void {
    expect(fn () => livewire(Index::class)->set('filters.roles', [$this->roleUser->id]))
        ->toThrow(CannotUpdateLockedPropertyException::class);
});

it('reauthorizes filter actions after access is revoked', function (string $action): void {
    $component = livewire(Index::class)->set('filterDraft.status', Status::Active->value);
    $this->user->revokePermissionTo(UserPermissions::View);

    $component->call($action)->assertForbidden();
})->with(['applyFilters', 'resetFilters']);

it('shows resend only for an eligible recipient and authorized editor', function (): void {
    actingAsAdmin();
    $pending   = User::factory()->user()->create(['invitation_pending' => true]);
    $completed = User::factory()->user()->create(['invitation_pending' => false]);
    $inactive  = User::factory()->user()->create(['invitation_pending' => true, 'deleted_at' => now()]);

    livewire(Index::class)
        ->assertSeeHtml('id="resend-user-invitation-button-' . $pending->id . '"')
        ->assertDontSeeHtml('id="resend-user-invitation-button-' . $completed->id . '"')
        ->assertDontSeeHtml('id="resend-user-invitation-button-' . $inactive->id . '"');

    actingAsUser(UserPermissions::View);
    livewire(Index::class)->assertDontSeeHtml('id="resend-user-invitation-button-' . $pending->id . '"');
});

it('keeps user scopes and applied filters when changing the page size', function (): void {
    User::factory()->user()->count(26)->create(['role_id' => $this->roleUser->id, 'name' => 'Paginated user']);
    User::factory()->admin()->create(['role_id' => $this->roleUser->id, 'name' => 'Paginated admin']);
    User::factory()->user()->create(['role_id' => $this->roleAdmin->id, 'name' => 'Paginated other role']);

    $component = livewire(Index::class)
        ->set('search', 'Paginated')
        ->set('filterDraft.roles', [$this->roleUser->id])
        ->call('applyFilters')
        ->call('sortBy', 'name')
        ->call('setPage', 2)
        ->set('perPage', '25')
        ->assertSet('perPage', 25)
        ->assertSet('paginators.page', 1)
        ->assertSet('users', fn (LengthAwarePaginator $users): bool => $users->total() === 26 && $users->count() === 25)
        ->call('nextPage')
        ->assertSet('users', fn (LengthAwarePaginator $users): bool => $users->currentPage() === 2 && $users->count() === 1)
        ->set('perPage', ['invalid'])
        ->assertSet('perPage', 10)
        ->assertSet('paginators.page', 1)
        ->assertSet('search', 'Paginated')
        ->assertSet('filters.roles', [$this->roleUser->id])
        ->assertSet('sortKeyName', 'name');

    $instance          = $component->instance();
    $instance->perPage = PHP_INT_MAX;
    unset($instance->users);
    expect($instance->users->perPage())->toBe(10);
    expect($instance->users->total())->toBe(26);
});

it('does not let clients enlarge the allowed page sizes', function (): void {
    expect(fn () => livewire(Index::class)->set('perPageValues', [0, 1000000]))
        ->toThrow(CannotUpdateLockedPropertyException::class);
});

it('does not query records when the applied state is invalid', function (array $applied): void {

    $instance              = livewire(Index::class)->instance();
    $instance->filterDraft = ['roles' => [], 'status' => 'all'];
    $instance->search      = 'retained';
    $instance->filters     = $applied;
    $instance->addError('unrelated', 'Retained validation error');
    unset($instance->users);
    DB::enableQueryLog();
    DB::flushQueryLog();

    try {
        $records = $instance->users;
        expect(DB::getQueryLog())->toBeEmpty();
        expect($records->total())->toBe(0);
        expect($records->perPage())->toBe(10);
        expect($instance->getErrorBag()->first('filters'))->toBe('Os filtros aplicados são inválidos. Limpe ou aplique filtros válidos para continuar.');
        expect($instance->getErrorBag()->first('unrelated'))->toBe('Retained validation error');
        expect($instance->filterDraft)->toBe(['roles' => [], 'status' => 'all']);
        expect($instance->filters)->toBe($applied);
        expect($instance->search)->toBe('retained');
    } finally {
        DB::disableQueryLog();
    }
})->with([
    'invalid status' => [['roles' => [], 'status' => 'invalid']],
    'array status'   => [['roles' => [], 'status' => []]],
    'invalid role'   => [['roles' => ['1 OR 1=1'], 'status' => 'all']],
    'nested roles'   => [['roles' => [[1]], 'status' => 'all']],
    'missing keys'   => [[]],
    'unexpected key' => [['roles' => [], 'status' => 'all', 'extra' => true]],
]);

it('renders invalid applied filters safely and recovers after clearing them', function (): void {

    $component = livewire(Index::class)->set('search', 'retained');
    $stop      = Livewire::listen('hydrate', function (Component $instance): void {
        if ($instance instanceof Index) {
            $instance->filters = [];
        }
    });

    try {
        $component->call('$refresh')->assertOk()->assertHasErrors('filters')
            ->assertSee('Consulta não executada')->assertSee('Os filtros aplicados são inválidos.')
            ->assertSet('filterDraft', ['roles' => [], 'status' => 'all'])->assertSet('search', 'retained');
    } finally {
        $stop();
    }

    $component->call('resetFilters')->assertOk()->assertHasNoErrors('filters')
        ->assertSet('filters', ['roles' => [], 'status' => 'all'])->assertSet('search', 'retained');
});
