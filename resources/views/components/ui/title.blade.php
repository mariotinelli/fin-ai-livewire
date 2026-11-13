@props([
    'lg' => false,
    'md' => false,
    'sm' => false,
])

<h1
    {{
    $attributes->class([
        'tracking-tight text-base-content',
        'font-display text-[clamp(2rem,3vw,2.5rem)] leading-tight font-normal tracking-[-1px]'    => $lg,
        'text-xl sm:text-1xl font-semibold' => $md,
        'text-md sm:text-xl'                => $sm,
    ])
}}
>
    {{ $slot }}
</h1>
