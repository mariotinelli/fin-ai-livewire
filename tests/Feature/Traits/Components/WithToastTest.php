<?php

declare(strict_types = 1);

use App\Enums\Toast;
use Livewire\Livewire;
use Tests\Feature\Support\FeedbackFixture;

it('dispatches text unchanged with the requested presentation', function (?string $description): void {
    Livewire::test(FeedbackFixture::class)
        ->set('title', '<b>Título & ação</b>')
        ->set('description', $description)
        ->call('showToast', false, true, Toast::Warning, 12)
        ->assertDispatched('toast', title: '<b>Título & ação</b>', description: $description, type: 'warning', time: 12, persistent: true);
})->with([null, '', '<img src=x onerror="window.injected=true"> &amp; "ação"']);

it('appends next page messages without dispatching or encoding their text', function (): void {
    $component = Livewire::test(FeedbackFixture::class)
        ->set('title', '<b>Primeiro & ação</b>')->call('showToast', true)
        ->set('title', 'Segundo')->set('description', '<svg onload="window.injected=true"></svg>')
        ->call('showToast', true, true, Toast::Error, 10)
        ->assertNotDispatched('toast');

    $component->assertSessionHas('toast', [
        ['title' => '<b>Primeiro & ação</b>', 'description' => null, 'type' => 'success', 'time' => 7, 'persistent' => false],
        ['title' => 'Segundo', 'description' => '<svg onload="window.injected=true"></svg>', 'type' => 'error', 'time' => 10, 'persistent' => true],
    ]);
});
