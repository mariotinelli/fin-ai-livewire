<nav
    x-data="{ name: @js(user()->name), initials: @js(user()->initials) }"
    x-on:profile::updated.window="
        name = $event.detail.name;
        initials = $event.detail.initials;
    "
    class="finai-topbar z-10 flex h-(--navbar-height) shrink-0 items-center justify-between border-b border-base-300 bg-base-100 px-4 sm:px-8 md:justify-end md:rounded-t-box md:bg-transparent min-[90rem]:px-12"
>
    <button
        id="toggle-sidebar"
        type="button"
        class="flex min-h-11 min-w-11 items-center justify-center rounded-field text-secondary md:hidden"
        aria-label="Abrir menu lateral"
        aria-controls="mobile-sidebar-panel"
        x-bind:aria-expanded="mobileAsideOpen ? 'true' : 'false'"
        @click="mobileAsideOpen = !mobileAsideOpen"
    >
        <x-icons.bars-3 class="h-6 w-6 cursor-pointer text-secondary" aria-hidden="true" />
    </button>

    <div class="flex items-center gap-4">
        <livewire:notifications />

        <x-ui.dropdown end bottom>
            <x-slot name="trigger">
                <x-ui.button
                    id="open-user-menu"
                    white
                    sm
                    circle
                    aria-label="Abrir menu da conta"
                    class="border-base-300! bg-base-200! text-primary!"
                >
                    <span class="p-0" x-text="initials">{{ user()->initials }}</span>
                </x-ui.button>
            </x-slot>
            <x-slot name="header">
                <div class="flex items-center gap-2">
                    <x-icons.solid.user-circle class="h-6 w-6" />
                    <span x-text="name">{{ user()->name }}</span>
                </div>
            </x-slot>

            <x-ui.dropdown.link :route="user()->type->profileRouteName()" icon="user" name="Perfil" />

            <livewire:auth.logout />
        </x-ui.dropdown>
    </div>
</nav>
