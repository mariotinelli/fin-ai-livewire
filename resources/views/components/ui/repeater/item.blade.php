@props(['index', 'itemHeader', 'open' => true, 'copyable' => true, 'removable' => true,])

@aware(['model'])

<li
    {{ $attributes->merge(['class' => 'px-6 py-3 relative space-y-4 border-base-300']) }}
    wire:key="{{ $model . '-' . $index }}"
    role="listitem"
    x-data="{
        open: @js($open),
        index: @js($index),
        items: @entangle($model),
    }"
    x-bind:class="{
        'border-t': index === 0 || index !== items.length,
        'border-b': index === items.length - 1,
        'pb-5': open,
    }"
>
    <x-ui.repeater.item-header :copyable="$copyable" :removable="$removable"> {{ $itemHeader }} </x-ui.repeater.item-header>

    <div x-show="open" x-collapse.duration.400ms>{{ $slot }}</div>
</li>
