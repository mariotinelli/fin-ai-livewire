<?php

declare(strict_types = 1);

use App\Enums\TypeUsers;
use App\Livewire\Notifications\History;
use App\Models\User;
use Illuminate\Pagination\Cursor;
use Illuminate\Support\Facades\DB;
use Livewire\Features\SupportLockedProperties\CannotUpdateLockedPropertyException;

use function Pest\Livewire\livewire;

beforeEach(function (): void {
    $this->user = actingAsUser();
    config(['notifications.per_page' => 2]);
});

it('keeps cursor traversal stable after insertion and deletion including timestamp ties', function (): void {
    $date = now()->startOfSecond();

    foreach (range(1, 6) as $number) {
        $this->user->notifications()->create([
            'id'   => sprintf('00000000-0000-4000-8000-%012d', $number), 'type' => 'test',
            'data' => ['title' => 'Notification ' . $number], 'created_at' => $date,
        ]);
    }

    $other = User::factory()->create();
    $other->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => ['title' => 'Foreign']]);
    $component = livewire(History::class)->assertSee('Notification 6')->assertDontSee('Foreign');
    $first     = $component->get('batches')[0];
    expect($first)->toBe([sprintf('00000000-0000-4000-8000-%012d', 6), sprintf('00000000-0000-4000-8000-%012d', 5)]);
    $this->user->notifications()->whereKey($first[1])->delete();
    $this->user->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => ['title' => 'New top'], 'created_at' => $date->copy()->addSecond()]);
    $component->call('loadMore')->call('loadMore')->assertSet('hasMore', false);
    $ids = array_merge(...$component->get('batches'));
    expect($ids)->toHaveCount(6)->and(array_unique($ids))->toHaveCount(6);
    expect(array_slice($ids, 2))->toBe(array_map(fn (int $number): string => sprintf('00000000-0000-4000-8000-%012d', $number), [4, 3, 2, 1]));
});

it('only queries the next batch and stops querying at the end', function (): void {
    foreach (range(1, 5) as $number) {
        $this->user->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => ['title' => 'Item ' . $number], 'created_at' => now()->subMinutes($number)]);
    }

    $component = livewire(History::class);
    $first     = $component->get('batches')[0];
    DB::enableQueryLog();
    DB::flushQueryLog();
    $component->call('loadMore');
    $queries = collect(DB::getQueryLog())->filter(fn (array $query): bool => str_contains($query['query'], 'notifications'));
    DB::disableQueryLog();
    expect($queries)->toHaveCount(2);
    expect($queries->first()['query'])->toContain('limit 3')->not->toContain('offset');
    expect($queries->flatMap(fn (array $query): array => $query['bindings'])->all())->not->toContain($first[0]);
    $component->call('loadMore')->assertSet('hasMore', false);
    DB::enableQueryLog();
    DB::flushQueryLog();
    $component->call('loadMore');
    $queries = collect(DB::getQueryLog())->filter(fn (array $query): bool => str_contains($query['query'], 'notifications'));
    DB::disableQueryLog();
    expect($queries)->toBeEmpty();
});

it('clears empty history after deletion and can explicitly restart for new notifications', function (): void {
    $note      = $this->user->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => ['title' => 'Before']]);
    $component = livewire(History::class);
    $note->delete();
    $component->dispatch('notifications::updated')->assertSet('batches', [])->assertSet('hasMore', false)->assertSee('Sem notificações');
    $new = $this->user->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => ['title' => 'After']]);
    $component->call('restartHistory')->assertSee('After')->assertSet('revision', 1);
    expect($component->get('batches'))->toBe([[$new->id]]);
});

it('protects cursor batch IDs and completion state from client updates', function (string $field, mixed $value): void {
    $component = livewire(History::class);
    expect(fn () => $component->set($field, $value))->toThrow(CannotUpdateLockedPropertyException::class);
})->with([['nextCursor', 'forged'], ['batches', [['foreign']]], ['hasMore', true], ['revision', 7]]);

it('requires authentication', function (): void {
    auth()->logout();
    livewire(History::class)->assertUnauthorized();
});

it('bounds each batch using the configured limit', function (): void {
    config(['notifications.per_page' => 10000]);

    foreach (range(1, 102) as $number) {
        $this->user->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => ['title' => 'Item ' . $number]]);
    }

    $component = livewire(History::class);
    expect($component->get('batches')[0])->toHaveCount(100);
    $component->assertSet('hasMore', true);
});

it('serves each user type own history in its localized area and ignores URL cursors', function (TypeUsers $type): void {
    $user = User::factory()->create(['type' => $type, 'role_id' => null]);
    $this->actingAs($user);
    $own     = $user->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => ['title' => 'Own history']]);
    $foreign = $this->user->notifications()->create(['id' => fake()->uuid(), 'type' => 'test', 'data' => ['title' => 'Foreign history']]);
    $cursor  = new Cursor(['created_at' => now()->subYear()->toDateTimeString(), 'id' => fake()->uuid()], true);

    $response = $this->get(route($type->notificationHistoryRouteName(), ['cursor' => $cursor->encode()]))->assertOk();
    $html     = new DOMDocument();
    @$html->loadHTML($response->getContent());
    $rows = new DOMXPath($html)->query('//*[@data-notification-history]//*[@data-notification-id]');
    expect($rows)->toHaveCount(1);
    expect($rows->item(0)->getAttribute('data-notification-id'))->toBe($own->id);
})->with(TypeUsers::cases());
