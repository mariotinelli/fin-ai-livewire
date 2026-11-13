<?php

declare(strict_types = 1);

it('supports a labelled button trigger and escapes its labels', function (): void {
    $html = (string) $this->blade(<<<'BLADE'
        <x-ui.group-actions button :label="$label" aria-label="Opções">
            <x-ui.group-actions.action label="Detalhes" href="/details" />
        </x-ui.group-actions>
        BLADE, ['label' => '<script>unsafe</script>']);
    expect($html)->toContain('&lt;script&gt;unsafe&lt;/script&gt;', 'aria-label="Opções"')->not->toContain('<script>');
});
