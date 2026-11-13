<?php

declare(strict_types = 1);

use App\Services\Notifications\DatabaseNotification;

it('builds notification payload with helper methods', function (): void {
    $notification = new DatabaseNotification()
        ->success()
        ->icon('check')
        ->title('Done')
        ->description('Everything worked')
        ->details(['id' => 10])
        ->actionButton('Open', '/dashboard');

    expect($notification->toArray())->toBe([
        'color'       => 'border-green-600',
        'icon'        => 'check',
        'title'       => 'Done',
        'description' => 'Everything worked',
        'details'     => ['id' => 10],
        'route'       => ['action' => 'Open', 'url' => '/dashboard'],
    ]);
});

it('sets each severity color correctly', function (): void {
    expect(new DatabaseNotification()->error()->color)->toBe('border-red-600')
        ->and(new DatabaseNotification()->info()->color)->toBe('border-sky-800')
        ->and(new DatabaseNotification()->warning()->color)->toBe('border-yellow-600');
});

it('returns empty array when no fields are set', function (): void {
    expect(new DatabaseNotification()->toArray())->toBeEmpty();
});
