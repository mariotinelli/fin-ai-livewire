<?php

declare(strict_types = 1);

it('escapes labels and destination attributes without creating executable markup', function (): void {
    $label       = '"><script>window.breadcrumbInjected=true</script>';
    $destination = '/safe?name=" onmouseover="window.breadcrumbInjected=true';
    $items       = [['label' => $label, 'route' => $destination], $label];

    $view = $this->blade('<x-ui.breadcrumb :items="$items" />', ['items' => $items]);

    $view->assertSee('title="' . e($label) . '"', false)
        ->assertSee('href="' . e($destination) . '"', false)
        ->assertDontSee('<script>window.breadcrumbInjected=true</script>', false);
});
