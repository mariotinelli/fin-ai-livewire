<?php

declare(strict_types = 1);

it('provides the configured application name as escaped metadata in both layouts', function (string $layout): void {
    actingAsAdmin();
    $name = 'Remsoft " onmouseover="window.nameInjected=true"><script>window.nameInjected=true</script>';
    config(['app.name' => $name]);

    $view = $this->blade('<x-' . $layout . '-layout>Content</x-' . $layout . '-layout>');

    $view->assertSee('data-application-title="' . e($name) . '"', false)
        ->assertSee('<title>' . e($name) . '</title>', false)
        ->assertDontSee('<script>window.nameInjected=true</script>', false);
})->with(['app', 'guest']);
