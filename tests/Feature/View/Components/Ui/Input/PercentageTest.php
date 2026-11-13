<?php

declare(strict_types = 1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ViewErrorBag;

it('renders one synchronization binding and preserves the visible field contract', function (string $modifier, string $binding): void {
    View::share('errors', new ViewErrorBag());
    $html = Blade::render(
        '<x-ui.input.percentage wire:model' . $modifier
        . '="rate" label="Taxa" required :min="-10" :max="25" :decimal-places="3" @input="window.inputs++" @paste="window.pastes++" @blur="window.blurs++" />',
    );
    $document = new DOMDocument();
    @$document->loadHTML('<?xml encoding="UTF-8">' . $html);
    $hidden  = $document->getElementsByTagName('input')->item(0);
    $visible = $document->getElementsByTagName('input')->item(1);

    expect($hidden->getAttribute($binding))->toBe('rate')
        ->and($visible->getAttribute('name'))->toBe('rate')
        ->and($visible->getAttribute('id'))->toBe('rate')
        ->and($visible->getAttribute('inputmode'))->toBe('decimal')
        ->and($visible->getAttribute('placeholder'))->toBe('0,000')
        ->and($visible->hasAttribute('required'))->toBeTrue()
        ->and($visible->getAttribute('x-on:input'))->toContain('window.inputs++')
        ->and($visible->getAttribute('x-on:paste'))->toContain('window.pastes++')
        ->and($visible->getAttribute('x-on:blur'))->toContain('window.blurs++')
        ->and($html)->toContain('Percentage.formatPercentage(value, 3, -10, 25)');

    foreach ($visible->attributes as $attribute) {
        expect($attribute->name)->not->toStartWith('wire:model');
    }
})->with([
    ['', 'wire:model'], ['.defer', 'wire:model.defer'], ['.live', 'wire:model.live'],
    ['.live.debounce.250ms', 'wire:model.live.debounce.250ms'],
    ['.live.250ms', 'wire:model.live.debounce.250ms'], ['.blur', 'wire:model.live.blur'],
    ['.blur.live', 'wire:model.live.blur'],
]);

it('renders zero precision without a decimal separator and safely serializes props', function (): void {
    View::share('errors', new ViewErrorBag());

    $html = Blade::render('<x-ui.input.percentage wire:model="rate" :decimal-places="0" min="&quot;;alert(1)//" />');

    expect($html)->toContain('placeholder="0"')
        ->and($html)->not->toContain('Percentage.formatPercentage(value, 0, ";alert(1)//", 100)')
        ->and($html)->toContain("Percentage.formatPercentage(value, 0, '\\u0026quot;;alert(1)\\/\\/', 100)");
});
