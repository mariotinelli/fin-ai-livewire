@props([
    'id' => null,
    'label' => null,
    'button' => false,
    'size' => 'sm',
    'icon' => 'ellipsis-horizontal',
    'ariaLabel' => 'Ações',
    'width' => 'w-64',
    'end' => true,
    'top' => false,
    'bottom' => true,
    'left' => false,
    'right' => false,
])

<x-ui.dropdown :$id :$width :$end :$top :$bottom :$left :$right>
    <x-slot:trigger>
        <x-ui.button
            {{ $attributes }}
            :id="$id ? $id . '-trigger' : null"
            :$icon
            :label="$button ? $label ?? 'Ações' : null"
            :aria-label="$ariaLabel"
            :square="!$button"
            :xs="$size === 'xs'"
            :sm="$size === 'sm'"
            :lg="$size === 'lg'"
            :with-loading="false"
            ghost
        />
    </x-slot:trigger>

    {{ $slot }}
</x-ui.dropdown>
