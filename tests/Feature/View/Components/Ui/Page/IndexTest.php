<?php

declare(strict_types = 1);

it('exposes a page title as escaped metadata and visible text', function (): void {
    $title = 'Users " onmouseover="window.titleInjected=true"><script>window.titleInjected=true</script>';

    $view = $this->blade('<x-ui.page :title="$title" :breadcrumb="[]">Content</x-ui.page>', ['title' => $title]);

    $view->assertSee('data-page-title="' . e($title) . '"', false)
        ->assertSee($title)
        ->assertDontSee('<script>window.titleInjected=true</script>', false)
        ->assertSee('Content');
});
