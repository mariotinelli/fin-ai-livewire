@props([
    'name' => null,
    'key' => $key ?? 'lists_tab',
    'value' => null,
])

@php
    $panelValue = $value ?? str((string) $name)->slug();
    $tabId      = 'tab-' . $key . '-' . $panelValue;
    $panelId    = 'tabpanel-' . $key . '-' . $panelValue;
@endphp

<div id="{{ $panelId }}" role="tabpanel" aria-labelledby="{{ $tabId }}" data-ui-tab-panel class="mt-4">{{ $slot }}</div>
