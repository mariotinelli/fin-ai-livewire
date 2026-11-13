@props([
    'active' => false,
    'icon' => null,
    'neutral' => false,
    'primary' => false,
    'secondary' => false,
    'accent' => false,
    'success' => false,
    'warning' => false,
    'info' => false,
    'error' => false,
    'activeWhen' => null,
])

@php
    $resolvedActiveClass = match (true) {
        $neutral   => 'bg-base-300 text-base-content',
        $secondary => 'bg-secondary/30 text-base-content',
        $accent    => 'bg-accent/30 text-base-content',
        $success   => 'bg-success/30 text-base-content',
        $warning   => 'bg-warning/30 text-base-content',
        $info      => 'bg-info/30 text-base-content',
        $error     => 'bg-error/30 text-base-content',
        $primary   => 'bg-primary/30 text-base-content',
        default    => 'bg-primary/30 text-base-content',
    };

    $inactiveStateClass = 'text-base-content/75 hover:bg-base-200 hover:text-base-content';

    $hasActiveWhen = filled($activeWhen);

    $stateClasses = [];

    if ($active && !$hasActiveWhen && filled($resolvedActiveClass)) {
        $stateClasses[] = $resolvedActiveClass;
    }

    if (!$active && !$hasActiveWhen) {
        $stateClasses[] = $inactiveStateClass;
    }
@endphp

<button
    data-ui-loading-control
    {{
        $attributes->class([
            'tab rounded-md px-4 py-2 text-sm font-medium transition',
            ...$stateClasses,
        ])->merge(['type' => 'button'])
    }}
    @if ($hasActiveWhen)
        x-bind:class="{ [@js($resolvedActiveClass)]: {{ $activeWhen }}, [@js($inactiveStateClass)]: ! ({{ $activeWhen }}) }"
    @endif
>
    @if ($icon)
        <x-dynamic-component :component="'icons.' . $icon" class="me-2 size-5" />
    @endif

    <span>{{ $slot }}</span>
    <span data-ui-loading-spinner class="loading hidden loading-xs loading-spinner" aria-hidden="true"></span>
</button>
