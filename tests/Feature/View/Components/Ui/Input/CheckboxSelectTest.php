<?php

declare(strict_types = 1);

use Illuminate\Support\Facades\View;
use Illuminate\Support\ViewErrorBag;

it('binds the requested model and safely serializes generic options and parameters', function (): void {
    View::share('errors', new ViewErrorBag());
    $view = $this->blade('<x-ui.input.checkbox-select wire:model.live="selected" label="Itens" route="/options" :params="[\'region\' => \'parent.region\']" :items="$items" />', [
        'items' => [['id' => 1, 'name' => '<script>window.injected=true</script>']],
    ]);
    $view->assertSee('id="selected"', false)
        ->assertSee('aria-labelledby=', false)
        ->assertSee('Selecionar opções carregadas deste filtro')
        ->assertSee('checkboxSelect(', false)
        ->assertDontSee('<script>window.injected=true</script>', false);
});
