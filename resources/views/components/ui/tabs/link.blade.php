@props([ 'name', 'active' => false, 'key' => $key ?? 'lists_tab', 'icon' => null, 'value' => null, 'badge' => null, 'flushLeft' => false, ])

@php
    $tabValue = $value ?? str($name)->slug();
    $tabId    = 'tab-' . $key . '-' . $tabValue;
    $panelId  = 'tabpanel-' . $key . '-' . $tabValue;
@endphp

<button
    data-ui-loading-control
    type="button"
    @class(['tab', 'text-nowrap checked:bg-primary/20' => !$icon, '-ms-3' => $flushLeft])
    id="{{ $tabId }}"
    data-ui-tab
    role="tab"
    aria-controls="{{ $panelId }}"
    aria-selected="{{ $active ? 'true' : 'false' }}"
    tabindex="{{ $active ? '0' : '-1' }}"
    aria-label="{{ $name }}"
    {{ $attributes }}
>
    @if ($icon)
        <x-dynamic-component :component="'icons.' . $icon" class="me-2 size-4" />
    @endif

    {{ $name }}

    @if ($badge !== null)
        <x-ui.badge sm neutral class="ms-2" data-tab-badge>{{ $badge }}</x-ui.badge>
    @endif
    <span data-ui-loading-spinner class="loading hidden loading-xs loading-spinner" aria-hidden="true"></span>
</button>
