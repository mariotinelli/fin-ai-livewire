<?php

declare(strict_types = 1);

use App\Enums\TypeUsers;
use App\Livewire\Sidebar;
use App\Models\User;
use App\Support\Navigation\SidebarGroup;

use function Pest\Livewire\livewire;

it('renders the sidebar with the visible groups for an administrator', function (): void {
    actingAsAdmin();

    livewire(Sidebar::class)
        ->assertSee('Dashboard')
        ->assertSet('mobileItems', fn (array $items): bool => array_column($items, 'route') === ['admin.dashboard', 'admin.management.users.index', 'admin.management.roles.index'])
        ->assertSee('Gestão')
        ->assertSee('Usuários')
        ->assertSee('Perfis')
        ->assertSet('groups', function (array $groups): bool {
            $routes = collect($groups)
                ->flatMap(fn (SidebarGroup $group): array => collect($group->items)->pluck('route')->all());

            expect($routes)->toContain('admin.dashboard')
                ->toContain('admin.management.users.index')
                ->toContain('admin.management.roles.index');

            return true;
        })
        ->assertOk();
});

it('renders only the support menu for a support user', function (): void {
    $support = User::factory()->create([
        'role_id' => null,
        'type'    => TypeUsers::SupportRemSoft,
    ]);

    $this->actingAs($support);

    livewire(Sidebar::class)
        ->assertSee('Suporte')
        ->assertSet('mobileItems', fn (array $items): bool => array_column($items, 'route') === ['support.artisan-commands.index', 'support.system-error-alerts.index'])
        ->assertSee('Alertas de Erro')
        ->assertDontSee('Dashboard')
        ->assertSee('Comandos')
        ->assertSet('groups', function (array $groups): bool {
            $routes = collect($groups)
                ->flatMap(fn (SidebarGroup $group): array => collect($group->items)->pluck('route')->all())
                ->values()
                ->all();

            expect($routes)->toBe(['support.artisan-commands.index', 'support.system-error-alerts.index']);

            return true;
        })
        ->assertOk();
});

it('does not expose menu groups to guests', function (): void {
    livewire(Sidebar::class)
        ->assertSet('groups', [])
        ->assertSet('mobileItems', [])
        ->assertOk();
});

it('does not render unauthorized items even when the browser remembers their groups', function (): void {
    actingAsUser();

    livewire(Sidebar::class)
        ->assertSee('Dashboard')
        ->assertSet('mobileItems', fn (array $items): bool => array_column($items, 'route') === ['admin.dashboard'])
        ->assertDontSee('admin.management.users.index')
        ->assertDontSee('sidebar-link-desktop-admin-management-users-index', false)
        ->assertDontSee('group-desktop-management', false)
        ->assertDontSee('group-mobile-management', false)
        ->assertOk();
});

it('keeps the customer mobile destinations isolated from administrative and support menus', function (): void {
    $this->actingAs(User::factory()->customer()->create());

    livewire(Sidebar::class)
        ->assertSet('mobileItems', fn (array $items): bool => array_column($items, 'route') === ['customer.dashboard'])
        ->assertDontSee('Gestão')
        ->assertDontSee('Suporte')
        ->assertOk();
});
