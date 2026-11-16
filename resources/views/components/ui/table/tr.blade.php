@props([
    'textAlign' => 'left',
])

<tr
    {{
    $attributes->class([
        'bg-base-100 transition-colors hover:bg-accent/30 focus-within:bg-accent/30',
        'text-left'          => $textAlign === 'left',
        'w-full text-center' => $textAlign === 'center',
        'text-right'         => $textAlign === 'right',
    ])
}}
>
    {{ $slot }}
</tr>
