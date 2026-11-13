@use(Illuminate\Support\HtmlString)
@use(Illuminate\View\ComponentSlot)

@props([
    'label' => null,
    'xs' => false,
    'sm' => false,
    'md' => false,
    'lg' => false,
    'primary' => false,
    'secondary' => false,
    'accent' => false,
    'neutral' => false,
    'info' => false,
    'success' => false,
    'warning' => false,
    'error' => false,
    'outline' => false,
    'ghost' => false,
    'color' => null,
    'circle' => false,
    'addDot' => false,
    'animateDot' => false,
    'icon' => null,
    'rightIcon' => false,
])

<span
    {{
    $attributes->class([
        'badge text-nowrap !font-medium border-none ring-1 ring-inset !h-fit flex items-center justify-center gap-x-1',
        'badge-xs'                                         => $xs,
        'badge-sm'                                         => $sm,
        'badge-md'                                         => $md,
        'badge-lg'                                         => $lg,
        'py-1! px-2! rounded-md!'                          => !$circle,
        'bg-primary/10 text-primary ring-primary/20'       => $primary || $color == 'primary',
        'bg-secondary/10 text-secondary ring-secondary/30' => $secondary || $color == 'secondary',
        'bg-accent/10 text-accent ring-accent/30'          => $accent || $color == 'accent',
        'bg-neutral/10 text-neutral ring-neutral/30'       => $neutral || $color == 'neutral',
        'bg-info/10 text-info ring-info/30'                => $info || $color == 'info',
        'bg-success/10 text-success ring-success/30'       => $success || $color == 'success',
        'bg-warning/10 text-warning ring-warning/30'       => $warning || $color == 'warning',
        'bg-error/10 text-error ring-error/30'             => $error || $color == 'error',
        'bg-transparent! ring-0!'                          => $ghost,
        'bg-transparent!'                                  => $outline,
        'rounded-full!'                                    => $circle,
        'px-[4px]! py-[1px]!'                              => $xs && $circle,
        'px-[5px]! py-0!'                                  => $sm && $circle,
    ])
}}
>
    @if (!$rightIcon && $icon)
        @if (!($icon instanceof HtmlString) && !($icon instanceof ComponentSlot))
            <x-dynamic-component :component="'icons.' . $icon" class="size-4!" />
        @else
            {{ $icon }}
        @endif
    @endif

    @if ($addDot)
        <span @class(['pr-1 text-xl font-semibold', 'animate-pulse' => $animateDot])>• </span>
    @endif

    {{ $label ?: $slot }}

    @if ($rightIcon && $icon)
        @if (!($icon instanceof HtmlString) && !($icon instanceof ComponentSlot))
            <x-dynamic-component :component="'icons.' . $icon" class="size-4!" />
        @else
            {{ $icon }}
        @endif
    @endif
</span>
