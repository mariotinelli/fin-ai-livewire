<?php

declare(strict_types = 1);

use App\Models\CommandExecution;
use App\Models\SystemErrorAlert;
use App\Support\Navigation\Definitions\SupportRemSoftSidebarMenu;

it('defines the support menu with its authorization requirement', function (): void {
    $groups = new SupportRemSoftSidebarMenu()->groups();

    expect($groups)->toHaveCount(1)
        ->and($groups[0]->key)->toBe('support')
        ->and($groups[0]->label)->toBe('Suporte')
        ->and($groups[0]->items)->toHaveCount(2)
        ->and($groups[0]->items[0]->route)->toBe('support.artisan-commands.index')
        ->and($groups[0]->items[0]->permission->arguments)->toBe([CommandExecution::class])
        ->and($groups[0]->items[1]->route)->toBe('support.system-error-alerts.index')
        ->and($groups[0]->items[1]->permission->arguments)->toBe([SystemErrorAlert::class]);
});
