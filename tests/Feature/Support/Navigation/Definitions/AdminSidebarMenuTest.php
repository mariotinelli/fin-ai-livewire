<?php

declare(strict_types = 1);

use App\Models\Role;
use App\Models\User;
use App\Support\Navigation\Definitions\AdminSidebarMenu;

it('defines the administrative menu groups and permissions', function (): void {
    $groups = collect(new AdminSidebarMenu()->groups())->keyBy('key');

    expect($groups->keys()->all())->toBe(['primary', 'management'])
        ->and($groups['primary']->items[0]->route)->toBe('admin.dashboard')
        ->and($groups['management']->items)->toHaveCount(2)
        ->and($groups['management']->items[0]->permission->arguments)->toBe([User::class])
        ->and($groups['management']->items[1]->permission->arguments)->toBe([Role::class]);
});
