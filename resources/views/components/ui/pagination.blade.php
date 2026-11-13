<nav data-ui-pagination aria-label="Paginação" class="mt-4 w-full items-center justify-between sm:flex">
    <div class="mb-2 flex flex-row justify-center md:mb-0 md:justify-start">
        <div class="relative h-10">
            <label for="per-page" class="sr-only">Itens por página</label>
            <select
                id="per-page"
                name="per_page"
                wire:model.live="perPage"
                wire:loading.attr="disabled"
                wire:target="perPage"
                aria-label="Itens por página"
                class="block rounded border py-1 pr-2 pl-1 leading-tight text-base-content focus:border-primary focus:bg-base-100 focus:outline-hidden"
            >
                @foreach ($perPageValues as $value)
                    <option value="{{ $value }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>

        <div class="hidden w-full pl-4 sm:block md:block lg:block" style="padding-top: 6px"></div>
    </div>

    <div class="w-full items-center justify-end sm:flex sm:flex-1">
        @if ($recordCount === 'full')
            <div>
                <div class="text-md mr-2 text-center leading-5 text-base-content sm:text-right" aria-live="polite">
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
                <ul class="mt-2 flex list-none justify-center sm:mt-0 md:flex-none md:justify-end" role="list">
                    @if (!$paginator->onFirstPage())
                        <li>
                            <button
                                data-ui-loading-control
                                type="button"
                                id="first-page"
                                class="m-1 cursor-pointer rounded-sm border-1 border-base-content/30 bg-primary px-2 py-1 pt-2 text-center text-primary-content hover:border-base-content/60 hover:bg-primary/80"
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
                                class="m-1 cursor-pointer rounded-sm border-1 border-base-content/30 bg-primary px-2 py-1 pt-2 text-center text-primary-content hover:border-base-content/60 hover:bg-primary/80"
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
                                class="m-1 rounded-sm border-1 border-base-content/30 bg-base-300 px-2 py-1 pt-2 text-center text-base-content/50"
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
                                class="m-1 rounded-sm border-1 border-base-content/30 bg-base-300 px-2 py-1 pt-2 text-center text-base-content/50"
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
                                            class="m-1 inline-flex cursor-pointer items-center justify-center rounded-sm border-1 border-base-content/30 px-2 py-1 text-center"
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
                                            class="m-1 cursor-pointer rounded-sm border-1 border-base-content/30 bg-primary px-2 py-1 text-center text-primary-content hover:border-base-content/60 hover:bg-primary/80"
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
                                    class="m-1 cursor-pointer rounded-sm border-1 border-base-content/30 bg-primary px-2 py-1 pt-2 text-center text-primary-content hover:border-base-content/60 hover:bg-primary/80"
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
                                class="m-1 cursor-pointer rounded-sm border-1 border-base-content/30 bg-primary px-2 py-1 pt-2 text-center text-primary-content hover:border-base-content/60 hover:bg-primary/80"
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
                                class="m-1 rounded-sm border-1 border-base-content/30 bg-base-300 px-2 py-1 pt-2 text-center text-base-content/50"
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
                                class="m-1 rounded-sm border-1 border-base-content/30 bg-base-300 px-2 py-1 pt-2 text-center text-base-content/50"
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
                    <ul class="mt-2 flex list-none justify-center sm:mt-0 md:flex-none md:justify-end" role="list">
                        <li>
                            {{-- Previous Page Link Disabled --}}
                            @if ($paginator->onFirstPage())
                                <button
                                    type="button"
                                    disabled
                                    aria-label="Primeira página, navegação anterior desabilitada"
                                    aria-disabled="true"
                                    class="m-1 rounded-sm border-1 border-base-content/30 bg-base-300 p-2 text-center text-base-content/50"
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
                                        class="m-1 cursor-pointer rounded-sm border-1 border-base-content/30 bg-primary p-2 text-center text-primary-content hover:border-base-content/60 hover:bg-primary/80"
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
                                        class="m-1 cursor-pointer rounded-sm border-1 border-base-content/30 bg-primary p-2 text-center text-primary-content hover:border-base-content/60 hover:bg-primary/80"
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
                                        class="m-1 cursor-pointer rounded-sm border-1 border-base-content/30 bg-primary p-2 text-center text-primary-content hover:border-base-content/60 hover:bg-primary/80"
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
                                        class="m-1 cursor-pointer rounded-sm border-1 border-base-content/30 bg-primary p-2 text-center text-primary-content hover:border-base-content/60 hover:bg-primary/80"
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
                                    class="m-1 rounded-sm border-1 border-base-content/30 bg-base-300 p-2 text-center text-base-content/50"
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
