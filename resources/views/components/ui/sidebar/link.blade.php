@props(['route', 'name', 'icon', 'prefix' => null, 'mode' => 'desktop',])

<li
    id="sidebar-link-{{ $mode }}-{{ str($route)->replace('.', '-') }}"
    @class([
        'min-w-[56px] w-full hover:cursor-pointer hover:bg-accent rounded-lg text-secondary hover:cursor-pointer transition-all duration-300 ease-linear',
        'bg-accent text-primary' => request()->routeIs($route) || ($prefix && request()->routeIs($prefix . '.*'))
    ])
    x-bind:class="{ 'tooltip tooltip-bottom': !asideOpen }"
    data-tip="{{ $name }}"
>
    <a
        wire:navigate
        @if (request()->routeIs($route) || ($prefix && request()->routeIs($prefix . '.*')))
            aria-current="page"
        @endif
        aria-label="{{ $name }}"
        href="{{ route($route) }}"
        class="flex items-center gap-2 rounded-lg px-4 py-2.5 hover:bg-accent hover:text-primary"
    >
        <x-dynamic-component :component="'icons.' . $icon" class="h-5.5 min-h-5.5 w-5.5 min-w-5.5 font-medium" />
        <span x-show="asideOpen" class="overflow-hidden text-sm font-semibold text-nowrap text-ellipsis">{{ $name }}</span>
    </a>
</li>
