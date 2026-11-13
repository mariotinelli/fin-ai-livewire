@props([
    'label' => null,
    'neutral' => false,
    'primary' => false,
    'secondary' => false,
    'accent' => false,
    'success' => false,
    'warning' => false,
    'info' => false,
    'error' => false,
    'white' => false,
    'hover' => false,
    'ghost' => false,
    'link' => false,
    'active' => false,
    'outline' => false,
    'noAnimation' => false,
    'xs' => false,
    'sm' => false,
    'md' => false,
    'lg' => false,
    'wide' => false,
    'block' => false,
    'circle' => false,
    'square' => false,
    'loading' => null,
    'icon' => null,
    'withLoading' => true,
    'href' => false,
    'rightIcon' => false,
    'uppercase' => false,
    'soft' => false,
    'inputAction' => false,
    'cancelButton' => false,
    'navigate' => true,
])

@php
    $loadingTarget = $attributes->get('wire:target');

    if (!$loadingTarget && ($wireClick = $attributes->get('wire:click'))) {
        $loadingTarget = $wireClick;
    }

    if ($loading) {
        $loadingTarget = $loading;
    }

    $visibleLabel = $label ?: trim($slot);
    $accessibleName = $attributes->get('aria-label') ?: $visibleLabel;
@endphp

@if ($href)
    <a href="{{ $href }}"
       @if($navigate) wire:navigate @endif
       @if(!$accessibleName && $icon) aria-label="{{ $icon }}" @endif
@else
    <button
        @if (!$accessibleName && $icon) aria-label="{{ $icon }}" @endif
        @if ($loadingTarget && !$attributes->has('wire:target')) wire:target="{{ $loadingTarget }}" @endif
        @endif
        data-ui-loading-control
        @if ($loadingTarget) data-ui-loading-target="{{ $loadingTarget }}" @endif
        {{
            $attributes->class([
                'btn normal-case rounded-sm flex items-center disabled:cursor-not-allowed',
                'btn-neutral'                                                                                                                  => $neutral,
                'btn-primary'                                                                                                                  => $primary,
                'btn-secondary'                                                                                                                => $secondary,
                'btn-accent'                                                                                                                   => $accent,
                'btn-success'                                                                                                                  => $success,
                'btn-warning'                                                                                                                  => $warning,
                'btn-info'                                                                                                                     => $info,
                'btn-error'                                                                                                                    => $error,
                'btn-hover'                                                                                                                    => $hover,
                'btn-ghost'                                                                                                                    => $ghost,
                'btn-link'                                                                                                                     => $link,
                'btn-active'                                                                                                                   => $active,
                'btn-outline'                                                                                                                  => $outline,
                'no-animation'                                                                                                                 => $noAnimation,
                'btn-xs'                                                                                                                       => $xs,
                'btn-sm'                                                                                                                       => $sm,
                'btn-md'                                                                                                                       => $md || (!$xs && !$sm && !$lg),
                'btn-lg'                                                                                                                       => $lg,
                'btn-wide'                                                                                                                     => $wide,
                'btn-block'                                                                                                                    => $block,
                'btn-circle!'                                                                                                                  => $circle,
                'btn-square'                                                                                                                   => $square,
                'bg-base-100 text-base-content hover:bg-base-100 hover:text-base-content disabled:text-base-content/40 disabled:border-none border-base-300' => $white,
                'uppercase! tracking-wider! text-xs! font-bold!'                                                                               => $uppercase,
                'btn-soft'                                                                                                                     => $soft,
                'btn-ghost hover:bg-base-200'                                                                                                  => $cancelButton,
                'border-0! shadow-none! bg-transparent! hover:bg-transparent! hover:border-0! hover:outline-0! focus:outline-0! focus:ring-0!' => $inputAction,
            ])->merge(['type' => 'button'])
        }}
    >
        @if ($icon && !$rightIcon)
        <x-dynamic-component :component="'icons.' . $icon" class="size-4!" aria-hidden="true" />

@endif

@if ($visibleLabel)
    <span>{{ $label ?: $slot }}</span>
@endif

@if ($icon && $rightIcon)
    <x-dynamic-component :component="'icons.' . $icon" class="size-4!" aria-hidden="true" />
@endif

@if ($withLoading)
    <span data-ui-loading-spinner class="loading hidden loading-xs loading-spinner" aria-hidden="true"></span>

@endif

@if ($href)
    </a>
@else
    </button>
@endif
