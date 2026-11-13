<?php

declare(strict_types = 1);

use App\Enums\Permissions\Management\RolePermissions;
use App\Livewire\Admin\Management\Roles\Index;
use App\Models\Role;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

use function Pest\Livewire\livewire;

beforeEach(function (): void {
    actingAsUser(RolePermissions::View);
});

it('searches role names without accents and treats wildcards literally', function (string $term, string $name): void {
    $role = Role::factory()->create(['name' => $name]);

    livewire(Index::class)->set('search', $term)
        ->assertSet('roles', fn (LengthAwarePaginator $roles): bool => $roles->total() === 1 && $roles->first()->id === $role->id);
})->with([
    ['gestao', 'Gestão'], ['GESTÃO', 'Gestão'], ['%', 'Perfil 50%'], ['0', 'Perfil 0'],
]);

it('can access with view roles permission', function (): void {
    $user = actingAsUser(RolePermissions::View);
    $user->revokePermissionTo(RolePermissions::View);

    livewire(Index::class)
        ->assertForbidden();

    $user->givePermissionTo(RolePermissions::View);

    livewire(Index::class)
        ->assertOk();
});

it('can list all roles', function (): void {
    $roles = Role::factory()
        ->count(3)
        ->create()
        ->sortByDesc('id');

    livewire(Index::class)
        ->assertSet('roles', function (LengthAwarePaginator $data) use ($roles): true {
            expect($data)
                ->toHaveCount(3 + 1) // +1 for the default role
                ->first()->name->toBe($roles->first()->name);

            return true;
        });
});

it('can search role by name', function (): void {
    $roles = Role::factory()
        ->count(2)
        ->sequence(
            ['name' => 'Administrator'],
            ['name' => 'Cliente'],
        )
        ->create();

    livewire(Index::class)
        ->set('search', 'Administrator')
        ->assertSet('roles', function (LengthAwarePaginator $data) use ($roles): true {
            expect($data)
                ->toHaveCount(1)
                ->first()->name->toBe($roles->first()->name);

            return true;
        });
});

it('renders the search empty state and clears the search', function (): void {
    livewire(Index::class)
        ->set('search', 'Perfil inexistente')
        ->assertSee('Nenhum perfil encontrado')
        ->assertSee('Tente buscar por outro nome de perfil.')
        ->assertSee('Limpar busca')
        ->call('$set', 'search', '')
        ->assertDontSee('Nenhum perfil encontrado');
});

it('renders the no data empty state when there are no roles', function (): void {
    $admin = actingAsAdmin();
    User::query()->whereKeyNot($admin->id)->forceDelete();
    Role::query()->each(function (Role $role): void {
        $role->syncPermissions([]);
    });
    Role::query()->delete();

    livewire(Index::class)
        ->assertSee('Nenhum perfil cadastrado')
        ->assertSee('Os perfis cadastrados aparecerão aqui.')
        ->assertDontSee('Limpar busca');
});

it('bounds page size at the query and resets the page when the size changes', function (): void {
    foreach (range(1, 26) as $number) {
        Role::factory()->create(['name' => 'Page sized role ' . $number]);
    }

    $component = livewire(Index::class)
        ->set('search', 'Page sized role')
        ->assertSet('perPage', 10)
        ->call('setPage', 2)
        ->set('perPage', '25')
        ->assertSet('perPage', 25)
        ->assertSet('paginators.page', 1)
        ->assertSet('roles', fn (LengthAwarePaginator $records): bool => $records->perPage() === 25 && $records->count() === 25)
        ->call('nextPage')
        ->assertSet('roles', fn (LengthAwarePaginator $records): bool => $records->currentPage() === 2 && $records->count() === 1)
        ->set('perPage', 0)
        ->assertSet('perPage', 10)
        ->assertSet('paginators.page', 1);

    $instance          = $component->instance();
    $instance->perPage = 1000000;
    unset($instance->roles);
    expect($instance->roles->perPage())->toBe(10);
    expect($instance->roles->count())->toBe(10);
});
