<?php

declare(strict_types = 1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ViewErrorBag;

it('renders one synchronization binding and preserves the visible field contract', function (string $modifier, string $binding): void {
    View::share('errors', new ViewErrorBag());
    $html     = Blade::render('<x-ui.input.money wire:model' . $modifier . '="amount" label="Valor" required @input="window.inputs++" @blur="window.blurs++" />');
    $document = new DOMDocument();
    @$document->loadHTML('<?xml encoding="UTF-8">' . $html);
    $hidden  = $document->getElementsByTagName('input')->item(0);
    $visible = $document->getElementsByTagName('input')->item(1);
    expect($hidden->getAttribute($binding))->toBe('amount');
    expect($visible->getAttribute('name'))->toBe('amount')
        ->and($visible->getAttribute('id'))->toBe('amount')
        ->and($visible->hasAttribute('required'))->toBeTrue()
        ->and($visible->getAttribute('x-on:input'))->toContain('window.inputs++')
        ->and($visible->getAttribute('x-on:blur'))->toContain('window.blurs++');

    foreach ($visible->attributes as $attribute) {
        expect($attribute->name)->not->toStartWith('wire:model');
    }
})->with([
    ['', 'wire:model'], ['.defer', 'wire:model.defer'], ['.live', 'wire:model.live'],
    ['.live.debounce.250ms', 'wire:model.live.debounce.250ms'],
    ['.live.250ms', 'wire:model.live.debounce.250ms'],
    ['.blur', 'wire:model.live.blur'], ['.blur.live', 'wire:model.live.blur'],
]);
