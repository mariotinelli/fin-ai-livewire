<?php

declare(strict_types = 1);

use App\Traits\Components\WithRepeater;
use Livewire\Component;
use Livewire\Livewire;

function repeaterComponent(): Component
{
    return new class () extends Component {
        use WithRepeater;

        /** @var list<array<string, mixed>> */
        public array $items = [['id' => 1, 'name' => 'Primeiro']];

        /** @var list<array{children?: list<array<string, mixed>>|null}> */
        public array $groups = [['children' => [['id' => 2, 'name' => 'Filho']]]];

        public function render(): string
        {
            return '<div></div>';
        }
    };
}

it('adds and duplicates top-level and nested repeater items', function (): void {
    $component = Livewire::test(repeaterComponent())
        ->call('setRepeaterFields', 'items', ['name'])
        ->call('setRepeaterFields', 'children', ['name'])
        ->call('addItem', 'items')
        ->call('addItem', 'groups.0.children')
        ->call('duplicateItem', 'items.0')
        ->call('duplicateItem', 'groups.0.children.0');

    $component->assertSet('items.1.name', null)
        ->assertSet('items.2.name', 'Primeiro')
        ->assertSet('groups.0.children.1.name', null)
        ->assertSet('groups.0.children.2.name', 'Filho');
    $items = $component->get('items');
    $this->assertIsArray($items);
    expect($items[2])->not->toHaveKey('id');
});

it('confirms and removes top-level and nested items while reindexing them', function (): void {
    $component = Livewire::test(repeaterComponent())
        ->call('removeItem', 'items.0')
        ->assertDispatched('alert', params: 'items.0', type: 'confirmation', method: 'confirmRemoveItem')
        ->call('confirmRemoveItem', 'items.0')
        ->call('confirmRemoveItem', 'groups.0.children.0');

    expect($component->get('items'))->toBe([])
        ->and($component->get('groups'))->toBe([['children' => []]]);
});

it('initializes a missing nested collection before adding its first item', function (): void {
    Livewire::test(repeaterComponent())
        ->set('groups', [[]])
        ->call('setRepeaterFields', 'children', ['name'])
        ->call('addItem', 'groups.0.children')
        ->assertSet('groups.0.children', [['name' => null]]);
});
