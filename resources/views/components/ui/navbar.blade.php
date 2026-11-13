<nav
    x-data="{ name: @js(user()->name), initials: @js(user()->initials) }"
    x-on:profile::updated.window="
        name = $event.detail.name;
        initials = $event.detail.initials;
    "
    @class([
        'z-10 flex h-(--navbar-height) items-center justify-between bg-primary px-8 shadow-sm sticky',
        'top-(--dev-bar-height)' => withEnvBar(),
        'top-0' => !withEnvBar()
    ])
>
    <a id="home-link" href="{{ route('dashboard') }}" class="hidden lg:block">
        <x-ui.application-logo class="block h-20 w-auto!" whiteHorizontal />
    </a>

    <button
        id="toggle-sidebar"
        type="button"
        class="block lg:hidden"
        aria-label="Abrir menu lateral"
        aria-controls="mobile-sidebar-panel"
        x-bind:aria-expanded="mobileAsideOpen ? 'true' : 'false'"
        @click="mobileAsideOpen = !mobileAsideOpen"
    >
        <x-icons.bars-3 class="h-6 w-6 cursor-pointer text-primary-content" aria-hidden="true" />
    </button>

    <div class="flex items-center gap-4">
        <livewire:notifications />

        <x-ui.dropdown end bottom>
            <x-slot name="trigger">
                <x-ui.button id="open-user-menu" white sm circle class="border-none!">
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
