@props([
    'disableWhileLoading' => false,
    'name',
    'route',
    'withInfinityScroll' => true,
    'loadOnOpen' => false,
    'initialValue' => null,
    'withSearch' => true,
    'id' => null,
    'label' => null,
    'wire' => null,
    'labeless' => false,
    'showError' => true,
    'defaultOptionLabel' => 'Selecione uma opção',
    'helperText' => null,
    'hint' => null,
    'prefix' => null,
    'suffix' => null,
    'selectedColumn' => 'id',
    'params' => [],
    'parentClass' => null,
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
    x-data="selectSearch({
    search: null,
    initialValue: {{ Js::from($initialValue) }},
    value: @entangle($wireModel),
    wireModel: {{ Js::from($wireModel) }},
    open: false,
    withInfinityScroll: @js((bool) $withInfinityScroll),
    loadOnOpen: @js((bool) $loadOnOpen),
    name: {{ Js::from($name) }},
    route: {{ Js::from($route) }},
    withSearch: @js((bool) $withSearch),
    defaultOptionLabel: {{ Js::from($defaultOptionLabel) }},
    selectedColumn: {{ Js::from($selectedColumn) }},
    suffix: @js((bool) $suffix),
    prefix: @js((bool) $prefix),
    isLive: @js($isLive),
    paramBindings: {{ Js::from($params) }},
})"
    x-on:focusin.window="if (open && !$el.contains($event.target)) open = false;"
    x-on:modal-closed.window="if ($el.closest('[role=dialog]')?.id === $event.detail.modal) open = false;"
    @if ($params !== [])
        x-effect="syncParams({
            @foreach ($params as $queryKey => $wireProperty)
                [{{ Js::from($queryKey) }}]: $wire.$get({{ Js::from($wireProperty) }}),
            @endforeach
        })"
    @endif
    class="w-full {{ $parentClass }}"
>
    @unless ($labeless)
        <div class="flex items-center justify-between">
            <x-ui.input.label
                :name="$name"
                :id="$id"
                :label-id="$labelId"
                x-on:click="$refs.button.focus()"
                :required="$attributes->get('required')"
            >
                {{ $label }}
            </x-ui.input.label>

            @if ($hint)
                <span class="text-sm text-base-content/65">{{ $hint }}</span>
            @endif
        </div>
    @endunless
    @if ($labeless)
        <span id="{{ $labelId }}" class="sr-only">{{ $label ?: $defaultOptionLabel }}</span>
    @endif

    <div class="relative mt-1">
        <div
            @class([
                'flex items-center cursor-default h-10! rounded-lg',
                'border border-base-content/10 focus-within:ring-2 focus-within:ring-primary overflow-hidden ' => $prefix || $suffix,
                'border-error!' => $errors->has($wireModel),
                'bg-base-200' => $attributes->get('disabled')
            ])
            x-bind:class="{
                'ring-1! ring-primary! border-primary!': open && (suffix || prefix),
            }"
        >
            @if ($prefix)
                <div
                    wire:loading.class="bg-base-200!"
                    class="flex min-w-10 items-center justify-center border-r border-r-base-content/10 bg-base-100 p-0! py-1.5! text-base-content/65 hover:cursor-default"
                >
                    {{ $prefix }}
                </div>
            @endif

            <button
                id="{{ $id }}"
                @class([
                    'relative w-full bg-base-100 rounded-lg pl-3 pr-10 py-2 text-left focus:outline-hidden sm:text-sm h-10! disabled:bg-base-200',
                    'border-error! ring-0!' => $errors->has($wireModel),
                    'border border-base-content/10 focus:ring-1 focus:ring-primary focus:border-primary' => !$suffix && !$prefix
                ])
                type="button"
                x-on:click="openList()"
                x-on:keydown.arrow-down.stop.prevent="openList()"
                x-on:keydown.arrow-up.stop.prevent="openList()"
                x-on:keydown.space.stop.prevent="openList()"
                x-on:keydown.enter.stop.prevent="openList()"
                x-ref="button"
                @disabled($attributes->get('disabled'))
                role="combobox"
                aria-controls="{{ $listboxId }}"
                aria-haspopup="listbox"
                :aria-expanded="open"
                aria-labelledby="{{ $labelId }}"
                x-bind:class="{
                    'ring-1! ring-primary! border-primary!': open && !suffix && !prefix,
                }"
                @if ($disableWhileLoading && !$attributes->get('disabled')) wire:loading.attr="disabled" @endif
                {{ $attributes->whereStartsWith('wire:target') }}
            >
                <span
                    x-text="selected.name"
                    class="block truncate"
                    x-bind:class="{
                        'text-base-content/65': !selected.id,
                    }"
                >
                    {{ $initialValue ?: $defaultOptionLabel }}
                </span>

                <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                    <x-icons.loading x-show="loading" class="h-5 w-5 animate-spin text-base-content/50" />
                    <x-icons.selector x-show="!loading" class="h-5 w-5 text-base-content/50" />
                </span>
            </button>

            @if ($suffix)
                <div
                    wire:loading.class="bg-base-200!"
                    class="flex min-w-10 items-center justify-center border-l border-base-content/10 p-0! py-1.5! text-base-content/65 hover:cursor-default"
                >
                    {{ $suffix }}
                </div>
            @endif
        </div>

        <div
            x-show="open"
            x-on:keydown.escape="
                if (open) {
                    $event.preventDefault();
                    $event.stopPropagation();
                    onEscape();
                }
            "
            x-on:keydown.arrow-up.stop.prevent="onArrowUp()"
            x-on:keydown.arrow-down.stop.prevent="onArrowDown()"
            x-on:keydown.enter.stop.prevent="onOptionSelect()"
            x-on:click.away="open = false"
            class="ring-opacity-5 fixed z-20 max-h-60 w-full overflow-auto rounded-md border-0 bg-base-100 py-1 text-base text-base-content shadow-lg ring-1 ring-base-300 focus:outline-hidden sm:text-sm"
            x-on:scroll="infinityScroll()"
            tabindex="-1"
            style="display: none"
            x-ref="searchBox"
            popover="manual"
            data-ui-select-dropdown
        >
            @if ($withSearch)
                <div class="relative flex cursor-default items-center gap-1 shadow-xs">
                    <label for="{{ $listboxId }}-search">
                        <x-icons.search-circle class="h-7 w-7 pb-0.5 pl-2 text-base-content/65" />
                    </label>
                    <input
                        type="text"
                        id="{{ $listboxId }}-search"
                        x-model="search"
                        x-on:input.debounce="doSearch()"
                        x-on:keydown.tab.stop.prevent="selectSearchFocus()"
                        x-on:keydown.arrow-down.stop.prevent="onArrowDown()"
                        x-on:keydown.arrow-up.stop.prevent="onArrowUp()"
                        x-on:keydown.enter.stop.prevent="onOptionSelect()"
                        class="w-full border-0 py-2 focus:ring-0 focus-visible:outline-hidden"
                        x-ref="search"
                        role="combobox"
                        aria-label="{{ $label ?: $defaultOptionLabel }}"
                        aria-controls="{{ $listboxId }}"
                        :aria-expanded="open"
                        :aria-activedescendant="activeDescendant"
                        placeholder="Search ..."
                    />
                </div>
            @endif

            <template x-if="loading">
                <div class="flex items-center justify-center gap-2 p-3 text-sm text-base-content/65" role="status">
                    <x-icons.loading class="h-4 w-4 animate-spin" aria-hidden="true" />
                    <span>Carregando opções…</span>
                </div>
            </template>
            <template x-if="loadFailed && !loading">
                <div class="flex flex-col items-start gap-2 p-3 text-sm text-base-content" role="alert">
                    <p>Não foi possível carregar as opções.</p>
                    <x-ui.button
                        type="button"
                        link
                        primary
                        sm
                        x-ref="retryButton"
                        x-on:click.stop="retryLoading()"
                        x-on:keydown.enter.stop
                        x-on:keydown.space.stop
                    >
                        Tentar novamente
                    </x-ui.button>
                </div>
            </template>

            <ul
                class="p-1 relative {{ $withSearch ? 'max-h-44' : 'max-h-60' }} overflow-auto focus:outline-hidden"
                id="{{ $listboxId }}"
                role="listbox"
                x-max="1"
                x-ref="ul"
                tabindex="-1"
                x-on:keydown.enter.stop.prevent="onOptionSelect()"
                x-on:keydown.space.stop.prevent="onOptionSelect()"
                x-on:keydown.arrow-up.stop.prevent="onArrowUp()"
                x-on:keydown.arrow-down.stop.prevent="onArrowDown()"
                x-on:scroll="infinityScroll()"
                aria-labelledby="{{ $labelId }}"
                x-bind:aria-activedescendant="activeDescendant"
                x-bind:aria-busy="loading"
            >
                <template x-if="showEmptyOptions">
                    <li class="relative pt-3 pr-4 pb-2 pl-8 text-sm text-base-content select-none" role="option" aria-disabled="true">
                        Nenhum resultado encontrado
                    </li>
                </template>

                <template x-if="items.length > 0">
                    <template x-for="(item, index) in items" :key="index">
                        <li
                            class="relative rounded-md py-2 pr-4 pl-8 text-sm text-base-content select-none hover:cursor-pointer hover:bg-primary hover:text-primary-content"
                            role="option"
                            x-on:click="selectedIndex === index ? remove() : choose(index)"
                            x-on:mouseenter="activeIndex = index"
                            x-on:mouseleave="activeIndex = null"
                            x-bind:id="@js($listboxId) + '-option-' + item.id"
                            x-bind:class="{
                                'bg-primary text-primary-content': activeIndex === index,
                                'font-semibold': activeIndex === index || selected.id === item.id,
                                'text-base-content': activeIndex !== index,
                            }"
                        >
                            <span
                                x-state:on="Selected"
                                x-state:off="Not Selected"
                                class="block truncate p-0! font-normal"
                                x-bind:class="{
                                    'font-semibold': selected.id === item.id,
                                }"
                                x-text="item.name"
                            >
                            </span>

                            <span
                                class="absolute inset-y-0 left-0 mb-0.5 flex items-center pl-2.5 text-primary-content"
                                x-show="selectedIndex === index && activeIndex === index"
                                style="display: none"
                            >
                                <x-icons.x-mark class="h-4 w-4" />
                            </span>

                            <span
                                class="absolute inset-y-0 left-0 mb-0.5 flex items-center pl-2.5 font-semibold text-primary"
                                x-show="selectedIndex === index && activeIndex !== index"
                                style="display: none"
                            >
                                <x-icons.check class="h-4 w-4" />
                            </span>
                        </li>
                    </template>
                </template>
            </ul>
        </div>
    </div>

    @if ($showError)
        @error($wireModel)
            <x-ui.input.error :message="$message" />
        @enderror
    @endif

    @if ($helperText)
        <span class="text-sm break-words text-base-content/65">{{ $helperText }}</span>
    @endif
</div>
