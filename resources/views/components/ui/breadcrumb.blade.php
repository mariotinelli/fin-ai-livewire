@props([
    'items' => [],
])

@if (!empty($items))
    <nav aria-label="Breadcrumb" class="mb-5 min-w-0">
        <ol class="flex min-w-0 items-center gap-1 text-base-content/65">
            <li class="shrink-0">
                <a id="breadcrumb-home" href="{{ route('home') }}" aria-label="Página inicial">
                    <x-icons.mini.home class="mb-0.5 size-5!" aria-hidden="true" />
                    <span class="sr-only">Página inicial</span>
                </a>
            </li>

            @foreach ($items as $item)
                @php
                    if (is_string($item)) {
                        $item = ['label' => $item];
                    }

                    $isCurrentPage = $loop->last;
                @endphp

                <li
                    @class([
                        'min-w-0 flex-1 items-center gap-1 sm:max-w-96 sm:flex-initial',
                        'hidden sm:flex' => $loop->remaining > 1,
                        'flex' => $loop->remaining <= 1
                    ])
                >
                    <x-icons.mini.chevron-right class="size-5 shrink-0" aria-hidden="true" />

                    @if (isset($item['route']) && !$isCurrentPage)
                        <a
                            href="{{ $item['route'] }}"
                            id="{{ 'breadcrumb-' . str($item['label'])->kebab()->lower() }}"
                            data-breadcrumb-label
                            title="{{ $item['label'] }}"
                            class="text-md block min-w-0 truncate font-semibold text-base-content/65 hover:text-base-content"
                        >
                            {{ $item['label'] }}
                        </a>
                    @else
                        <span
                            id="{{ 'breadcrumb-' . str($item['label'])->kebab()->lower() }}"
                            data-breadcrumb-label
                            title="{{ $item['label'] }}"
                            class="text-md block min-w-0 truncate font-semibold text-base-content/65"
                            @if ($isCurrentPage)
                                aria-current="page"
                            @endif
                        >
                            {{ $item['label'] }}
                        </span>
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>
@endif
