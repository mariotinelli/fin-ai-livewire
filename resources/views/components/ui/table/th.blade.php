@use('App\Enums\SortDirection')

@props([
    'name' => null,
    'upperCase' => true,
    'colspan' => null,
    'scope' => null,
    'textAlign' => 'left',
    'inline' => true,
    'withSort' => true,
])

@php($isSortable = $name && $withSort)
@php($resolvedScope = $scope ?? 'col')
@php($isSortedColumn = $isSortable && $this->sortKeyName === $name)
@php($ariaSort = $isSortable ? ($isSortedColumn ? ($this->sortDirection === SortDirection::Asc->value ? 'ascending' : 'descending') : 'none') : null)
@php($columnLabel = trim(strip_tags((string) $slot)) ?: 'coluna')
@php($sortAriaLabel = $isSortedColumn
        ? sprintf(
            'Ordenar por %s. Ordenação atual: %s.',
            $columnLabel,
            $this->sortDirection === SortDirection::Asc->value ? 'crescente' : 'decrescente'
        )
        : sprintf('Ordenar por %s.', $columnLabel))

<th
    scope="{{ $resolvedScope }}"
    @if ($ariaSort) aria-sort="{{ $ariaSort }}" @endif
    @if ($colspan) colspan="{{ $colspan }}" @endif
    {{ $attributes->class(['text-xs px-7 py-2.5'])->only('class') }}
>
    @if ($isSortable)
        <button
            data-ui-loading-control
            type="button"
            wire:click="sortBy(@js($name))"
            aria-label="{{ $sortAriaLabel }}"
            @class(['group flex h-6 w-full cursor-pointer items-center gap-1 text-base-content', 'uppercase' => $upperCase])
            {{ $attributes->except('class') }}
        >
            <span
                @class([
                    'tracking-widest',
                    'whitespace-nowrap' => $inline,
                    'text-left' => $textAlign === 'left',
                    'w-full text-center' => $textAlign === 'center',
                    'text-right' => $textAlign === 'right'
                ])
            >
                {{ $slot }}
            </span>

            @if ($isSortedColumn)
                <x-dynamic-component
                    :component="$this->sortDirection === SortDirection::Asc->value ? 'icons.chevron-up' : 'icons.chevron-down'"
                    class="size-3! text-base-content/50"
                />
            @else
                <x-icons.chevron-up-down class="size-3! text-base-content/50" />
            @endif
            <span data-ui-loading-spinner class="loading hidden loading-xs loading-spinner" aria-hidden="true"></span>
        </button>
    @else
        <div @class(['group flex h-6 items-center gap-1 text-base-content', 'uppercase' => $upperCase]) {{ $attributes->except('class') }}>
            <span
                @class([
                    'tracking-widest',
                    'whitespace-nowrap' => $inline,
                    'text-left' => $textAlign === 'left',
                    'w-full text-center' => $textAlign === 'center',
                    'text-right' => $textAlign === 'right'
                ])
            >
                {{ $slot }}
            </span>
        </div>
    @endif
</th>
