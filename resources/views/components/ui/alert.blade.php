@props([
    'title',
    'icon' => null,
    'success' => false,
    'warning' => false,
    'info' => false,
    'error' => false,
    'color' => null,
    'soft' => false,
    'outline' => false,
    'dash' => false,
])

<div
    role="alert"
    aria-live="{{ $error || $color === 'error' ? 'assertive' : 'polite' }}"
    aria-atomic="true"
    @class([
        'alert',
        'alert-success' => $success || $color == 'success',
        'alert-warning' => $warning || $color == 'warning',
        'alert-info' => $info || $color == 'info',
        'alert-error' => $error || $color == 'error',
        'alert-soft' => $soft,
        'alert-outline' => $outline
    ])
>
    <div class="flex flex-col gap-2">
        <div class="flex items-center gap-2">
            @if ($icon)
                <x-dynamic-component :component="'icons.' . $icon" class="size-5!" aria-hidden="true" />
            @elseif ($success || $color == 'success')
                <x-icons.check-circle class="size-5" aria-hidden="true" />
            @elseif ($warning || $color == 'warning')
                <x-icons.exclamation-triangle class="size-5" aria-hidden="true" />
            @elseif ($info || $color == 'info')
                <x-icons.information-circle class="size-5" aria-hidden="true" />
            @elseif ($error || $color == 'error')
                <x-icons.x-circle class="size-5" aria-hidden="true" />
            @endif

            <strong class="font-semibold">{{ $title }}</strong>
        </div>

        {{ $slot }}
    </div>
</div>
