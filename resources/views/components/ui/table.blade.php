@use('Illuminate\Pagination\AbstractPaginator')

@props([
    'records',
    'search' => true,
    'pagination' => true,
    'header' => null,
    'body' => null,
    'filtersHeader' => null,
    'filtersDropdown' => null,
    'tableHeader' => null,
    'searchInput' => null,
    'toggleOnlyTrashed' => false,
    'draftFilters' => false,
    'activeFilterCount' => null,
])

@php
    $activeFilters = $activeFilterCount ?? 0;
    $searchId      = 'table-search-' . ($draftFilters ? ($attributes->get('id') ?? $this->getId()) : str()->ulid());
    $filtersId    = $draftFilters ? 'table-filters-' . ($attributes->get('id') ?? $this->getId()) : null;

    $filters = $this->filters ?? [];

    foreach ($activeFilterCount === null ? $filters : [] as $filter) {
        if (is_array($filter)) {
            $activeFilters += count($filter) === 0 ? 0 : 1;

            continue;
        }

        $activeFilters += empty($filter) ? 0 : 1;
    }
@endphp

<div
    x-data="tableTooltips"
    data-table-tooltips
    {{ $attributes->merge(['class' => 'mx-auto rounded-lg w-full bg-base-100 border border-base-300']) }}
>
    @error('filters')
        <x-ui.input.error :message="$message" />
    @enderror

    @if ($filtersHeader || $search || $filtersDropdown)
        <div @class(['p-4 flex items-end gap-3 justify-end', 'px-8!' => $filtersDropdown])>
            @if ($filtersHeader)
                <div class="flex h-full items-end">{{ $filtersHeader }}</div>
            @endif

            @if ($search || $filtersDropdown || $toggleOnlyTrashed)
                <div @class(['flex items-center gap-3', 'min-w-0 w-full sm:w-auto' => $draftFilters])>
                    @if ($toggleOnlyTrashed)
                        <x-ui.input.toggle inline label-right label="Mostrar apenas desativados" wire:model.live="toggleOnlyTrashed" />
                    @endif

                    @if ($search)
                        @if ($searchInput)
                            {{ $searchInput }}
                        @else
                            <label for="{{ $searchId }}" class="sr-only">Buscar itens na tabela</label>
                            <x-ui.input
                                id="{{ $searchId }}"
                                type="search"
                                placeholder="Buscar itens na tabela"
                                wire:model.live.debounce.400ms="search"
                                :class="$draftFilters ? 'min-w-0 sm:min-w-64' : 'min-w-64'"
                                aria-label="Buscar itens na tabela"
                            >
                                <x-slot name="prefix">
                                    <x-icons.magnifying-glass class="size-6" aria-hidden="true" />
                                </x-slot>
                            </x-ui.input>
                        @endif
                    @endif

                    @if ($filtersDropdown)
                        <div
                            class="shrink-0"
                            @if ($draftFilters)
                                x-data="{
                                    discardFilterDraft() {
                                        $wire.set('filterDraft', JSON.parse(JSON.stringify($wire.filters)), false);
                                    },
                                }"
                                x-on:ui-dropdown-closed.stop="discardFilterDraft()"
                            @endif
                        >
                            <x-ui.dropdown
                                :id="$filtersId"
                                bottom
                                end
                                :lg="!$draftFilters"
                                :controlled="$draftFilters"
                                :width="$draftFilters ? 'w-[calc(100vw-5rem)] sm:w-96' : 'w-52'"
                            >
                                <x-slot name="trigger">
                                    <button
                                        id="open-filters"
                                        type="button"
                                        class="relative"
                                        aria-label="Abrir filtros, {{ $activeFilters }} filtros ativos"
                                        @if ($draftFilters)
                                            aria-haspopup="dialog"
                                            aria-controls="dropdown-menu-{{ $filtersId }}"
                                            x-bind:aria-expanded="open"
                                        @endif
                                    >
                                        <x-ui.badge primary circle sm class="absolute -top-3 -right-4"> {{ $activeFilters }} </x-ui.badge>

                                        <x-icons.funnel class="h-5 w-5 cursor-pointer text-base-content/50" aria-hidden="true" />
                                    </button>
                                </x-slot>

                                <span class="sr-only" aria-live="polite">{{ $activeFilters }} filtros ativos</span>

                                <div class="space-y-4 p-6">
                                    <div class="flex items-center justify-between gap-4">
                                        <x-ui.title sm>Filtros</x-ui.title>

                                        @if ($draftFilters)
                                            <x-ui.button
                                                id="reset-filters"
                                                type="button"
                                                link
                                                error
                                                sm
                                                loading="resetFilters"
                                                x-on:click="
                                                    await $wire.resetFilters();
                                                    close();
                                                "
                                            >
                                                Limpar
                                            </x-ui.button>
                                        @else
                                            <button
                                                data-ui-loading-control
                                                id="reset-filters"
                                                type="button"
                                                wire:click="resetFilters"
                                                class="hover:text-decoration-line: text-error underline hover:cursor-pointer"
                                                aria-label="Limpar todos os filtros ativos"
                                            >
                                                Limpar
                                                <span
                                                    data-ui-loading-spinner
                                                    class="loading hidden loading-xs loading-spinner"
                                                    aria-hidden="true"
                                                ></span>
                                            </button>
                                        @endif
                                    </div>

                                    {{ $filtersDropdown }}

                                    @if ($draftFilters)
                                        <div class="flex justify-end">
                                            <x-ui.button
                                                id="apply-filters"
                                                type="button"
                                                primary
                                                sm
                                                loading="applyFilters"
                                                x-on:click="if (await $wire.applyFilters()) close();"
                                            >
                                                Filtrar
                                            </x-ui.button>
                                        </div>
                                    @endif
                                </div>
                            </x-ui.dropdown>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    @endif

    <div
        @class([
            '-mx-4 sm:mx-0 overflow-x-auto border-b border-base-300',
            'sm:rounded-t-lg' => !$search && !$filtersHeader && !$filtersDropdown,
            'border-t' => $search || $filtersHeader || $filtersDropdown,
            'max-h-[40rem] border-b-0 sm:rounded-b-lg' => !$pagination || !($records instanceof AbstractPaginator)
        ])
    >
        <table
            @class([
                'min-w-full divide-y divide-base-300 sm:rounded-lg',
                'max-h-[40rem] overflow-auto' => !$pagination || !($records instanceof AbstractPaginator)
            ])
            aria-label="Tabela de resultados"
        >
            <thead>
                @if ($tableHeader)
                    <tr class="bg-base-100">
                        {{ $tableHeader }}
                    </tr>
                @endif

                <tr class="bg-base-200">
                    {{ $header }}
                </tr>
            </thead>

            <tbody class="divide-y divide-base-300 bg-base-100">
                {{ $body }}
            </tbody>
        </table>
    </div>

    @if ($pagination && $records instanceof AbstractPaginator)
        <div class="flex items-center justify-between px-4 pt-2 pb-4">
            <nav aria-label="Paginação" class="w-full">
                {{ $records->links('components.ui.pagination', ['recordCount' => 'full', 'perPageValues' => $this->perPageValues]) }}
            </nav>
        </div>
    @endif
</div>
