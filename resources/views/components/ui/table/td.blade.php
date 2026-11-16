@props(['label' => null, 'size' => 'md', 'limited' => true])

@php
    $maxWidth = match ($size) {
        'sm' => 'max-w-24',
        'md' => 'max-w-60',
        'lg' => 'max-w-72',
        'xl' => 'max-w-104',
        default => throw new InvalidArgumentException("Tamanho de coluna de tabela inválido: {$size}."),
    };
@endphp

<td {{ $attributes->class(['py-4 text-sm text-base-content px-4 sm:px-6 whitespace-nowrap']) }}>
    @if ($label !== null)
        <span
            @if ($limited) data-table-cell-text data-tip="{{ $label }}" @endif
            @class(['block', 'truncate' => $limited, $maxWidth => $limited])
        >
            {{ $slot->isEmpty() ? $label : $slot }}
        </span>
    @else
        {{ $slot }}
    @endif
</td>
