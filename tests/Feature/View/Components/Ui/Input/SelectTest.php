<?php

declare(strict_types = 1);

use Livewire\Component;
use Livewire\Livewire;

it('serializes Blade values for the Alpine expression', function (): void {
    $payload = <<<'PAYLOAD'
        D'Ávila " \\ </script><script>window.rsp53Executed = true</script>
        PAYLOAD;
    $view = Livewire::test(new class () extends Component {
        public mixed $selection = null;

        public string $payload = '';

        public function render(): string
        {
            return '<x-ui.input.select wire:model="selection" :name="$payload" :initial-value="$payload" :default-option-label="$payload" />';
        }
    }, ['payload' => $payload]);

    $view->assertSee('\\u0027', false)
        ->assertSee('\\u003C', false)
        ->assertDontSee("initialValue: '{$payload}'", false);
});
