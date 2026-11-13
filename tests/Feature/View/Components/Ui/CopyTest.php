<?php

declare(strict_types = 1);

it('escapes text labels and configurable messages', function (): void {
    $payload = '"><script>window.copyInjected=true</script>';
    $this->blade('<x-ui.copy :text="$payload" :label="$payload" :copy-label="$payload" :success-message="$payload" :error-message="$payload" />', ['payload' => $payload])
        ->assertSee('aria-label="' . e($payload) . '"', false)
        ->assertDontSee('<script>window.copyInjected=true</script>', false);
});
