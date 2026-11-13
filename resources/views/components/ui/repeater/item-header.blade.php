@props([
    'headerActions' => null,
    'copyable' => true,
    'removable' => true,
])

@aware(['model', 'index'])

<div class="mb-0 flex items-center justify-between transition-all duration-400 ease-in-out" x-bind:class="{ 'border-b mb-4 pb-2': open }">
    <div class="flex items-center gap-2">
        <span class="text-lg font-semibold text-base-content"> {{ $slot }} </span>
    </div>

    <div class="flex flex-wrap items-center justify-end gap-2">
        <x-ui.button
            id="repeater-open-item-{{ $model . '.' . $index }}"
            x-show="!open"
            class="border-0 bg-transparent shadow-none"
            @click="open = !open"
            @keydown.enter.prevent="open = !open"
            @keydown.space.prevent="open = !open"
            x-bind:aria-label="'Expandir item ' + (index + 1)"
            x-bind:aria-expanded="open"
            ghost
            sm
            icon="chevron-down"
        />

        <x-ui.button
            id="repeater-close-item-{{ $model . '.' . $index }}"
            x-show="open"
            class="border-0 bg-transparent shadow-none"
            @click="open = !open"
            @keydown.enter.prevent="open = !open"
            @keydown.space.prevent="open = !open"
            x-bind:aria-label="'Recolher item ' + (index + 1)"
            x-bind:aria-expanded="open"
            ghost
            sm
            icon="chevron-up"
        />

        @if ($headerActions)
            {{ $headerActions }}
        @endif

        @if ($copyable)
            <x-ui.button
                id="repeater-duplicate-item-{{ $model . '.' . $index }}"
                :with-loading="false"
                wire:click="duplicateItem(@js($model . '.' . $index))"
                x-bind:aria-label="'Duplicar item ' + (index + 1)"
                primary
                soft
                sm
                circle
                icon="document-duplicate"
            />
        @endif

        @if ($removable)
            <x-ui.button
                id="repeater-remove-item-{{ $model . '.' . $index }}"
                :with-loading="false"
                wire:click="removeItem(@js($model . '.' . $index))"
                x-bind:aria-label="'Remover item ' + (index + 1)"
                error
                soft
                sm
                circle
                icon="trash"
            />
        @endif
    </div>
</div>
