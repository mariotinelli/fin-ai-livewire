<?php

declare(strict_types = 1);

it('escapes action labels and supports opting out of the spinner', function (): void {
    $html = (string) $this->blade(<<<'BLADE'
        <x-ui.group-actions.action :label="$label" wire:click="save(1)" :with-loading="false" />
        BLADE, ['label' => '<script>unsafe</script>']);
    expect($html)->toContain('&lt;script&gt;unsafe&lt;/script&gt;', 'wire:click="save(1)"')->not->toContain('<script>', 'data-ui-loading-spinner');
});
