<?php

declare(strict_types = 1);

use Livewire\Component;
use Livewire\Livewire;

it('serializes dependent parameter bindings safely and supports nested properties', function (): void {
    $view = Livewire::test(new class () extends Component {
        public mixed $selection = null;

        /** @var array<string, string> */
        public array $bindings = ['region' => 'context.region', 'unsafe' => ''];

        public function render(): string
        {
            return '<x-ui.input.select-search wire:model="selection" :params="$bindings" route="/options" />';
        }
    }, ['bindings' => ['region' => 'context.region', "quote'</script>" => 'context.value']]);

    $view->assertSee('paramBindings:', false)
        ->assertSee('x-effect="syncParams', false)
        ->assertSee("\$wire.\$get('context.region')", false)
        ->assertSee('\\u003C', false)
        ->assertDontSee("quote'</script>", false);
});

it('serializes Blade values for the Alpine expression', function (): void {
    $payload = <<<'PAYLOAD'
        D'Ávila " \\ </script><script>window.rsp53Executed = true</script>
        PAYLOAD;
    $view = Livewire::test(new class () extends Component {
        public mixed $selection = null;

        public string $payload = '';

        public function render(): string
        {
            return '<x-ui.input.select-search wire:model="selection" :name="$payload" :initial-value="$payload" :default-option-label="$payload" route="/options" />';
        }
    }, ['payload' => $payload]);

    $view->assertSee('\\u0027', false)
        ->assertSee('\\u003C', false)
        ->assertDontSee("initialValue: '{$payload}'", false);
});
