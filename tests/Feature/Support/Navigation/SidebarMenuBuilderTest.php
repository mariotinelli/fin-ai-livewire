<?php

declare(strict_types = 1);

use App\Enums\TypeUsers;
use App\Models\User;
use App\Support\Navigation\SidebarGroup;
use App\Support\Navigation\SidebarMenuBuilder;

it('does not build navigation for a guest', function (): void {
    expect(app(SidebarMenuBuilder::class)->buildFor(null))->toBeEmpty();
});

it('builds the customer dashboard menu', function (): void {
    $customer = User::factory()->customer()->create();

    expect(sidebarRoutesFor($customer))->toBe(['customer.dashboard']);
});

it('builds the support menu without administrative routes', function (): void {
    $support = User::factory()->create([
        'role_id' => null,
        'type'    => TypeUsers::SupportRemSoft,
    ]);

    expect(sidebarRoutesFor($support))
        ->toBe(['support.artisan-commands.index', 'support.system-error-alerts.index'])
        ->not->toContain('admin.dashboard');
});

it('filters unauthorized items and empty groups from the internal user menu', function (): void {
    $user = User::factory()->user()->create();

    expect(sidebarRoutesFor($user))->toBe(['admin.dashboard']);
});

it('builds all permitted administrative items for an administrator', function (): void {
    $admin = User::factory()->admin()->create();

    expect(sidebarRoutesFor($admin))->toBe([
        'admin.dashboard',
        'admin.management.users.index',
        'admin.management.roles.index',
    ]);
});

/**
 * @return array<int, string>
 */
function sidebarRoutesFor(User $user): array
{
    return collect(app(SidebarMenuBuilder::class)->buildFor($user))
        ->flatMap(fn (SidebarGroup $group): array => collect($group->items)->pluck('route')->all())
        ->values()
        ->all();
}
