<nav data-ui-pagination aria-label="Paginação" class="flex w-full min-w-0 flex-wrap items-center justify-between gap-4">
    <div class="flex items-center gap-3">
        <div class="relative">
            <label for="per-page" class="sr-only">Itens por página</label>
            <select
                id="per-page"
                name="per_page"
                wire:model.live="perPage"
                wire:loading.attr="disabled"
                wire:target="perPage"
                aria-label="Itens por página"
                class="block min-h-11 rounded-lg border border-base-300 bg-base-100 px-3 text-sm text-base-content focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-focus"
            >
                @foreach ($perPageValues as $value)
                    <option value="{{ $value }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="flex w-full min-w-0 flex-wrap items-center justify-between gap-4 sm:w-auto sm:flex-1 sm:justify-end">
        @if ($recordCount === 'full')
            <div>
                <div class="text-sm leading-5 text-secondary" aria-live="polite">
                    Mostrando
                    <span class="firstItem font-semibold">{{ $paginator->firstItem() }}</span>
                    até
                    <span class="lastItem font-semibold">{{ $paginator->lastItem() }}</span>
                    de
                    <span class="total font-semibold">{{ $paginator->total() }}</span>
                    Registros
                </div>
            </div>
        @elseif ($recordCount === 'short')
            <div>
                <p class="text-md mr-2 text-center leading-5 text-base-content" aria-live="polite">
                    <span class="firstItem font-semibold"> {{ $paginator->firstItem() }}</span>
                    -
                    <span class="lastItem font-semibold"> {{ $paginator->lastItem() }}</span>
                    |
                    <span class="total font-semibold"> {{ $paginator->total() }}</span>
                </p>
            </div>
        @elseif ($recordCount === 'min')
            <div>
                <p class="text-md mr-2 text-center leading-5 text-base-content" aria-live="polite">
                    <span class="firstItem font-semibold"> {{ $paginator->firstItem() }}</span>
                    -
                    <span class="lastItem font-semibold"> {{ $paginator->lastItem() }}</span>
                </p>
            </div>
        @endif

        @if ($paginator->hasPages() && $recordCount != 'min')
            @php($pageName = method_exists($paginator, 'getPageName') ? $paginator->getPageName() : 'page')
            <div class="items-center justify-between sm:flex">
                <ul class="flex list-none flex-wrap items-center justify-end gap-1" role="list">
                    @if (!$paginator->onFirstPage())
                        <li>
                            <button
                                data-ui-loading-control
                                type="button"
                                id="first-page"
                                class="inline-flex min-h-11 min-w-11 cursor-pointer items-center justify-center rounded-lg border border-base-300 bg-base-100 p-2 text-center text-primary hover:bg-accent focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-focus"
                                wire:click="gotoPage(1, @js($pageName))"
                                aria-label="Ir para a primeira página"
                            >
                                <x-icons.chevron-double-left class="h-4 w-4" />
                                <span data-ui-loading-spinner class="loading hidden loading-xs loading-spinner" aria-hidden="true"></span>
                            </button>
                        </li>

                        <li>
                            <button
                                data-ui-loading-control
                                type="button"
                                id="previous-page"
                                class="inline-flex min-h-11 min-w-11 cursor-pointer items-center justify-center rounded-lg border border-base-300 bg-base-100 p-2 text-center text-primary hover:bg-accent focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-focus"
                                wire:click="previousPage(@js($pageName))"
                                aria-label="Ir para a página anterior"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="16"
                                    height="16"
                                    fill="currentColor"
                                    aria-hidden="true"
                                    focusable="false"
                                    class="bi bi-chevron-compact-left"
                                    viewBox="0 0 16 16"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M9.224 1.553a.5.5 0 0 1 .223.67L6.56 8l2.888 5.776a.5.5 0 1 1-.894.448l-3-6a.5.5 0 0 1 0-.448l3-6a.5.5 0 0 1 .67-.223z"
                                    />
                                </svg>
                                <span data-ui-loading-spinner class="loading hidden loading-xs loading-spinner" aria-hidden="true"></span>
                            </button>
                        </li>

                    @else
                        <li>
                            <button
                                type="button"
                                id="first-page-disabled"
                                disabled
                                aria-label="Primeira página, navegação anterior desabilitada"
                                aria-disabled="true"
                                class="inline-flex min-h-11 min-w-11 items-center justify-center rounded-lg border border-base-300 bg-base-200 p-2 text-center text-base-content/50"
                            >
                                <x-icons.chevron-double-left class="h-4 w-4" />
                            </button>
                        </li>

                        <li>
                            <button
                                type="button"
                                id="previous-page-disabled"
                                disabled
                                aria-label="Página anterior indisponível"
                                aria-disabled="true"
                                class="inline-flex min-h-11 min-w-11 items-center justify-center rounded-lg border border-base-300 bg-base-200 p-2 text-center text-base-content/50"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="16"
                                    height="16"
                                    fill="currentColor"
                                    aria-hidden="true"
                                    focusable="false"
                                    class="bi bi-chevron-compact-left"
                                    viewBox="0 0 16 16"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M9.224 1.553a.5.5 0 0 1 .223.67L6.56 8l2.888 5.776a.5.5 0 1 1-.894.448l-3-6a.5.5 0 0 1 0-.448l3-6a.5.5 0 0 1 .67-.223z"
                                    />
                                </svg>
                            </button>
                        </li>
                    @endif

                    @foreach ($elements as $element)
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($paginator->currentPage() > 3 && $page === 2)
                                    <li>
                                        <div class="mx-1 mt-1 text-base-content" aria-hidden="true">
                                            <span class="font-bold">.</span>
                                            <span class="font-bold">.</span>
                                            <span class="font-bold">.</span>
                                        </div>
                                    </li>
                                @endif

                                @if ($page == $paginator->currentPage())
                                    <li>
                                        <span
                                            class="inline-flex min-h-11 min-w-11 items-center justify-center rounded-lg border border-primary bg-primary p-2 text-center font-semibold text-primary-content"
                                            aria-current="page"
                                            aria-label="Página {{ $page }}, atual"
                                        >
                                            {{ $page }}
                                        </span>
                                    </li>
                                @elseif ($page === $paginator->currentPage() + 1 ||
                                    $page === $paginator->currentPage() + 2 ||
                                    $page === $paginator->currentPage() - 1 ||
                                    $page === $paginator->currentPage() - 2)
                                    <li>
                                        <button
                                            data-ui-loading-control
                                            type="button"
                                            id="go-to-page-{{ $page }}"
                                            class="inline-flex min-h-11 min-w-11 cursor-pointer items-center justify-center rounded-lg border border-base-300 bg-base-100 p-2 text-center text-primary hover:bg-accent focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-focus"
                                            wire:click="gotoPage({{ $page }}, @js($pageName))"
                                            aria-label="Ir para a página {{ $page }}"
                                        >
                                            {{ $page }}
                                            <span
                                                data-ui-loading-spinner
                                                class="loading hidden loading-xs loading-spinner"
                                                aria-hidden="true"
                                            ></span>
                                        </button>
                                    </li>
                                @endif

                                @if ($paginator->currentPage() < $paginator->lastPage() - 2 && $page === $paginator->lastPage() - 1)
                                    <li>
                                        <div class="mx-1 mt-1 text-base-content/75" aria-hidden="true">
                                            <span>.</span>
                                            <span>.</span>
                                            <span>.</span>
                                        </div>
                                    </li>
                                @endif
                            @endforeach

                        @endif
                    @endforeach

                    @if ($paginator->hasMorePages())
                        @if ($paginator->lastPage() - $paginator->currentPage() >= 2)
                            <li>
                                <button
                                    data-ui-loading-control
                                    type="button"
                                    id="endassets"
                                    class="inline-flex min-h-11 min-w-11 cursor-pointer items-center justify-center rounded-lg border border-base-300 bg-base-100 p-2 text-center text-primary hover:bg-accent focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-focus"
                                    wire:click="nextPage(@js($pageName))"
                                    aria-label="Ir para a próxima página"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="16"
                                        height="16"
                                        fill="currentColor"
                                        aria-hidden="true"
                                        focusable="false"
                                        class="bi bi-chevron-compact-right"
                                        viewBox="0 0 16 16"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M6.776 1.553a.5.5 0 0 1 .671.223l3 6a.5.5 0 0 1 0 .448l-3 6a.5.5 0 1 1-.894-.448L9.44 8 6.553 2.224a.5.5 0 0 1 .223-.671z"
                                        />
                                    </svg>
                                    <span
                                        data-ui-loading-spinner
                                        class="loading hidden loading-xs loading-spinner"
                                        aria-hidden="true"
                                    ></span>
                                </button>
                            </li>
                        @endif
                        <li>
                            <button
                                data-ui-loading-control
                                type="button"
                                id="last-page"
                                class="inline-flex min-h-11 min-w-11 cursor-pointer items-center justify-center rounded-lg border border-base-300 bg-base-100 p-2 text-center text-primary hover:bg-accent focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-focus"
                                wire:click="gotoPage({{ $paginator->lastPage() }}, @js($pageName))"
                                aria-label="Ir para a última página"
                            >
                                <x-icons.chevron-double-right class="h-4 w-4" />
                                <span data-ui-loading-spinner class="loading hidden loading-xs loading-spinner" aria-hidden="true"></span>
                            </button>
                        </li>
                    @else
                        <li>
                            <button
                                type="button"
                                id="next-page-disabled"
                                disabled
                                aria-label="Próxima página indisponível"
                                aria-disabled="true"
                                class="inline-flex min-h-11 min-w-11 items-center justify-center rounded-lg border border-base-300 bg-base-200 p-2 text-center text-base-content/50"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="16"
                                    height="16"
                                    fill="currentColor"
                                    aria-hidden="true"
                                    focusable="false"
                                    class="bi bi-chevron-compact-right"
                                    viewBox="0 0 16 16"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M6.776 1.553a.5.5 0 0 1 .671.223l3 6a.5.5 0 0 1 0 .448l-3 6a.5.5 0 1 1-.894-.448L9.44 8 6.553 2.224a.5.5 0 0 1 .223-.671z"
                                    />
                                </svg>
                            </button>
                        </li>

                        <li>
                            <button
                                type="button"
                                id="last-page-disabled"
                                disabled
                                aria-label="Última página, navegação seguinte desabilitada"
                                aria-disabled="true"
                                class="inline-flex min-h-11 min-w-11 items-center justify-center rounded-lg border border-base-300 bg-base-200 p-2 text-center text-base-content/50"
                            >
                                <x-icons.chevron-double-right class="h-4 w-4" />
                            </button>
                        </li>
                    @endif
                </ul>
            </div>
        @endif

        @if ($paginator->hasPages() && $recordCount == 'min')
            <div>
                <div class="items-center justify-between sm:flex">
                    <ul class="flex list-none flex-wrap items-center justify-end gap-1" role="list">
                        <li>
                            {{-- Previous Page Link Disabled --}}
                            @if ($paginator->onFirstPage())
                                <button
                                    type="button"
                                    disabled
                                    aria-label="Primeira página, navegação anterior desabilitada"
                                    aria-disabled="true"
                                    class="inline-flex min-h-11 min-w-11 items-center justify-center rounded-lg border border-base-300 bg-base-200 p-2 text-center text-base-content/50"
                                >
                                    <x-icons.chevron-double-left class="h-4 w-4" />
                                </button>
                            @else
                                @if (method_exists($paginator, 'getCursorName'))
                                    <button
                                        data-ui-loading-control
                                        type="button"
                                        id="set-page-{{ $paginator->previousCursor()->encode() }}"
                                        wire:click="setPage(@js($paginator->previousCursor()->encode()), @js($paginator->getCursorName()))"
                                        aria-label="Ir para a página anterior"
                                        class="inline-flex min-h-11 min-w-11 cursor-pointer items-center justify-center rounded-lg border border-base-300 bg-base-100 p-2 text-center text-primary hover:bg-accent focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-focus"
                                    >
                                        <x-icons.chevron-double-left class="h-4 w-4" />
                                        <span
                                            data-ui-loading-spinner
                                            class="loading hidden loading-xs loading-spinner"
                                            aria-hidden="true"
                                        ></span>
                                    </button>
                                @else
                                    <button
                                        data-ui-loading-control
                                        type="button"
                                        id="previous-page-{{ $paginator->getPageName() }}"
                                        wire:click="previousPage(@js($paginator->getPageName()))"
                                        aria-label="Ir para a página anterior"
                                        class="inline-flex min-h-11 min-w-11 cursor-pointer items-center justify-center rounded-lg border border-base-300 bg-base-100 p-2 text-center text-primary hover:bg-accent focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-focus"
                                    >
                                        <x-icons.chevron-double-left class="h-4 w-4" />
                                        <span
                                            data-ui-loading-spinner
                                            class="loading hidden loading-xs loading-spinner"
                                            aria-hidden="true"
                                        ></span>
                                    </button>
                                @endif
                            @endif
                        </li>

                        <li>
                            {{-- Next Page Link --}}
                            @if ($paginator->hasMorePages())
                                @if (method_exists($paginator, 'getCursorName'))
                                    <button
                                        data-ui-loading-control
                                        type="button"
                                        id="set-page-{{ $paginator->nextCursor()->encode() }}"
                                        wire:click="setPage(@js($paginator->nextCursor()->encode()), @js($paginator->getCursorName()))"
                                        aria-label="Ir para a próxima página"
                                        class="inline-flex min-h-11 min-w-11 cursor-pointer items-center justify-center rounded-lg border border-base-300 bg-base-100 p-2 text-center text-primary hover:bg-accent focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-focus"
                                    >
                                        <x-icons.chevron-double-right class="h-4 w-4" />
                                        <span
                                            data-ui-loading-spinner
                                            class="loading hidden loading-xs loading-spinner"
                                            aria-hidden="true"
                                        ></span>
                                    </button>
                                @else
                                    <button
                                        data-ui-loading-control
                                        type="button"
                                        id="next-page-{{ $paginator->getPageName() }}"
                                        wire:click="nextPage(@js($paginator->getPageName()))"
                                        aria-label="Ir para a próxima página"
                                        class="inline-flex min-h-11 min-w-11 cursor-pointer items-center justify-center rounded-lg border border-base-300 bg-base-100 p-2 text-center text-primary hover:bg-accent focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-focus"
                                    >
                                        <x-icons.chevron-double-right class="h-4 w-4" />
                                        <span
                                            data-ui-loading-spinner
                                            class="loading hidden loading-xs loading-spinner"
                                            aria-hidden="true"
                                        ></span>
                                    </button>
                                @endif
                            @else
                                <button
                                    type="button"
                                    disabled
                                    aria-label="Última página, navegação seguinte desabilitada"
                                    aria-disabled="true"
                                    class="inline-flex min-h-11 min-w-11 items-center justify-center rounded-lg border border-base-300 bg-base-200 p-2 text-center text-base-content/50"
                                >
                                    <x-icons.chevron-double-right class="h-4 w-4" />
                                </button>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        @endif
    </div>
</nav>
