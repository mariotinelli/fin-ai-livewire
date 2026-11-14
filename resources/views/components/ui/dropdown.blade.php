@props([
    'id' => null,
    'trigger',
    'header' => null,
    'description' => null,
    'footer' => null,
    'end' => false,
    'top' => false,
    'bottom' => false,
    'left' => false,
    'right' => false,
    'hover' => false,
    'open' => false,
    'controlled' => false,
    'sm' => false,
    'md' => false,
    'lg' => false,
    'width' => 'w-52',
])

@php
    $uuid = $id ?? bin2hex(random_bytes(4));
    $dialog = (bool) ($controlled || $description || $footer);
    $panelId = "dropdown-menu-{$uuid}";
    $placement = $left ? 'left' : ($right ? 'right' : ($top ? 'top' : 'bottom'));
@endphp

<div
    @if ($id) id="{{ $id }}" @endif
    x-data="dropdown(@js(['open' => (bool) $open, 'dialog' => $dialog, 'panelId' => $panelId, 'placement' => $placement, 'end' => (bool) $end]))"
    @keydown="keydown($event)"
    @keydown.escape.window="keydown($event)"
    @click.outside="if (open) close();"
    @navigation-mode-changed.window="close(Boolean(triggerElement?.getClientRects().length))"
    @if ($hover)
        @mouseenter="openPanel(false, false)"
        @mouseleave="if (!$el.contains($event.relatedTarget)) close(false);"
    @endif
    @modal-closed.window="if ($el.closest('[role=dialog]')?.id === $event.detail.modal) close(false);"
    class="relative inline-block overflow-visible"
>
    <span x-ref="trigger">{{ $trigger }}</span>

    <div
        x-ref="panel"
        id="{{ $panelId }}"
        data-ui-dropdown-panel
        popover="manual"
        x-cloak
        x-show="open"
        @if ($hover) @mouseleave="if (!$root.contains($event.relatedTarget)) close(false);" @endif
        role="{{ $dialog ? 'dialog' : 'menu' }}"
        @if ($header) aria-labelledby="dropdown-header-{{ $uuid }}" @else aria-label="Opções" @endif
        @if ($description) aria-describedby="dropdown-description-{{ $uuid }}" @endif
        tabindex="-1"
        @class([
            "fixed flex flex-col overflow-hidden rounded-md bg-base-100 text-base-content shadow-md ring-1 ring-base-300 {$width}",
            'w-64!' => $sm,
            'w-80!' => $md,
            'w-96!' => $lg
        ])
    >
        @if ($header || $description)
            <header role="none" class="shrink-0 border-b border-base-300 p-3">
                @if ($header)
                    <div id="dropdown-header-{{ $uuid }}">{{ $header }}</div>
                @endif
                @if ($description)
                    <p id="dropdown-description-{{ $uuid }}" class="text-sm text-base-content/75">{{ $description }}</p>
                @endif
            </header>
        @endif

        <div class="min-h-0 flex-1 overflow-y-auto overscroll-contain" @if (!$dialog) role="none" @endif data-ui-dropdown-content>
            {{ $slot }}
        </div>

        @if ($footer)
            <footer class="shrink-0 border-t border-base-300 p-3">{{ $footer }}</footer>
        @endif
    </div>
</div>
