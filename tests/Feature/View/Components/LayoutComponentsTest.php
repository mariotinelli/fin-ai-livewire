<?php

declare(strict_types = 1);

it('provides the product identity in the app layout and escapes the configured guest identity', function (string $layout): void {
    actingAsAdmin();
    $name = 'Remsoft " onmouseover="window.nameInjected=true"><script>window.nameInjected=true</script>';
    config(['app.name' => $name]);
    $expectedName = $layout === 'app' ? 'FinAI' : $name;

    $view = $this->blade('<x-' . $layout . '-layout>Content</x-' . $layout . '-layout>');

    $view->assertSee('data-application-title="' . e($expectedName) . '"', false)
        ->assertSee('<title>' . e($expectedName) . '</title>', false)
        ->assertDontSee('<script>window.nameInjected=true</script>', false);
})->with(['app', 'guest']);
