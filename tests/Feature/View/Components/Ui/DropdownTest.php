<?php

declare(strict_types = 1);

it('escapes textual header description and footer content', function (): void {
    $html = (string) $this->blade(<<<'BLADE'
        <x-ui.dropdown :header="$text" :description="$text" :footer="$text">
            <x-slot:trigger><button>Open</button></x-slot:trigger>
            Content
        </x-ui.dropdown>
        BLADE, ['text' => '<script>alert("unsafe")</script>']);
    expect($html)->not->toContain('<script>')->toContain('&lt;script&gt;');
});
