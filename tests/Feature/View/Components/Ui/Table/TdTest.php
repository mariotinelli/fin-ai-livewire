<?php

declare(strict_types = 1);

it('escapes the full label while preserving custom cell content', function (): void {
    $html = (string) $this->blade(<<<'BLADE'
        <table><tr><x-ui.table.td :label="$label"><strong>Visible value</strong></x-ui.table.td></tr></table>
        BLADE, ['label' => '<script>unsafe</script>']);
    expect($html)->toContain('data-table-cell-text', 'data-tip="&lt;script&gt;unsafe&lt;/script&gt;"', '<strong>Visible value</strong>')->not->toContain('<script>');
});
