@props(['whiteHorizontal' => false])

<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 40" role="img" aria-label="FinAI" {{ $attributes->class(['text-primary-content' => $whiteHorizontal, 'text-base-content' => ! $whiteHorizontal]) }}>
    <rect width="40" height="40" rx="12" @class(['fill-primary' => ! $whiteHorizontal, 'fill-primary-content' => $whiteHorizontal]) />
    <svg x="8" y="8" width="24" height="24" viewBox="0 0 24 24" fill="none" @class(['stroke-primary-content' => ! $whiteHorizontal, 'stroke-primary' => $whiteHorizontal]) stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M5 18V6h14M5 12h10M10 18l4-4 3 2 4-6" />
    </svg>
    <text x="48" y="30" fill="currentColor" font-family="system-ui, sans-serif" font-size="28" font-weight="700" letter-spacing="-1" aria-hidden="true">fin<tspan @class(['fill-primary' => ! $whiteHorizontal, 'fill-primary-content' => $whiteHorizontal]) font-weight="400">ai</tspan></text>
</svg>
