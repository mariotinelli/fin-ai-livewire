<?php

declare(strict_types = 1);

use App\Traits\Components\WithLoading;
use Livewire\Component;
use Livewire\Livewire;

it('dispatches the visible loading state', function (): void {
    $component = new class () extends Component {
        use WithLoading;

        public function render(): string
        {
            return '<div></div>';
        }
    };

    Livewire::test($component)
        ->call('showLoading')->assertDispatched('toggle-loading', loading: true)
        ->call('hideLoading')->assertDispatched('toggle-loading', loading: false);
});
