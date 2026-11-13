<?php

declare(strict_types = 1);

use App\Livewire\Notifications\HistoryBatch;
use App\Models\User;
use Livewire\Features\SupportLockedProperties\CannotUpdateLockedPropertyException;

use function Pest\Livewire\livewire;

it('loads only owned active IDs and keeps the selection protected', function (): void {
    $user    = actingAsUser();
    $other   = User::factory()->create();
    $own     = $user->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => ['title' => 'Own']]);
    $foreign = $other->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => ['title' => 'Foreign']]);
    $deleted = $user->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => ['title' => 'Deleted']]);
    $deleted->delete();

    $component = livewire(HistoryBatch::class, ['notificationIds' => [$own->id, $foreign->id, $deleted->id]])
        ->assertSee('Own')->assertDontSee('Foreign')->assertDontSee('Deleted');
    expect($component->get('batchNotifications')->pluck('id')->all())->toBe([$own->id]);
    expect(fn () => $component->set('notificationIds', [$foreign->id]))->toThrow(CannotUpdateLockedPropertyException::class);
});

it('marks visible batch items viewed and refreshes the central without reading them', function (): void {
    $user = actingAsUser();
    $note = $user->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => ['title' => 'View']]);
    livewire(HistoryBatch::class, ['notificationIds' => [$note->id]])->call('markViewed', [$note->id])
        ->assertReturned(true)->assertDispatched('notifications::updated');
    expect($note->fresh()->viewed_at)->not->toBeNull()->and($note->fresh()->read_at)->toBeNull();
});
