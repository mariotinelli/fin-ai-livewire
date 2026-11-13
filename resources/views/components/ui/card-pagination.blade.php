@use('Illuminate\Pagination\LengthAwarePaginator')

@props(['paginator', 'id', 'perPageModel', 'perPageValues',])

@php
    /** @var LengthAwarePaginator $paginator */
    $pageName     = $paginator->getPageName();
    $firstItem    = $paginator->firstItem() ?? 0;
    $lastItem     = $paginator->lastItem() ?? 0;
    $lastPage     = $paginator->lastPage();
    $loadingTargets = implode(', ', [
        $perPageModel,
        "gotoPage(1, '{$pageName}')",
        "previousPage('{$pageName}')",
        "nextPage('{$pageName}')",
        "gotoPage({$lastPage}, '{$pageName}')",
    ]);
@endphp

<section
    data-ui-pagination
    id="{{ $id }}"
    aria-label="Paginação da lista de cartões"
    {{ $attributes->class(['rounded-xl border border-base-300 bg-base-100 p-3 shadow-sm sm:p-4']) }}
>
    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between md:gap-4">
        <div class="flex items-center justify-center gap-2 md:justify-start">
            <label for="{{ $id }}-per-page" class="text-sm text-base-content/80">Itens por página</label>
            <select
                id="{{ $id }}-per-page"
                wire:model.live="{{ $perPageModel }}"
                wire:change="resetPage(@js($pageName))"
                class="select rounded-lg border border-base-300 bg-base-100 text-base-content select-sm"
                aria-label="Itens por página"
            >
                @foreach ($perPageValues as $value)
                    <option value="{{ $value }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>

        <p id="{{ $id }}-summary" class="text-center text-sm text-base-content/80" aria-live="polite">Mostrando
        <span class="font-semibold text-base-content">{{ $firstItem }}</span>
        até
        <span class="font-semibold text-base-content">{{ $lastItem }}</span>
        de
        <span class="font-semibold text-base-content">{{ $paginator->total() }}</span>
        registros</p>

        <div class="flex items-center justify-center gap-1.5" aria-label="Navegação entre páginas">
            <button
                data-ui-loading-control
                id="{{ $id }}-first-page"
                type="button"
                wire:click="gotoPage(1, @js($pageName))"
                @disabled($paginator->onFirstPage())
                aria-label="Ir para a primeira página"
                class="btn btn-circle! rounded-sm btn-primary btn-sm disabled:cursor-not-allowed"
            >
                <x-icons.chevron-double-left class="size-4" aria-hidden="true" />
                <span data-ui-loading-spinner class="loading hidden loading-xs loading-spinner" aria-hidden="true"></span>
            </button>

            <button
                data-ui-loading-control
                id="{{ $id }}-previous-page"
                type="button"
                wire:click="previousPage(@js($pageName))"
                @disabled($paginator->onFirstPage())
                aria-label="Ir para a página anterior"
                class="btn btn-circle! rounded-sm btn-primary btn-sm disabled:cursor-not-allowed"
            >
                <x-icons.chevron-left class="size-4" aria-hidden="true" />
                <span data-ui-loading-spinner class="loading hidden loading-xs loading-spinner" aria-hidden="true"></span>
            </button>

            <span
                id="{{ $id }}-current-page"
                class="min-w-8 text-center text-lg font-semibold text-base-content"
                aria-label="Página atual"
                aria-current="page"
            >
                {{ $paginator->currentPage() }}
            </span>

            <button
                data-ui-loading-control
                id="{{ $id }}-next-page"
                type="button"
                wire:click="nextPage(@js($pageName))"
                @disabled(!$paginator->hasMorePages())
                aria-label="Ir para a próxima página"
                class="btn btn-circle! rounded-sm btn-primary btn-sm disabled:cursor-not-allowed"
            >
                <x-icons.chevron-right class="size-4" aria-hidden="true" />
                <span data-ui-loading-spinner class="loading hidden loading-xs loading-spinner" aria-hidden="true"></span>
            </button>

            <button
                data-ui-loading-control
                id="{{ $id }}-last-page"
                type="button"
                wire:click="gotoPage({{ $lastPage }}, @js($pageName))"
                @disabled(!$paginator->hasMorePages())
                aria-label="Ir para a última página"
                class="btn btn-circle! rounded-sm btn-primary btn-sm disabled:cursor-not-allowed"
            >
                <x-icons.chevron-double-right class="size-4" aria-hidden="true" />
                <span data-ui-loading-spinner class="loading hidden loading-xs loading-spinner" aria-hidden="true"></span>
            </button>
        </div>
    </div>

    <p
        id="{{ $id }}-loading"
        wire:loading.flex
        wire:target="{{ $loadingTargets }}"
        class="mt-2 hidden items-center justify-center gap-2 text-sm text-base-content/70"
        role="status"
    >
        <span class="loading loading-xs loading-spinner" aria-hidden="true"></span>
        Atualizando lista
    </p>
</section>
