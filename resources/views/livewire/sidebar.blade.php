<div class="finai-navigation">
    <aside id="desktop-sidebar-panel" class="finai-sidebar hidden md:flex" aria-label="Menu lateral">
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

    {{-- Mobile sidebar --}}
    <div>
        <div
            class="relative z-30 bg-base-200 md:hidden"
            x-data="{ asideOpen: true }"
            @keydown.window.escape="mobileAsideOpen = false"
            x-show="mobileAsideOpen"
            aria-label="Menu lateral"
            role="dialog"
            x-ref="dialog"
            aria-modal="true"
        >
            <div class="fixed inset-0 z-15 overflow-hidden">
                <div class="absolute inset-0 overflow-hidden">
                    <div class="pointer-events-none fixed inset-y-0 left-0 flex max-w-full pr-10 sm:pr-16">
                        <div
                            id="mobile-sidebar-panel"
                            x-show="mobileAsideOpen"
                            x-transition:enter="transform transition ease-in-out duration-300"
                            x-transition:enter-start="-translate-x-full"
                            x-transition:enter-end="translate-x-0"
                            x-transition:leave="transform transition ease-in-out duration-300"
                            x-transition:leave-start="translate-x-0"
                            x-transition:leave-end="-translate-x-full"
                            @click.away="mobileAsideOpen = false"
                            class="pointer-events-auto w-screen max-w-(--mobile-sidebar-width)"
                        >
                            <div class="flex h-full flex-col divide-y divide-base-300 bg-base-100 shadow-xl">
                                <div
                                    class="relative flex h-(--navbar-height) items-center justify-between border-b border-base-300 bg-base-100 px-8 sm:px-6"
                                >
                                    <x-ui.application-logo class="block h-9 w-auto" />

                                    <button
                                        type="button"
                                        class="absolute top-2 -right-8"
                                        aria-label="Fechar menu lateral"
                                        @click="mobileAsideOpen = false"
                                    >
                                        <x-icons.x-mark class="z-50 h-6 w-6 cursor-pointer text-base-100" aria-hidden="true" />
                                    </button>
                                </div>

                                <div
                                    x-data="sidebarContext(@js('sidebar-scroll-' . auth()->id() . '-mobile'))"
                                    @scroll.passive="save()"
                                    @resize.window="restore()"
                                    data-sidebar-scroll="mobile"
                                    class="h-0 flex-1 space-y-6 overflow-x-hidden overflow-y-auto py-3"
                                >
                                    @include('livewire.partials.sidebar-groups', ['sidebarMode' => 'mobile'])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div
                x-show="mobileAsideOpen"
                class="fixed inset-0 bg-base-content/65"
                x-transition:enter="transition-opacity ease-linear duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-linear duration-300"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
            ></div>
        </div>
    </div>
</div>
