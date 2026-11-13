<?php

declare(strict_types = 1);

use App\Enums\Permissions\Management\RolePermissions;
use App\Enums\Permissions\Management\UserPermissions;
use App\Enums\TypeUsers;
use App\Models\User;
use App\Support\Navigation\SidebarGroup;
use App\Support\Navigation\SidebarMenuBuilder;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('renders the admin login and redirects the legacy login URL', function (): void {
    get('/admin/login')->assertSuccessful();
    get('/login')->assertRedirect('/admin/login');
});

it('keeps management navigation and direct access aligned with view permissions', function (string $routeName, UserPermissions | RolePermissions $permission): void {
    $user = actingAsUser();

    get(route($routeName))->assertForbidden();
    expect(collect(app(SidebarMenuBuilder::class)->buildFor($user))
        ->flatMap(fn (SidebarGroup $group): array => $group->items)->pluck('route')->all())
        ->not->toContain($routeName);

    $user->givePermissionTo($permission);

    get(route($routeName))->assertSuccessful();
    expect(collect(app(SidebarMenuBuilder::class)->buildFor($user))
        ->flatMap(fn (SidebarGroup $group): array => $group->items)->pluck('route')->all())
        ->toContain($routeName);
})->with([
    'users' => ['admin.management.users.index', UserPermissions::View],
    'roles' => ['admin.management.roles.index', RolePermissions::View],
]);

it('allows direct support access for the responsible user type', function (string $routeName, TypeUsers $type): void {
    config(['artisan-executor.allowed_ips' => ['127.0.0.1']]);
    actingAs(User::factory()->create(['type' => $type]));

    get(route($routeName))->assertSuccessful();
})->with([
    'commands' => ['support.artisan-commands.index', TypeUsers::SupportRemSoft],
    'alerts'   => ['support.system-error-alerts.index', TypeUsers::SupportRemSoft],
]);

it('forbids direct support access for an unauthorized user type', function (string $routeName, TypeUsers $type): void {
    config(['artisan-executor.allowed_ips' => ['127.0.0.1']]);
    actingAs(User::factory()->create(['type' => $type]));

    get(route($routeName))->assertForbidden();
})->with([
    'commands' => ['support.artisan-commands.index', TypeUsers::Admin],
    'alerts'   => ['support.system-error-alerts.index', TypeUsers::Admin],
]);

it('redirects guests from the admin area to the admin login', function (): void {
    get('/admin/dashboard')->assertRedirect(route('admin.login'));
});

it('allows authenticated admin area user types', function (TypeUsers $type): void {
    actingAs(User::factory()->create(['type' => $type]));

    get('/admin/dashboard')->assertSuccessful();
})->with([
    'admin' => TypeUsers::Admin,
    'user'  => TypeUsers::User,
]);

it('forbids authenticated customers from the admin area', function (): void {
    actingAs(User::factory()->customer()->create());

    get('/admin/dashboard')->assertForbidden();
});

it('redirects authenticated users away from the admin login according to their access', function (): void {
    actingAs(User::factory()->admin()->create());
    get('/admin/login')->assertRedirect(route('admin.dashboard'));

    auth()->logout();

    actingAs(User::factory()->customer()->create());
    get('/admin/login')->assertRedirect(route('customer.dashboard'));
});
