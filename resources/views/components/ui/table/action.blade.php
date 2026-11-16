@props(['tooltip', 'icon' => null, 'href' => false, 'disabled' => false, 'withLoading' => true, 'navigate' => true,])

@php
    $loadingTarget = $attributes->get('wire:target') ?: $attributes->get('wire:click');
    $showsLoading = $withLoading && !$disabled;
@endphp

<x-ui.tooltip :label="$tooltip">
    <x-ui.button
        {{ $attributes->class(['table-action min-h-11 min-w-11']) }}
        :$icon
        :href="$disabled ? false : $href"
        :$navigate
        :with-loading="$showsLoading"
        :disabled="$disabled"
        :loading="$loadingTarget"
        aria-label="{{ $tooltip }}"
        ghost
        xs
    >
        {{ $slot }}
    </x-ui.button>
</x-ui.tooltip>
