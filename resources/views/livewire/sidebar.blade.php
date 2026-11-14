<div class="finai-navigation">
    <aside
        id="desktop-sidebar-panel"
        class="finai-sidebar hidden md:flex md:h-(--app-height) md:flex-col md:gap-8 md:pt-[calc(1.5rem+env(safe-area-inset-top,0px))] md:pr-0 md:pb-[calc(1rem+env(safe-area-inset-bottom,0px))] md:pl-[env(safe-area-inset-left,0px)]"
        :class="{ 'min-[64.0625rem]:gap-4': !asideOpen }"
        aria-label="Menu lateral"
    >
        <div class="flex shrink-0 items-center justify-between gap-2" :class="asideOpen ? 'px-4' : 'justify-center'">
            <a
                id="home-link"
                href="{{ route('dashboard') }}"
                aria-label="FinAI — início"
                class="flex min-h-12 min-w-12 items-center rounded-lg"
            >
                <span x-show="asideOpen"><x-ui.application-logo class="block h-10 w-30" /></span>
                <span x-show="!asideOpen" class="block h-10 w-10 overflow-hidden">
                    <x-ui.application-logo class="block h-10 w-30 max-w-none" />
                </span>
            </a>
            <button
                type="button"
                aria-label="Alternar menu lateral"
                aria-controls="desktop-sidebar-panel"
                :aria-expanded="asideOpen ? 'true' : 'false'"
                @click="toggleSidebar()"
                class="sidebar-toggle hidden h-12 w-12 shrink-0 cursor-pointer items-center justify-center rounded-lg text-secondary hover:bg-accent hover:text-primary min-[1025px]:flex"
                x-show="asideOpen"
            >
                <x-icons.chevron-left class="h-5 w-5" aria-hidden="true" />
            </button>
        </div>
        <button
            x-show="!asideOpen"
            type="button"
            aria-label="Expandir menu lateral"
            aria-controls="desktop-sidebar-panel"
            :aria-expanded="asideOpen ? 'true' : 'false'"
            @click="toggleSidebar()"
            class="sidebar-toggle hidden h-12 w-12 shrink-0 cursor-pointer items-center justify-center self-center rounded-lg text-secondary hover:bg-accent hover:text-primary min-[1025px]:flex"
        >
            <x-icons.chevron-right class="h-5 w-5" aria-hidden="true" />
        </button>
        <nav
            aria-label="Navegação principal"
            x-data="sidebarContext(@js('sidebar-scroll-' . auth()->id() . '-desktop'))"
            @scroll.passive="save()"
            @resize.window="restore()"
            data-sidebar-scroll="desktop"
            class="min-h-0 flex-1 space-y-6 overflow-x-hidden overflow-y-auto px-2 py-2"
        >
            @include('livewire.partials.sidebar-groups', ['sidebarMode' => 'desktop'])
        </nav>
    </aside>

    <nav
        id="mobile-navigation"
        aria-label="Navegação principal no celular"
        class="fixed inset-x-0 bottom-0 z-10 grid h-[calc(3.5rem+env(safe-area-inset-bottom,0px))] auto-cols-fr grid-flow-col items-center gap-2 border-t border-base-300 bg-base-100 pt-1 pr-[max(1rem,env(safe-area-inset-right,0px))] pb-[calc(.25rem+env(safe-area-inset-bottom,0px))] pl-[max(1rem,env(safe-area-inset-left,0px))] shadow-lg md:hidden"
    >
        @foreach ($this->mobileItems as $item)
            <a
                wire:navigate
                href="{{ route($item->route) }}"
                aria-label="{{ $item->name }}"
                @if (request()->routeIs($item->route) || ($item->prefix && request()->routeIs($item->prefix . '.*')))
                    aria-current="page"
                @endif
                class="flex min-h-11 min-w-11 items-center justify-center rounded-lg text-secondary hover:bg-accent hover:text-primary aria-[current=page]:bg-accent aria-[current=page]:text-primary"
            >
                <x-dynamic-component :component="'icons.' . $item->icon" class="size-6" aria-hidden="true" />
            </a>
        @endforeach
        @if ($this->groups)
            <div class="flex justify-center">
                <x-ui.dropdown id="mobile-destinations" top end width="w-80">
                    <x-slot name="trigger">
                        <button
                            type="button"
                            aria-label="Todos os destinos"
                            class="flex min-h-11 min-w-11 items-center justify-center rounded-lg text-secondary hover:bg-accent hover:text-primary aria-expanded:bg-accent aria-expanded:text-primary"
                        >
                            <x-icons.bars-3 class="size-6" aria-hidden="true" />
                        </button>
                    </x-slot>
                    <x-slot name="header">
                        Navegação
                    </x-slot>
                    @foreach ($this->groups as $group)
                        <div role="group" aria-label="{{ $group->label ?? 'Principal' }}" class="p-2">
                            @if ($group->label)
                                <div class="px-3 py-2 text-sm font-semibold text-secondary">{{ $group->label }}</div>
                            @endif
                            @foreach ($group->items as $item)
                                <a
                                    wire:navigate
                                    role="menuitem"
                                    href="{{ route($item->route) }}"
                                    @if (request()->routeIs($item->route) || ($item->prefix && request()->routeIs($item->prefix . '.*')))
                                        aria-current="page"
                                    @endif
                                    class="flex min-h-11 items-center gap-3 rounded-lg px-3 py-2 text-secondary hover:bg-accent hover:text-primary aria-[current=page]:bg-accent aria-[current=page]:text-primary"
                                >
                                    <x-dynamic-component :component="'icons.' . $item->icon" class="size-6 shrink-0" aria-hidden="true" />
                                    <span class="min-w-0 wrap-anywhere">{{ $item->name }}</span>
                                </a>
                            @endforeach
                        </div>
                    @endforeach
                </x-ui.dropdown>
            </div>
        @endif
    </nav>
</div>
