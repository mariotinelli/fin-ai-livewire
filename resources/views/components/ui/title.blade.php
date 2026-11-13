@props([
    'lg' => false,
    'md' => false,
    'sm' => false,
])

<h1
    {{
    $attributes->class([
        'tracking-tight text-base-content',
        'text-2xl sm:text-3xl font-bold'    => $lg,
        'text-xl sm:text-1xl font-semibold' => $md,
        'text-md sm:text-xl'                => $sm,
    ])
}}
>
    {{ $slot }}
</h1>
