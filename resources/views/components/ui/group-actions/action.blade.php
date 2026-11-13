@props([
    'label' => null,
    'icon' => null,
    'href' => false,
    'navigate' => true,
    'disabled' => false,
    'withLoading' => true,
])

@php
    $visibleLabel = $label ?: trim($slot);
    $actionAttributes = $attributes->except(['role', 'tabindex', 'aria-disabled']);

    if ($disabled) {
        $actionAttributes = $actionAttributes->filter(fn (mixed $value, string $key): bool =>
            (!str_starts_with($key, 'wire:') || $key === 'wire:key') &&
            !str_starts_with($key, 'x-on:') &&
            !str_starts_with($key, '@') &&
            !str_starts_with($key, 'on') &&
            !in_array($key, ['x-bind:disabled', ':disabled', 'x-bind:href', ':href'], true)
        );
    }
    $attributes = $actionAttributes->class(['h-auto min-h-0 w-full justify-start border-0 px-3 py-2 text-left whitespace-normal shadow-none', 'opacity-40' => $disabled]);
@endphp

<li role="none">
    <x-ui.button
        {{ $attributes }}
        :label="$visibleLabel"
        :$icon
        :href="$disabled ? false : $href"
        :$navigate
        :$disabled
        :with-loading="$withLoading && !$disabled"
        :aria-disabled="$disabled ? 'true' : 'false'"
        :tabindex="$disabled ? -1 : 0"
        role="menuitem"
        ghost
        sm
    />
</li>
