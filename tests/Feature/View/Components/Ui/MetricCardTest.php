<?php

declare(strict_types = 1);

it('escapes metric content supplied by consumers', function (): void {
    $unsafe = '<script>window.metricInjected = true</script>';

    $view = $this->blade(<<<'BLADE'
        <x-ui.metric-card :label="$unsafe" :value="$unsafe" :comparison="1" :comparison-label="$unsafe" />
        BLADE, ['unsafe' => $unsafe]);

    $view->assertSee($unsafe)
        ->assertDontSee($unsafe, false);
});
