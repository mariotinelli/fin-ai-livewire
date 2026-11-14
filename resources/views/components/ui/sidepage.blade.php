@props([
    'id' => null,
    'scrollable' => true,
    'clickAway' => true,
    'blockCloseWhileLoading' => 'save',
    'openOnEvent' => null,
    'loading' => null,
    'header' => null,
    'title' => 'Painel lateral',
    'footer' => null,
    'description' => null,
    'sm' => false,
    'md' => false,
    'lg' => false,
    'xl' => false,
    'xl2' => false,
    'xl3' => false,
    'xl4' => false,
    'xl5' => false,
    'xl6' => false,
    'xl7' => false,
])

@php
    $panelId = $id ?? 'sidepage-' . (isset($__livewire) ? $__livewire->getId() : str()->ulid());
    $titleId = $panelId . '-title';
@endphp

<div>
    <div
        class="relative z-50 bg-base-200"
        x-data="sidepage({ open: @entangle('sidepageOpen').live, id: @js($panelId), blockCloseWhileLoading: @js($blockCloseWhileLoading) })"
        @if ($openOnEvent) x-on:{{ $openOnEvent }}.window="beginOpening()" @endif
        @ui-sidepage-close-lock.window="if ($event.detail?.id === @js($panelId)) closeLocked = Boolean($event.detail.locked)"
        @keydown.window.escape="
            if (isActive() && !$event.defaultPrevented) {
                $event.preventDefault();
                requestClose();
            }
        "
        @keydown.window.tab="trapFocus($event)"
        x-show="visible"
        id="{{ $panelId }}"
        data-ui-sidepage
        x-bind:style="{ zIndex: 50 + Math.max(0, Alpine.store('uiSidepageStack').indexOf(@js($panelId))) }"
        x-bind:aria-busy="opening || pendingSaves > 0"
        role="dialog"
        aria-labelledby="{{ $titleId }}"
        x-ref="dialog"
        aria-modal="true"
    >
        <div
            x-show="visible"
            class="fixed inset-0 bg-base-content/65"
            aria-hidden="true"
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
        ></div>

        <div class="fixed inset-0 overflow-hidden">
            <div class="absolute inset-0 overflow-hidden">
                <div
                    @class([
                        'pointer-events-none fixed inset-y-0 right-0 flex max-w-full',
                        'pl-10 sm:pl-16' => $sm || $md || $lg || $xl || $xl2 || $xl3 || $xl4 || $xl5 || $xl6 || $xl7
                    ])
                >
                    <div
                        x-show="visible"
                        x-transition:enter="transform transition ease-in-out duration-300"
                        x-transition:enter-start="translate-x-full"
                        x-transition:enter-end="translate-x-0"
                        x-transition:leave="transform transition ease-in-out duration-300"
                        x-transition:leave-start="translate-x-0"
                        x-transition:leave-end="translate-x-full"
                        @click.away="if (@js($clickAway)) requestClose()"
                        x-ref="panel"
                        tabindex="-1"
                        @class([
                            'relative pointer-events-auto min-w-0 w-screen',
                            'max-w-sm' => $sm,
                            'max-w-md' => $md,
                            'max-w-lg' => $lg,
                            'max-w-xl' => $xl,
                            'max-w-2xl' => $xl2,
                            'max-w-3xl' => $xl3,
                            'max-w-4xl' => $xl4,
                            'max-w-5xl' => $xl5,
                            'max-w-6xl' => $xl6,
                            'max-w-7xl' => $xl7
                        ])
                    >
                        <div x-show="opening" class="absolute inset-0 z-10 flex flex-col bg-base-100 p-6" data-sidepage-loading>
                            <button
                                type="button"
                                aria-label="Fechar painel"
                                class="self-end"
                                x-bind:disabled="!canClose()"
                                @click="requestClose()"
                            >
                                <x-icons.x-mark class="size-6" />
                            </button>
                            @if ($loading)
                                {{ $loading }}
                            @else
                                <div role="status" class="flex flex-1 items-center justify-center gap-2">
                                    <span class="loading loading-spinner" aria-hidden="true"></span>Carregando...
                                </div>
                            @endif
                        </div>
                        <div
                            x-show="!opening"
                            class="flex h-full min-w-0 flex-col divide-y divide-base-300 bg-base-100 pb-[env(safe-area-inset-bottom,0px)] shadow-xl"
                        >
                            @if ($header)
                                <div class="min-h-(--navbar-height) bg-primary px-4 py-6 sm:px-6">
                                    <div class="flex items-center justify-between">
                                        <h2 class="text-base font-semibold text-primary-content" id="{{ $titleId }}">{{ $header }}</h2>
                                        <div class="ml-3 flex h-7 items-center">
                                            <button
                                                type="button"
                                                class="relative"
                                                aria-label="Fechar painel"
                                                x-bind:disabled="!canClose()"
                                                @click="requestClose()"
                                            >
                                                <span class="sr-only">Fechar painel</span>
                                                <x-icons.x-mark
                                                    class="h-6 w-6 text-primary-content hover:cursor-pointer"
                                                    aria-hidden="true"
                                                />
                                            </button>
                                        </div>
                                    </div>

                                    @if ($description)
                                        <div class="mt-1">
                                            <p class="text-sm text-primary-content">{{ $description }}</p>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            @unless ($header)
                                <h2 id="{{ $titleId }}" class="sr-only">{{ $title }}</h2>
                            @endunless

                            <div
                                data-sidepage-content
                                @class(['h-0 min-w-0 flex-1 overscroll-contain', 'overflow-y-auto' => $scrollable, 'overflow-hidden' => !$scrollable])
                            >
                                {{ $slot }}
                            </div>

                            @if ($footer)
                                <footer class="flex shrink-0 items-center justify-end gap-2 bg-base-200 p-3">{{ $footer }}</footer>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
