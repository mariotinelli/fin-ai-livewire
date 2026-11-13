<?php

declare(strict_types = 1);

use Livewire\Component;
use Livewire\Livewire;

it('only enables immediate synchronization for an explicit live modifier', function (string $binding, bool $live): void {
    $component = Livewire::test(new class () extends Component {
        public string $selection = '';

        public string $binding = '';

        public function render(): string
        {
            return '<x-ui.input.autocomplete ' . $this->binding . '="selection" route="/options" />';
        }
    }, ['binding' => $binding]);

    $component->assertSee('isLive: ' . ($live ? 'true' : 'false'), false);
})->with([
    ['wire:model', false],
    ['wire:model.defer', false],
    ['wire:model.blur', false],
    ['wire:model.live', true],
    ['wire:model.live.debounce.300ms', true],
]);

it('serializes Blade values for the Alpine expression', function (): void {
    $payload = <<<'PAYLOAD'
        D'Ávila " \\ </script><script>window.rsp53Executed = true</script>
        PAYLOAD;
    $view = Livewire::test(new class () extends Component {
        public string $selection = '';

        public string $payload = '';

        public function render(): string
        {
            return '<x-ui.input.autocomplete wire:model="selection" :name="$payload" route="/options" />';
        }
    }, ['payload' => $payload]);

    $view->assertSee('\\u0027', false)
        ->assertSee('\\u003C', false)
        ->assertDontSee("name: '{$payload}'", false);
});
