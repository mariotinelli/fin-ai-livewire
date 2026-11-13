<?php

declare(strict_types = 1);

use App\Support\Navigation\Definitions\BaseSidebarMenu;

it('defines the dashboard route as the primary menu', function (): void {
    $groups = new BaseSidebarMenu('dashboard')->groups();

    expect($groups)->toHaveCount(1)
        ->and($groups[0]->key)->toBe('primary')
        ->and($groups[0]->label)->toBeNull()
        ->and($groups[0]->items)->toHaveCount(1)
        ->and($groups[0]->items[0]->route)->toBe('dashboard');
});
