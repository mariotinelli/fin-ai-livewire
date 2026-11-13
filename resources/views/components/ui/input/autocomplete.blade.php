@props([
    'name',
    'route',
    'withInfinityScroll' => true,
    'id' => null,
    'label' => null,
    'wire' => null,
    'labeless' => false,
    'showError' => true,
    'helperText' => null,
    'hint' => null,
    'prefix' => null,
    'suffix' => null,
    'params' => [],
])

@php
    use Illuminate\Support\Facades\View;

    $name ??= $attributes->wire('model')->value();
    $uid       = (string) str()->ulid();
    $id        = $id ?? $name ?? $uid;
    $labelId   = "{$id}-label-{$uid}";
    $listboxId = "{$id}-listbox-{$uid}";
    $wireModel = $attributes->whereStartsWith('wire:model')->first();

    $isLive = $attributes->wire('model')->hasModifier('live');
@endphp

<div
    x-data="autocomplete({
    search: null,
    value: @entangle($wireModel),
    wireModel: {{ Js::from($wireModel) }},
    open: false,
    withInfinityScroll: @js((bool) $withInfinityScroll),
    name: {{ Js::from($name) }},
    route: {{ Js::from($route) }},
    suffix: @js((bool) $suffix),
    prefix: @js((bool) $prefix),
    isLive: @js($isLive),
})"
    class="w-full"
>
    <div class="relative">
        <x-ui.input
            {{ $attributes->whereDoesntStartWith('wire:model') }}
            :name="$attributes->wire('model')->value()"
            :id="$id"
            :label="$labeless ? null : $label"
            aria-label="{{ $label ?: 'Buscar opção' }}"
            role="combobox"
            aria-autocomplete="list"
            aria-controls="{{ $listboxId }}"
            x-bind:aria-expanded="open"
            x-bind:aria-activedescendant="activeDescendant"
            x-on:keydown.arrow-down.stop.prevent="onArrowDown()"
            x-on:keydown.arrow-up.stop.prevent="onArrowUp()"
            x-on:keydown.enter="
                if (open) {
                    $event.preventDefault();
                    $event.stopPropagation();
                    onOptionSelect();
                }
            "
            x-on:keydown.escape="
                if (open) {
                    $event.preventDefault();
                    $event.stopPropagation();
                    onEscape();
                }
            "
            x-ref="autocomplete"
            x-model="value"
            x-on:focus="onFocus"
            x-on:click.away="close"
        >
            <x-slot name="prefix">
                <x-icons.magnifying-glass class="size-6" />
            </x-slot>
        </x-ui.input>

        <div
            x-show="open"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="ring-opacity-5 absolute z-10 mt-1 max-h-56 w-full overflow-auto rounded-md bg-base-100 text-base shadow-lg ring-1 ring-base-300 focus:outline-hidden sm:text-sm"
            tabindex="-1"
            style="display: none"
            x-ref="selectBox"
        >
            <ul
                class="relative max-h-56 p-1 focus:outline-hidden"
                id="{{ $listboxId }}"
                role="listbox"
                x-max="1"
                x-ref="ul"
                aria-label="{{ $label ?: 'Buscar opção' }}"
                x-bind:aria-activedescendant="activeDescendant"
            >
                <template x-if="loading">
                    <li
                        class="relative flex items-center justify-center gap-1 py-2 pr-4 pl-8 text-sm text-base-content select-none"
                        role="option"
                    >
                        <x-icons.loading class="h-5 w-5 animate-spin text-base-content/50" />
                        <span>Carregando</span>
                    </li>
                </template>

                <template x-if="items.length === 0 && !loading && value.length > 0">
                    <li class="relative py-2 pr-4 pl-8 text-sm text-base-content select-none" role="option" aria-disabled="true">
                        {{ $emptyLabel ?? 'Nenhum resultado encontrado' }}
                    </li>
                </template>

                <template x-if="value.length === 0 && items.length === 0 && !loading">
                    <li class="relative py-2 pr-4 pl-8 text-sm text-base-content select-none" role="option" aria-disabled="true">
                        Digite ao menos 2 caracteres para buscar
                    </li>
                </template>

                <template x-if="items.length > 0 && !loading">
                    <template x-for="(item, index) in items" :key="index">
                        <li
                            class="relative rounded-md py-2 pr-4 pl-8 text-sm text-base-content select-none hover:cursor-pointer hover:bg-primary hover:text-primary-content"
                            role="option"
                            x-on:click="choose(index)"
                            :aria-selected="activeIndex === index"
                            x-bind:class="{ 'bg-primary text-primary-content': activeIndex === index }"
                            x-on:mouseenter="activeIndex = index"
                            x-bind:id="@js($listboxId) + '-option-' + item.id"
                        >
                            <span class="block truncate p-0! font-normal" x-text="item.name"></span>
                        </li>
                    </template>
                </template>
            </ul>
        </div>
    </div>
</div>
