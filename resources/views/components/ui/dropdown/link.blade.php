@props(['route', 'name', 'icon',])

<li
    role="none"
    class="w-full min-w-[56px] rounded-lg text-base-content/65 transition-all duration-300 ease-linear hover:cursor-pointer hover:bg-base-200"
>
    <a
        id="user-menu-{{ str($route)->replace('.', '-') }}"
        href="{{ route($route) }}"
        role="menuitem"
        tabindex="0"
        {{ $attributes->merge(['class' => "flex items-center gap-2 hover:bg-base-200 rounded-lg p-2"]) }}
    >
        <x-dynamic-component :component="'icons.' . $icon" class="h-6 min-h-6 w-6 min-w-6" aria-hidden="true" />

        <span class="font-semibold"> {{ $name }} </span>
    </a>
</li>
