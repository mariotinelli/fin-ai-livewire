<?php

declare(strict_types = 1);

use Livewire\Livewire;
use Tests\Feature\Support\FeedbackFixture;

it('dispatches plain text alerts without changing their content', function (?string $description): void {
    $component = Livewire::test(FeedbackFixture::class)
        ->set('title', '<b>Título & ação</b>')->set('description', $description)->call('showAlert');

    $component->assertDispatched(
        'alert',
        params: null,
        title: '<b>Título & ação</b>',
        description: $description,
        type: 'alert',
        method: 'confirm',
        componentId: $component->instance()->getId(),
        actionConfirm: true,
        textConfirm: 'Confirmar',
        textCancel: 'Cancelar',
        actionCancel: null,
        color: null,
        icon: null,
        descriptionHighlight: null
    );
})->with([null, '', '<img src=x onerror="window.injected=true">']);

it('preserves confirmation text and callback parameters', function (): void {
    Livewire::test(FeedbackFixture::class)
        ->set('title', '<b>Confirmar & ação</b>')->set('description', '<i>Cancelar</i>')->call('showConfirmation')
        ->assertDispatched(
            'alert',
            params: 42,
            title: '<b>Confirmar & ação</b>',
            description: '<i>Cancelar</i>',
            type: 'confirmation',
            method: 'confirm',
            actionConfirm: true,
            textConfirm: '<b>Confirmar & ação</b>',
            textCancel: '<i>Cancelar</i>'
        );
});

it('dispatches semantic options and highlighted text without changing callback defaults', function (): void {
    Livewire::test(FeedbackFixture::class)->set('title', 'Continue')->set('description', '<b>Literal highlight</b>')->call('showStyledConfirmation')
        ->assertDispatched('alert', params: 42, type: 'confirmation', method: 'confirm', color: 'info', icon: 'information-circle', descriptionHighlight: '<b>Literal highlight</b>', textConfirm: 'Confirmar', textCancel: 'Cancelar', actionConfirm: true);
});
