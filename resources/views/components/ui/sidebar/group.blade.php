@props(['name', 'open' => true, 'context' => null, 'mode' => 'desktop',])

<li
    id="group-{{ $mode }}-{{ Str::slug($context ?? $name) }}"
    x-data="sidebarGroup(@js('sidebar-group-' . auth()->id() . '-' . ($context ?? Str::slug($name))), @js($open))"
    @sidebar-group-changed.window="sync($event.detail)"
    class="list-none text-base-content"
>
    <div>
        <button
            type="button"
            class="flex w-full cursor-pointer items-center justify-between px-4 pb-3 text-left"
            x-show="asideOpen"
            @click="toggle()"
            :aria-expanded="expanded ? 'true' : 'false'"
            aria-controls="group-links-{{ $mode }}-{{ Str::slug($context ?? $name) }}"
        >
            <span class="font-medium text-base-content/65">{{ $name }}</span>
            <x-icons.chevron-up class="h-4 w-4 transition-all duration-600 ease-linear" x-bind:class="expanded ? '' : 'rotate-180'" />
        </button>

        <ul
            id="group-links-{{ $mode }}-{{ Str::slug($context ?? $name) }}"
            class="relative space-y-1"
            x-show="expanded || !asideOpen"
            x-collapse.duration.200ms
            x-bind:class="asideOpen ? 'ml-7 px-2' : 'px-4'"
        >
            <span x-show="expanded" class="absolute top-0 bottom-0 left-0 w-px bg-base-300"></span>

            {{ $slot }}
        </ul>
    </div>
</li>
