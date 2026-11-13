{{--
    Opções: {id, name, disabled?}. Rota paginada: {data, links: {next}, meta}.
    Grupo altera somente opções disponíveis já carregadas que correspondam à busca por nome.
    Busca/paginação preservam seleções; mudança de params limpa a seleção, respeitando live/deferred.
    O consumidor autoriza o endpoint e valida os IDs permitidos no servidor; disabled é apresentação.
--}}
@props([
    'route' => null,
    'items' => [],
    'params' => [],
    'selectedColumn' => 'id',
    'withInfinityScroll' => true,
    'loadOnOpen' => false,
    'label' => 'Opções',
    'defaultOptionLabel' => 'Selecione uma ou mais opções',
    'id' => null,
    'showError' => true,
])

@php
    $wireModel = $attributes->wire('model')->value();
    $isLive = $attributes->wire('model')->hasModifier('live');
    $id ??= $wireModel;
@endphp

<div
    x-id="['checkbox-select']"
    x-data="checkboxSelect({
        value: $wire.$get(@js($wireModel)), wireModel: @js($wireModel), isLive: @js($isLive),
        route: @js($route), items: @js($items), paramBindings: @js($params), selectedColumn: @js($selectedColumn),
        withInfinityScroll: @js((bool) $withInfinityScroll), loadOnOpen: @js((bool) $loadOnOpen),
        withSearch: true, defaultOptionLabel: @js($defaultOptionLabel),
    })"
    x-effect="value = $wire.$get(@js($wireModel)); syncParams({
        @foreach ($params as $queryKey => $wireProperty)
            [@js($queryKey)]: $wire.$get(@js($wireProperty)),
        @endforeach
    })"
    @focusin.window="if (open && !$el.contains($event.target)) open = false;"
    class="w-full"
>
    <label for="{{ $id }}" :id="$id('checkbox-select') + '-label'" class="mb-1 block text-sm font-medium">{{ $label }}</label>
    <button
        {{ $attributes->whereDoesntStartWith('wire:model')->except(['id'])->class(['input flex w-full items-center justify-between text-left text-sm']) }}
        id="{{ $id }}"
        type="button"
        x-ref="button"
        @click="openList()"
        @keydown.arrow-down.prevent="if (!open) openList();"
        :aria-expanded="open"
        :aria-controls="$id('checkbox-select') + '-panel'"
        :aria-labelledby="$id('checkbox-select') + '-label ' + $id('checkbox-select') + '-summary'"
        @if ($showError && $errors->has($wireModel)) aria-describedby="{{ $id }}-error" aria-invalid="true" @endif
    >
        <span :id="$id('checkbox-select') + '-summary'" class="truncate" x-text="selectionLabel"></span>
        <x-icons.chevron-down class="size-4 shrink-0" aria-hidden="true" />
    </button>
    <div
        :id="$id('checkbox-select') + '-panel'"
        wire:ignore
        x-show="open"
        style="display: none"
        x-ref="multiSelectSearchBox"
        popover="manual"
        data-ui-select-dropdown
        @click.outside="open = false"
        @keydown.escape.stop.prevent="onEscape()"
        @scroll="infinityScroll()"
        class="fixed z-20 m-0 max-h-60 overflow-y-auto rounded-lg border border-base-300 bg-base-100 p-3 text-base-content shadow-lg"
        role="group"
        :aria-labelledby="$id('checkbox-select') + '-label'"
        :aria-busy="loading"
    >
        <input
            x-ref="search"
            type="search"
            aria-label="Buscar em {{ $label }}"
            placeholder="Buscar..."
            x-model="search"
            @input.debounce.250ms="doSearch()"
            class="input mb-2 w-full"
        />
        <label class="mb-2 flex items-start gap-2 text-sm">
            <input
                type="checkbox"
                data-select-loaded
                :checked="allFilteredSelected"
                x-effect="$el.indeterminate = someFilteredSelected"
                :disabled="!canEdit || availableItems.length === 0"
                @change="toggleAll()"
                class="checkbox checkbox-sm"
            />
            <span>Selecionar opções carregadas deste filtro</span>
        </label>
        <button
            type="button"
            @click="clearSelection()"
            :disabled="!canEdit || selectedItems.length === 0"
            class="mb-2 text-sm underline disabled:opacity-50"
        >
            Limpar seleção
        </button>
        <p x-show="loading" role="status" class="text-sm">Carregando opções…</p>
        <div x-show="loadFailed && !loading" role="alert">
            <p>Não foi possível carregar as opções.</p>
            <x-ui.button link primary sm x-ref="retryButton" @click="retryLoading()" x-bind:data-ui-button-loading="loading">
                Tentar novamente</x-ui.button
            >
        </div>
        <p x-show="showEmptyOptions" class="text-sm">Nenhum resultado encontrado</p>
        <div x-ref="ul" class="space-y-2">
            <template x-for="(item, index) in filteredItems" :key="String(item.id)">
                <label class="flex items-start gap-2 text-sm">
                    <input
                        type="checkbox"
                        :id="$id('checkbox-select') + '-option-' + encodeURIComponent(String(item.id))"
                        :data-option-id="item.id"
                        :checked="selectedItems.includes(String(item.id))"
                        :disabled="!canEdit || Boolean(item.disabled)"
                        @change="choose(index)"
                        class="checkbox shrink-0 checkbox-sm"
                    />
                    <span class="break-words" x-text="item.name"></span>
                </label>
            </template>
        </div>
        <x-ui.button
            link
            primary
            sm
            type="button"
            x-show="data.links.next && !loadFailed"
            x-bind:disabled="loading"
            x-bind:data-ui-button-loading="loading"
            @click="loadMore()"
            class="mt-3 text-sm underline"
        >
            Carregar mais
        </x-ui.button>
    </div>
    @if ($showError)
        @error($wireModel)
            <x-ui.input.error :id="$id . '-error'" :message="$message" />
        @enderror
    @endif
</div>
