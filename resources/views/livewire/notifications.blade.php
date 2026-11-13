<div>
    <div class="relative mr-2">
        <button
            type="button"
            id="open-notifications"
            @click="$wire.$set('sidepageOpen', true, false)"
            aria-label="Abrir notificações"
            wire:loading.attr="disabled"
            wire:target="loadNotifications"
            class="relative block h-7 w-7 cursor-pointer text-primary-content hover:text-primary-content/80 disabled:cursor-wait"
        >
            <span wire:loading.remove wire:target="loadNotifications">
                <x-icons.bell class="h-7 w-7" aria-hidden="true" />
            </span>
            <span wire:loading.flex wire:target="loadNotifications" class="absolute inset-0 items-center justify-center" role="status">
                <span class="loading loading-xs loading-spinner" aria-hidden="true"></span>
                <span class="sr-only">Carregando notificações...</span>
            </span>
        </button>
        @if ($this->unviewedNotificationsCount > 0)
            <x-ui.badge
                circle
                sm
                aria-label="{{ $this->unviewedNotificationsCount }} notificações não visualizadas"
                title="Não visualizadas"
                class="absolute -top-3 -right-3 border-secondary bg-secondary font-semibold text-secondary-content"
            >
                {{ $this->unviewedNotificationsCount > 99 ? '99+' : $this->unviewedNotificationsCount }}
            </x-ui.badge>
        @endif
    </div>

    @teleport('body')
        <x-ui.sidepage title="Notificações" md :scrollable="false">
            <div x-data="notificationPanel()" class="flex h-full min-h-0 flex-col" data-notifications-panel>
                <div class="shrink-0 border-b border-base-300 p-4">
                    <div class="mb-4 flex items-center justify-between">
                        <h1 class="text-lg font-semibold">Notificações</h1>
                        <button
                            data-ui-no-loading
                            type="button"
                            id="close-notifications"
                            class="cursor-pointer"
                            aria-label="Fechar notificações"
                            x-bind:disabled="!canClose()"
                            @click="requestClose()"
                        >
                            <x-icons.x-mark class="h-6 w-6" aria-hidden="true" />
                        </button>
                    </div>
                    @if ($sidepageOpen)
                        <div :class="{ invisible: loading || loadError }" :inert="loading || loadError">
                            <x-notifications.actions />
                        </div>
                    @endif
                </div>

                <div class="min-h-0 flex-1 overflow-y-auto overscroll-contain" data-notifications-list :aria-busy="loading">
                    <x-notifications.loading />
                    <div x-cloak x-show="loadError" role="status" class="p-6 text-center text-sm">
                        <p>Não foi possível carregar as notificações.</p>
                        <x-ui.button link primary sm class="mt-2" @click="load()" x-bind:data-ui-button-loading="loading">
                            Tentar novamente</x-ui.button
                        >
                    </div>
                    <div x-show="!loading && !loadError">
                        @if ($sidepageOpen && $notificationsLoaded)
                            @if (count($this->notifications) === 0)
                                <x-notifications.empty />
                            @else
                                <div
                                    wire:key="notification-center"
                                    x-data="notificationCenter()"
                                    x-effect="visible = $wire.$get('sidepageOpen') && !loading"
                                >
                                    @foreach ($this->notifications as $notification)
                                        <x-notifications.item
                                            :notification="$notification"
                                            wire:key="notification-{{ $notification->id }}"
                                        />
                                    @endforeach
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

            <x-slot:footer>
                <div class="flex w-full flex-col gap-3">
                    @if ($sidepageOpen && $notificationsLoaded && $this->notifications->hasPages())
                        <nav aria-label="Paginação de notificações" class="flex items-center justify-between gap-3">
                            <x-ui.button
                                primary
                                outline
                                sm
                                label="Anterior"
                                wire:click="previousPage('notificationsPage')"
                                :disabled="$this->notifications->onFirstPage()"
                            />
                            <span class="text-sm text-base-content/75">Página {{ $this->notifications->currentPage() }}</span>
                            <x-ui.button
                                primary
                                outline
                                sm
                                label="Próxima"
                                wire:click="nextPage('notificationsPage')"
                                :disabled="!$this->notifications->hasMorePages()"
                            />
                        </nav>
                    @endif
                    <div class="flex justify-end">
                        <x-ui.button
                            id="notification-history-link"
                            :href="route(user()->type->notificationHistoryRouteName())"
                            primary
                            outline
                            sm
                        >
                            Ver todas as notificações</x-ui.button
                        >
                    </div>
                </div>
            </x-slot:footer>
        </x-ui.sidepage>
    @endteleport
</div>
