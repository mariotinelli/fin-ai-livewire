<?php

declare(strict_types = 1);

it('renders optional badge values including numeric and string zero', function (int | string $badge): void {
    $view = $this->blade('<x-ui.tabs.link name="Inbox" :badge="$badge" />', ['badge' => $badge]);

    $view->assertSee('data-tab-badge', false);

    $document = new DOMDocument();
    @$document->loadHTML((string) $view);
    $xpath = new DOMXPath($document);

    expect(trim($xpath->query('//*[@data-tab-badge]')->item(0)->textContent))->toBe((string) $badge);
})->with([0, '0', 12, 'New']);

it('escapes badge text rather than rendering markup', function (): void {
    $badge = '<script>window.badgeInjected=true</script>';

    $this->blade('<x-ui.tabs.link name="Inbox" :badge="$badge" />', ['badge' => $badge])
        ->assertSee($badge)
        ->assertDontSee($badge, false)
        ->assertSee('data-tab-badge', false);
});
