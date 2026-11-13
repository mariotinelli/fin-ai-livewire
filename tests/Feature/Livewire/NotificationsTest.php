<?php

declare(strict_types = 1);

use App\Livewire\Notifications;
use App\Models\Notification as DatabaseNotification;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

use function Pest\Livewire\livewire;

beforeEach(function (): void {
    $this->user = actingAsUser();
});

it('can render the component', function (): void {
    livewire(Notifications::class)
        ->assertSet('sidepageOpen', false)
        ->assertOk();
});

it('can open and close sidepage', function (): void {
    livewire(Notifications::class)
        ->call('openSidepage')
        ->assertSet('sidepageOpen', true)
        ->call('closeSidepage')
        ->assertSet('sidepageOpen', false);
});

it('defers rendering notification contents until requested from the open panel', function (): void {
    $this->user->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => ['title' => 'Deferred content']]);

    livewire(Notifications::class)
        ->assertDontSee('Deferred content')
        ->call('loadNotifications')->assertSet('notificationsLoaded', false)
        ->set('sidepageOpen', true)->assertDontSee('Deferred content')
        ->call('loadNotifications')->assertSet('notificationsLoaded', true)->assertSee('Deferred content')
        ->set('sidepageOpen', false)->assertDontSee('Deferred content');
});

it('lists notifications for the authenticated user', function (): void {
    $otherUser = User::factory()->create();

    foreach (range(1, 3) as $i) {
        DatabaseNotification::create([
            'id'              => fake()->uuid(),
            'type'            => 'App\Notifications\TestNotification',
            'notifiable_type' => User::class,
            'notifiable_id'   => $this->user->id,
            'data'            => ['title' => 'Test', 'body' => 'Body'],
        ]);
    }

    foreach (range(1, 2) as $i) {
        DatabaseNotification::create([
            'id'              => fake()->uuid(),
            'type'            => 'App\Notifications\TestNotification',
            'notifiable_type' => User::class,
            'notifiable_id'   => $otherUser->id,
            'data'            => ['title' => 'Test', 'body' => 'Body'],
        ]);
    }

    livewire(Notifications::class)
        ->assertSet('notifications', function (Paginator $notifications): bool {
            expect($notifications)->toHaveCount(3)
                ->and($notifications->every(fn (DatabaseNotification $notification): bool => $notification->notifiable_id === user()->id))->toBeTrue();

            return true;
        });
});

it('counts only unread notifications', function (): void {
    foreach (range(1, 3) as $i) {
        DatabaseNotification::create([
            'id'              => fake()->uuid(),
            'type'            => 'App\Notifications\TestNotification',
            'notifiable_type' => User::class,
            'notifiable_id'   => $this->user->id,
            'data'            => ['title' => 'Test', 'body' => 'Body'],
            'read_at'         => null,
        ]);
    }

    foreach (range(1, 2) as $i) {
        DatabaseNotification::create([
            'id'              => fake()->uuid(),
            'type'            => 'App\Notifications\TestNotification',
            'notifiable_type' => User::class,
            'notifiable_id'   => $this->user->id,
            'data'            => ['title' => 'Test', 'body' => 'Body'],
            'read_at'         => now(),
        ]);
    }

    livewire(Notifications::class)
        ->assertSet('unreadNotificationsCount', 3);
});

it('can mark all notifications as read', function (): void {
    foreach (range(1, 5) as $i) {
        DatabaseNotification::create([
            'id'              => fake()->uuid(),
            'type'            => 'App\Notifications\TestNotification',
            'notifiable_type' => User::class,
            'notifiable_id'   => $this->user->id,
            'data'            => ['title' => 'Test', 'body' => 'Body'],
            'read_at'         => null,
        ]);
    }

    expect($this->user->unreadNotifications()->count())->toBe(5);

    livewire(Notifications::class)
        ->call('markAllAsRead')
        ->assertDispatched('notifications::updated');

    expect($this->user->fresh()->unreadNotifications()->count())->toBe(0);
});

it('can delete a specific notification', function (): void {
    $notifications = collect();

    foreach (range(1, 3) as $i) {
        $notifications->push(DatabaseNotification::create([
            'id'              => fake()->uuid(),
            'type'            => 'App\Notifications\TestNotification',
            'notifiable_type' => User::class,
            'notifiable_id'   => $this->user->id,
            'data'            => ['title' => 'Test', 'body' => 'Body'],
        ]));
    }

    $notificationToDelete = $notifications->first();

    livewire(Notifications::class)
        ->call('delete', $notificationToDelete->id)
        ->assertDispatched('notifications::updated');

    expect($this->user->fresh()->notifications()->count())->toBe(2)
        ->and(DatabaseNotification::find($notificationToDelete->id))->toBeNull();
});

it('cannot delete notification from another user', function (): void {
    $otherUser = User::factory()->create();

    $notification = DatabaseNotification::create([
        'id'              => fake()->uuid(),
        'type'            => 'App\Notifications\TestNotification',
        'notifiable_type' => User::class,
        'notifiable_id'   => $otherUser->id,
        'data'            => ['title' => 'Test', 'body' => 'Body'],
    ]);

    livewire(Notifications::class)
        ->call('delete', $notification->id)
        ->assertNotFound();

    expect(DatabaseNotification::find($notification->id))->not->toBeNull();
});

it('can delete all notifications', function (): void {
    foreach (range(1, 5) as $i) {
        DatabaseNotification::create([
            'id'              => fake()->uuid(),
            'type'            => 'App\Notifications\TestNotification',
            'notifiable_type' => User::class,
            'notifiable_id'   => $this->user->id,
            'data'            => ['title' => 'Test', 'body' => 'Body'],
        ]);
    }

    expect($this->user->notifications()->count())->toBe(5);

    $component = livewire(Notifications::class)->call('deleteAll')->assertDispatched('alert');
    expect($this->user->notifications()->count())->toBe(5);
    $component->call('confirmDeleteAll', $component->get('clearConfirmation'))->assertDispatched('notifications::updated');

    expect($this->user->fresh()->notifications()->count())->toBe(0);
});

it('does not delete notifications from other users when deleting all', function (): void {
    $otherUser = User::factory()->create();

    foreach (range(1, 3) as $i) {
        DatabaseNotification::create([
            'id'              => fake()->uuid(),
            'type'            => 'App\Notifications\TestNotification',
            'notifiable_type' => User::class,
            'notifiable_id'   => $this->user->id,
            'data'            => ['title' => 'Test', 'body' => 'Body'],
        ]);
    }

    foreach (range(1, 2) as $i) {
        DatabaseNotification::create([
            'id'              => fake()->uuid(),
            'type'            => 'App\Notifications\TestNotification',
            'notifiable_type' => User::class,
            'notifiable_id'   => $otherUser->id,
            'data'            => ['title' => 'Test', 'body' => 'Body'],
        ]);
    }

    $component = livewire(Notifications::class)->call('deleteAll');
    $component->call('confirmDeleteAll', $component->get('clearConfirmation'));

    expect($this->user->fresh()->notifications()->count())->toBe(0)
        ->and($otherUser->fresh()->notifications()->count())->toBe(2);
});

it('dispatches notifications::updated event when marking all as read', function (): void {
    foreach (range(1, 3) as $i) {
        DatabaseNotification::create([
            'id'              => fake()->uuid(),
            'type'            => 'App\Notifications\TestNotification',
            'notifiable_type' => User::class,
            'notifiable_id'   => $this->user->id,
            'data'            => ['title' => 'Test', 'body' => 'Body'],
            'read_at'         => null,
        ]);
    }

    livewire(Notifications::class)
        ->call('markAllAsRead')
        ->assertDispatched('notifications::updated');
});

it('dispatches notifications::updated event when deleting all', function (): void {
    foreach (range(1, 3) as $i) {
        DatabaseNotification::create([
            'id'              => fake()->uuid(),
            'type'            => 'App\Notifications\TestNotification',
            'notifiable_type' => User::class,
            'notifiable_id'   => $this->user->id,
            'data'            => ['title' => 'Test', 'body' => 'Body'],
        ]);
    }

    $component = livewire(Notifications::class)->call('deleteAll');
    $component->call('confirmDeleteAll', $component->get('clearConfirmation'))->assertDispatched('notifications::updated');
});

it('dispatches notifications::updated event when deleting a specific notification', function (): void {
    $notification = DatabaseNotification::create([
        'id'              => fake()->uuid(),
        'type'            => 'App\Notifications\TestNotification',
        'notifiable_type' => User::class,
        'notifiable_id'   => $this->user->id,
        'data'            => ['title' => 'Test', 'body' => 'Body'],
    ]);

    livewire(Notifications::class)
        ->call('delete', $notification->id)
        ->assertDispatched('notifications::updated');
});

it('orders notifications by latest first', function (): void {
    $oldNotification = DatabaseNotification::create([
        'id'              => fake()->uuid(),
        'type'            => 'App\Notifications\TestNotification',
        'notifiable_type' => User::class,
        'notifiable_id'   => $this->user->id,
        'data'            => ['title' => 'Test', 'body' => 'Body'],
        'created_at'      => now()->subDays(2),
    ]);

    $recentNotification = DatabaseNotification::create([
        'id'              => fake()->uuid(),
        'type'            => 'App\Notifications\TestNotification',
        'notifiable_type' => User::class,
        'notifiable_id'   => $this->user->id,
        'data'            => ['title' => 'Test', 'body' => 'Body'],
        'created_at'      => now(),
    ]);

    $midNotification = DatabaseNotification::create([
        'id'              => fake()->uuid(),
        'type'            => 'App\Notifications\TestNotification',
        'notifiable_type' => User::class,
        'notifiable_id'   => $this->user->id,
        'data'            => ['title' => 'Test', 'body' => 'Body'],
        'created_at'      => now()->subDay(),
    ]);

    livewire(Notifications::class)
        ->assertSet('notifications', function (Paginator $notifications) use ($recentNotification, $midNotification, $oldNotification): bool {
            $ids = $notifications->pluck('id')->toArray();

            expect($ids)->toBe([
                $recentNotification->id,
                $midNotification->id,
                $oldNotification->id,
            ]);

            return true;
        });
});

it('handles empty notifications list', function (): void {
    livewire(Notifications::class)
        ->assertSet('notifications', function (Paginator $notifications): bool {
            expect($notifications)->toBeEmpty();

            return true;
        })
        ->assertSet('unreadNotificationsCount', 0);
});

it('responds to notifications::updated event', function (): void {
    foreach (range(1, 2) as $i) {
        DatabaseNotification::create([
            'id'              => fake()->uuid(),
            'type'            => 'App\Notifications\TestNotification',
            'notifiable_type' => User::class,
            'notifiable_id'   => $this->user->id,
            'data'            => ['title' => 'Test', 'body' => 'Body'],
        ]);
    }

    livewire(Notifications::class)
        ->assertSet('notifications', function (Paginator $notifications): bool {
            expect($notifications)->toHaveCount(2);

            return true;
        })
        ->dispatch('notifications::updated')
        ->assertOk();
});

it('paginates only the current users notifications with stable ordering', function (): void {
    config(['notifications.per_page' => 2]);
    $this->freezeTime();
    $otherUser = User::factory()->create();
    $otherUser->notifications()->create([
        'id'   => fake()->uuid(),
        'type' => 'test',
        'data' => ['title' => 'Private notification'],
    ]);
    $ids = [];

    foreach (range(1, 5) as $number) {
        $ids[] = $this->user->notifications()->create([
            'id'   => fake()->uuid(),
            'type' => 'test',
            'data' => ['title' => "Notification {$number}"],
        ])->id;
    }

    rsort($ids);

    $component = livewire(Notifications::class)
        ->assertSet('unreadNotificationsCount', 5)
        ->assertDontSee('Private notification');
    expect($component->get('notifications')->pluck('id')->all())->toBe(array_slice($ids, 0, 2));

    $component->call('nextPage', 'notificationsPage')->assertDontSee('Private notification');
    expect($component->get('notifications')->pluck('id')->all())->toBe(array_slice($ids, 2, 2));

    $component->call('nextPage', 'notificationsPage')->assertDontSee('Private notification');
    expect($component->get('notifications')->pluck('id')->all())->toBe(array_slice($ids, 4));
    expect($component->get('notifications')->hasMorePages())->toBeFalse();

    $component->call('previousPage', 'notificationsPage');
    expect($component->get('notifications')->pluck('id')->all())->toBe(array_slice($ids, 2, 2));
});

it('bounds configured page sizes and ignores client supplied table volume', function (mixed $configured, int $expected): void {
    config(['notifications.per_page' => $configured]);

    livewire(Notifications::class)
        ->set('perPage', 1000000)
        ->assertSet('notifications', fn (Paginator $notifications): bool => $notifications->perPage() === $expected);
})->with([
    'default'   => [20, 20],
    'custom'    => [7, 7],
    'zero'      => [0, 1],
    'negative'  => [-1, 1],
    'excessive' => [1000000, 100],
    'invalid'   => ['invalid', 1],
]);

it('returns to the first page after deleting the last item or clearing history', function (string $action, int $remaining): void {
    config(['notifications.per_page' => 1]);

    foreach (range(1, 2) as $number) {
        $this->user->notifications()->create([
            'id'   => fake()->uuid(),
            'type' => 'test',
            'data' => ['title' => "Notification {$number}"],
        ]);
    }

    $component      = livewire(Notifications::class)->call('nextPage', 'notificationsPage');
    $notificationId = $component->get('notifications')->first()->id;

    if ($action === 'deleteAll') {
        $component->call('deleteAll');
        $component->call('confirmDeleteAll', $component->get('clearConfirmation'));
    } else {
        $component->call('delete', $notificationId);
    }

    $component->assertSet('paginators.notificationsPage', 1)->assertDispatched('notifications::updated');

    $this->assertSoftDeleted('notifications', ['id' => $notificationId]);
    $this->assertDatabaseCount('notifications', 2);
    expect($this->user->notifications()->count())->toBe($remaining);
    $component->assertSet('unreadNotificationsCount', $remaining);
})->with([['delete', 1], ['deleteAll', 0]]);

it('marks unread history across pages without changing other users or already read timestamps', function (): void {
    config(['notifications.per_page' => 1]);
    $this->freezeTime();
    $otherUser = User::factory()->create();
    $foreign   = $otherUser->notifications()->create([
        'id' => fake()->uuid(), 'type' => 'test', 'data' => ['title' => 'Private'],
    ]);
    $read = $this->user->notifications()->create([
        'id' => fake()->uuid(), 'type' => 'test', 'data' => ['title' => 'Read'], 'read_at' => now()->subDay(),
    ]);

    foreach (range(1, 3) as $number) {
        $this->user->notifications()->create([
            'id' => fake()->uuid(), 'type' => 'test', 'data' => ['title' => "Unread {$number}"],
        ]);
    }

    livewire(Notifications::class)->call('nextPage', 'notificationsPage')
        ->call('markAllAsRead')->assertSet('unreadNotificationsCount', 0);

    expect($this->user->unreadNotifications()->count())->toBe(0);
    expect($foreign->fresh()->read_at)->toBeNull();
    expect($read->fresh()->read_at->toDateTimeString())->toBe(now()->subDay()->toDateTimeString());
});

it('handles a nonexistent notification deletion without changing history', function (): void {
    livewire(Notifications::class)->call('delete', fake()->uuid())
        ->assertNotFound();
    $this->assertDatabaseCount('notifications', 0);
});

it('rejects guests before loading notifications', function (): void {
    auth()->logout();

    livewire(Notifications::class)->assertUnauthorized();
});

it('rejects notification actions after the session expires', function (string $action): void {
    $notification = $this->user->notifications()->create([
        'id' => fake()->uuid(), 'type' => 'test', 'data' => ['title' => 'Unread'],
    ]);
    $component = livewire(Notifications::class);
    auth()->logout();

    $component->call($action, $notification->id)->assertUnauthorized();

    $this->assertModelExists($notification);
    expect($notification->fresh()->read_at)->toBeNull();
})->with(['markAllAsRead', 'delete', 'deleteAll']);

it('keeps navigation available when another request empties the current page', function (): void {
    config(['notifications.per_page' => 1]);

    foreach (range(1, 2) as $number) {
        $this->user->notifications()->create([
            'id' => fake()->uuid(), 'type' => 'test', 'data' => ['title' => "Notification {$number}"],
        ]);
    }

    $component = livewire(Notifications::class)->set('sidepageOpen', true)->call('loadNotifications')->call('nextPage', 'notificationsPage');
    $component->get('notifications')->first()->delete();

    $component->dispatch('notifications::updated')->assertSee('Anterior')
        ->call('previousPage', 'notificationsPage');

    expect($component->get('notifications'))->toHaveCount(1);
});

it('limits query volume with a thousand fake notifications and preserves old history', function (): void {
    $this->freezeTime();
    $rows = [];

    foreach (range(1, 1000) as $number) {
        $rows[] = [
            'id'              => fake()->uuid(), 'type' => 'test',
            'notifiable_type' => $this->user->getMorphClass(), 'notifiable_id' => $this->user->id,
            'data'            => json_encode(['title' => "Notification {$number}", 'description' => str_repeat('x', 1024)], JSON_THROW_ON_ERROR),
            'read_at'         => $number % 2 === 0 ? now() : null,
            'created_at'      => now()->subYears(2), 'updated_at' => now()->subYears(2),
        ];
    }

    foreach (array_chunk($rows, 100) as $chunk) {
        DB::table('notifications')->insert($chunk);
    }

    $hydrated = 0;
    DatabaseNotification::retrieved(function () use (&$hydrated): void {
        $hydrated++;
    });
    DB::enableQueryLog();
    DB::flushQueryLog();
    $this->user->notifications()->latest()->get();
    $this->user->unreadNotifications()->get();
    $beforeQueries  = count(DB::getQueryLog());
    $beforeHydrated = $hydrated;
    $hydrated       = 0;
    DB::flushQueryLog();

    $component = livewire(Notifications::class);

    $queries = collect(DB::getQueryLog())->filter(fn (array $query): bool => preg_match('/from [`"]notifications[`"]/i', $query['query']) === 1);
    DB::disableQueryLog();
    expect($beforeQueries)->toBe(2);
    expect($beforeHydrated)->toBe(1500);
    expect($hydrated)->toBe(0);
    expect($queries->count())->toBe(1);
    expect($queries->pluck('query')->implode(' '))->toContain('count(*)')->not->toContain('limit 21');

    $component->assertSet('unreadNotificationsCount', 500);
    expect($component->get('notifications'))->toHaveCount(20);
    $this->assertDatabaseCount('notifications', 1000);
});

it('marks a valid viewed batch without reading it', function (): void {
    $notification = $this->user->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => ['title' => 'Viewed only']]);
    livewire(Notifications::class)->call('markViewed', [$notification->id])->assertHasNoErrors()->assertReturned(true)->assertSet('unviewedNotificationsCount', 0);
    expect($notification->fresh()->viewed_at)->not->toBeNull()->and($notification->fresh()->read_at)->toBeNull();
});

it('rejects invalid viewed batches before mutating notifications', function (mixed $ids, string $field, string $rule): void {
    livewire(Notifications::class)->call('markViewed', $ids)->assertHasErrors([$field => $rule]);
})->with([
    'empty'        => [[], 'notificationIds', 'required'],
    'scalar'       => ['invalid', 'notificationIds', 'array'],
    'associative'  => [['key' => 'value'], 'notificationIds', 'list'],
    'invalid UUID' => [['invalid'], 'notificationIds.0', 'uuid'],
    'duplicate'    => [['a018f421-852f-4b8d-a358-abb18b6771ec', 'a018f421-852f-4b8d-a358-abb18b6771ec'], 'notificationIds.0', 'distinct'],
    'oversized'    => [array_map(fn (int $number): string => sprintf('00000000-0000-4000-8000-%012d', $number), range(1, 101)), 'notificationIds', 'max'],
]);

it('rejects foreign notification IDs when marking viewed or read', function (): void {
    $other   = User::factory()->create();
    $foreign = $other->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => ['title' => 'Foreign']]);
    livewire(Notifications::class)->call('markViewed', [$foreign->id])->assertHasErrors('notificationIds');
    livewire(Notifications::class)->call('markAsRead', $foreign->id)->assertNotFound();
    expect($foreign->fresh()->read_at)->toBeNull()->and($foreign->fresh()->viewed_at)->toBeNull();
});

it('reads one notification explicitly and keeps other owned notifications unread', function (): void {
    $first  = $this->user->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => ['title' => 'Read me']]);
    $second = $this->user->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => ['title' => 'Still unread']]);
    livewire(Notifications::class)->call('markAsRead', $first->id)->assertHasNoErrors();
    expect($first->fresh()->read_at)->not->toBeNull()->and($first->fresh()->viewed_at)->not->toBeNull();
    expect($second->fresh()->read_at)->toBeNull();
});

it('cancels bulk clearing without changing notifications and rejects reused confirmation tokens', function (): void {
    $note      = $this->user->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => ['title' => 'Keep']]);
    $component = livewire(Notifications::class)->call('deleteAll')->assertDispatched('alert', method: 'confirmDeleteAll');
    $token     = $component->get('clearConfirmation');
    $component->call('cancelDeleteAll')->assertSet('clearConfirmation', null);
    expect($note->fresh()->deleted_at)->toBeNull();
    $component->call('confirmDeleteAll', $token)->assertForbidden();
});

it('clears only the owner after confirmation and does not let a token clear newly arriving notifications', function (): void {
    $other     = User::factory()->create();
    $own       = $this->user->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => ['title' => 'Own']]);
    $foreign   = $other->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => ['title' => 'Foreign']]);
    $component = livewire(Notifications::class)->call('deleteAll');
    $token     = $component->get('clearConfirmation');
    $component->set('sidepageOpen', true)->call('loadNotifications')->call('confirmDeleteAll', $token)->assertReturned(true)->assertSee('Sem notificações');
    $this->assertSoftDeleted($own);
    expect($foreign->fresh()->deleted_at)->toBeNull();
    $new = $this->user->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => ['title' => 'New']]);
    $component->call('confirmDeleteAll', $token)->assertForbidden();
    expect($new->fresh()->deleted_at)->toBeNull();
});

it('keeps deleted notifications out of reading and viewing mutations', function (): void {
    $note = $this->user->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => ['title' => 'Deleted']]);
    $note->delete();

    livewire(Notifications::class)->call('markAllAsRead');
    expect($note->fresh()->read_at)->toBeNull()->and($note->fresh()->viewed_at)->toBeNull();
    livewire(Notifications::class)->call('markViewed', [$note->id])->assertHasErrors('notificationIds');
    livewire(Notifications::class)->call('markAsRead', $note->id)->assertNotFound();
});

it('preserves old deletion timestamps and can roll a confirmed clear back', function (): void {
    $older     = $this->user->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => ['title' => 'Old'], 'deleted_at' => now()->subDay()]);
    $own       = $this->user->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => ['title' => 'Active']]);
    $oldDate   = $older->deleted_at;
    $component = livewire(Notifications::class)->call('deleteAll');
    DB::beginTransaction();
    $component->call('confirmDeleteAll', $component->get('clearConfirmation'));
    $this->assertSoftDeleted($own);
    expect($older->fresh()->deleted_at)->toEqual($oldDate);
    DB::rollBack();
    expect($own->fresh()->deleted_at)->toBeNull();
});
