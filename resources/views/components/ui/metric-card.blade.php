@props([
    'label',
    'value' => null,
    'description' => null,
    'period' => null,
    'comparison' => null,
    'comparisonLabel' => null,
    'chart' => null,
    'chartLabel' => null,
    'emptyValue' => '—',
    'headingLevel' => 'h3',
])

@php
    $hasComparison     = is_int($comparison) || is_float($comparison);
    $comparisonValue   = $hasComparison ? (float) $comparison : null;
    $comparisonState   = $comparisonValue === null ? null : ($comparisonValue <=> 0.0);
    $comparisonDisplay = $comparisonLabel ?? ($comparisonState === 1 ? '+' : '') . $comparison;

    $chartPoints = collect(is_array($chart) ? $chart : [])
        ->filter(fn (mixed $point): bool => is_numeric($point) && is_finite((float) $point))
        ->map(fn (mixed $point): float => (float) $point)
        ->values();

    $chartMinimum = $chartPoints->min();
    $chartMaximum = $chartPoints->max();
    $chartRange   = is_float($chartMinimum) && is_float($chartMaximum) ? $chartMaximum - $chartMinimum : 0.0;

    $sparklinePoints = $chartPoints
        ->map(function (float $point, int $index) use ($chartPoints, $chartMinimum, $chartRange): string {
            $x = $chartPoints->count() === 1 ? 50.0 : 2.0 + (($index / ($chartPoints->count() - 1)) * 96.0);
            $y = $chartRange === 0.0 ? 16.0 : 30.0 - ((($point - $chartMinimum) / $chartRange) * 28.0);

            return number_format($x, 2, '.', '') . ',' . number_format($y, 2, '.', '');
        })
        ->implode(' ');

    $accessibleChartLabel = $chartLabel ?? __('Tendência: :values', [
        'values' => $chartPoints->map(fn (float $point): string => (string) $point)->implode(', '),
    ]);
@endphp

<x-ui.card
    :header="$label"
    :description="$description"
    :heading-level="$headingLevel"
    as-article
    {{ $attributes->class('h-full overflow-hidden') }}
>
    <div class="flex min-w-0 flex-col gap-4">
        <div class="flex min-w-0 flex-wrap items-start justify-between gap-3">
            <p class="min-w-0 text-3xl font-semibold tracking-tight break-words text-base-content">
                @if ($value === null)
                    <span aria-label="{{ __('Sem dados') }}">{{ $emptyValue }}</span>
                @else
                    {{ $value }}
                @endif
            </p>

            @if ($hasComparison)
                <span
                    data-comparison="{{ match ($comparisonState) { 1 => 'positive', -1 => 'negative', default => 'neutral' } }}"
                    @class([
                        'inline-flex shrink-0 items-center gap-1 rounded-full px-2 py-1 text-xs font-semibold',
                        'bg-base-100 text-success ring-1 ring-inset ring-success/20' => $comparisonState === 1,
                        'bg-base-100 text-error ring-1 ring-inset ring-error/20' => $comparisonState === -1,
                        'bg-base-200 text-base-content' => $comparisonState === 0
                    ])
                >
                    @if ($comparisonState === 0)
                        <x-icons.minus class="size-3" aria-hidden="true" />
                    @else
                        <x-icons.solid.arrow-trending-up @class(['size-3', 'rotate-180' => $comparisonState === -1]) aria-hidden="true" />
                    @endif

                    {{ $comparisonDisplay }}
                </span>
            @endif
        </div>

        @if ($chartPoints->isNotEmpty())
            <svg
                class="h-8 w-full overflow-visible text-primary"
                viewBox="0 0 100 32"
                preserveAspectRatio="none"
                role="img"
                aria-label="{{ $accessibleChartLabel }}"
            >
                @if ($chartPoints->count() === 1)
                    <circle cx="50" cy="16" r="2" fill="currentColor" />
                @else
                    <polyline
                        points="{{ $sparklinePoints }}"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        vector-effect="non-scaling-stroke"
                    />
                @endif
            </svg>
        @endif

        @if ($period)
            <p class="text-xs font-medium text-base-content/65">{{ $period }}</p>
        @endif
    </div>
</x-ui.card>
