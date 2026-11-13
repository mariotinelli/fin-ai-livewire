<main
    @class([
        'inset-0 transition-all duration-300 ease-linear overflow-y-auto p-8 mx-auto',
        'h-[calc(100dvh-var(--dev-bar-height)-var(--navbar-height))]' => withEnvBar(),
        'h-[calc(100dvh-var(--navbar-height))]' => !withEnvBar()
    ])
    x-bind:class="{
        'lg:ml-(--open-sidebar-width) lg:w-[calc(100vw-var(--open-sidebar-width))]': asideOpen,
        'lg:ml-(--closed-sidebar-width) lg:w-[calc(100vw-var(--closed-sidebar-width))]': !asideOpen,
    }"
>
    {{ $slot }}
</main>
