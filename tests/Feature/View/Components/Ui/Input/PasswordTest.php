<?php

declare(strict_types = 1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ViewErrorBag;
use Livewire\Component;
use Livewire\Livewire;

it('scopes optional loading disable and never toggles an originally disabled control', function (bool $block, bool $disabled): void {
    $view = Livewire::test(new class () extends Component {
        public mixed $value = '';

        public bool $block = false;

        public bool $disabled = false;

        public function render(): string
        {
            return '<x-ui.input.password id="field" wire:model="value" :disable-while-loading="$block" :disabled="$disabled" wire:target="save" />';
        }
    }, ['block' => $block, 'disabled' => $disabled]);
    $document = new DOMDocument();
    @$document->loadHTML('<?xml encoding="UTF-8">' . $view->html());
    $controls = new DOMXPath($document)->query('//*[@id="field"] | //button[not(ancestor::template) and not(@x-ref="button")]');

    expect($controls->length)->toBe(2);

    foreach ($controls as $control) {
        if (!$control instanceof DOMElement) {
            throw new LogicException('A consulta deve retornar controles HTML.');
        }

        expect($control->hasAttribute('disabled'))->toBe($disabled)
            ->and($control->hasAttribute('wire:loading.attr'))->toBe($block && !$disabled)
            ->and($control->getAttribute('wire:target'))->toBe('save');
    }
})->with([false, true])->with([false, true]);

beforeEach(function (): void {
    View::share('errors', new ViewErrorBag());
});

it('preserves input attributes and gives the toggle a contextual accessible name', function (): void {
    $html     = Blade::render('<x-ui.input.password wire:model.live="password" label="Nova senha" autocomplete="new-password" required />');
    $document = new DOMDocument();
    @$document->loadHTML('<?xml encoding="UTF-8">' . $html);
    $input  = $document->getElementsByTagName('input')->item(0);
    $button = $document->getElementsByTagName('button')->item(0);

    expect($input->getAttribute('wire:model.live'))->toBe('password')
        ->and($input->getAttribute('name'))->toBe('password')
        ->and($input->getAttribute('autocomplete'))->toBe('new-password')
        ->and($input->getAttribute('type'))->toBe('password')
        ->and($input->hasAttribute('required'))->toBeTrue();
    expect($button->getAttribute('type'))->toBe('button')
        ->and($button->getAttribute('aria-label'))->toBe('Mostrar senha: Nova senha')
        ->and($button->getAttribute('aria-controls'))->toBe($input->getAttribute('id'))
        ->and($button->getAttribute('aria-pressed'))->toBe('false');
});

it('renders disabled consistently and generates distinct controls for unnamed inputs', function (bool $disabled): void {
    $html     = Blade::render('<x-ui.input.password :disabled="$disabled" /><x-ui.input.password id="confirmation" aria-label="Confirmação" />', ['disabled' => $disabled]);
    $document = new DOMDocument();
    @$document->loadHTML('<?xml encoding="UTF-8">' . $html);
    $inputs  = $document->getElementsByTagName('input');
    $buttons = $document->getElementsByTagName('button');

    expect($inputs->item(0)->hasAttribute('disabled'))->toBe($disabled)
        ->and($buttons->item(0)->hasAttribute('disabled'))->toBe($disabled)
        ->and($buttons->item(0)->getAttribute('aria-label'))->toBe('Mostrar senha')
        ->and($buttons->item(0)->getAttribute('aria-controls'))->toBe($inputs->item(0)->getAttribute('id'))
        ->and($inputs->item(0)->getAttribute('id'))->not->toBe('confirmation')
        ->and($buttons->item(1)->getAttribute('aria-controls'))->toBe('confirmation')
        ->and($buttons->item(1)->getAttribute('aria-label'))->toBe('Mostrar senha: Confirmação');
})->with([true, false]);
