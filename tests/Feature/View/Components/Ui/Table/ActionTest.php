<?php

declare(strict_types = 1);

it('escapes the accessible name and tooltip content', function (): void {
    $html = (string) $this->blade(<<<'BLADE'
        <x-ui.table.action tooltip="&quot;><script>alert(1)</script>" icon="eye" />
        BLADE);

    expect($html)
        ->not->toContain('<script>')
        ->toContain('&lt;script&gt;alert(1)&lt;/script&gt;');
});
