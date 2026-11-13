@props([
    'id',
    'title'       => '',
    'description' => '',
    'footer'      => '',
    'lg'          => false,
    'xl'          => false,
    'xl2'         => false,
    'xl3'         => false,
    'clickAway'   => true,
    'divided'     => false,
    'headerAlign' => 'left',
    'scrollable'  => false,
    'closeButton' => true,
    'escapable'   => true,
    'manual'      => false,
])

<div
    id="{{ $id }}"
    x-data="{
        open: @if($manual) false @elseif(isset($__livewire)) @entangle('modalOpen') @else false @endif,
        modalId: @js($id),
        clickAway: @js($clickAway),
        escapable: @js($escapable),
        trigger: null,
        observer: null,
        init() {
            if (! Alpine.store('uiModalStack')) {
                Alpine.store('uiModalStack', []);
            }
            this.$watch('open', (value) => value ? this.activate() : this.deactivate());
            this.observer = new MutationObserver(() => {
                if (this.isActive() && ! this.isEligible(document.activeElement) && document.activeElement !== this.$refs.modal
                    && ! this.$refs.modal.contains(document.activeElement?.closest('[data-ui-select-dropdown]:popover-open'))) {
                    this.focusInput();
                }
            });
            this.observer.observe(this.$refs.modal, { subtree: true, childList: true, attributes: true, attributeFilter: ['disabled', 'hidden', 'inert', 'tabindex', 'class', 'style', 'type'] });
            if (this.open) {
                this.activate();
            }
        },
        destroy() {
            this.observer.disconnect();
            this.deactivate();
        },
        isActive() {
            return this.open && Alpine.store('uiModalStack').at(-1) === this.modalId;
        },
        activate() {
            this.trigger = document.activeElement;
            Alpine.store('uiModalStack').push(this.modalId);
            this.focusInput();
        },
        deactivate() {
            const wasActive = Alpine.store('uiModalStack').at(-1) === this.modalId;
            Alpine.store('uiModalStack', Alpine.store('uiModalStack').filter(id => id !== this.modalId));
            this.$dispatch('modal-closed', { modal: this.modalId });
            this.$nextTick(() => {
                if (! this.open && wasActive && this.isEligible(this.trigger)) {
                    this.trigger.focus({ preventScroll: true });
                }
            });
        },
        isEligible(element) {
            return element instanceof HTMLElement && element.isConnected && element.tabIndex >= 0
                && ! element.matches(':disabled, input[type=hidden]')
                && ! element.closest('[hidden], [inert]')
                && element.getClientRects().length > 0
                && getComputedStyle(element).visibility === 'visible';
        },
        focusable() {
            return Array.from(this.$refs.modal.querySelectorAll('input, select, textarea, button, a[href], area[href], summary, iframe, [contenteditable], [tabindex]'))
                .filter(element => this.isEligible(element))
                .sort((a, b) => (a.tabIndex || Infinity) - (b.tabIndex || Infinity));
        },
        focusInput() {
            this.$nextTick(() => {
                if (this.isActive()) {
                    const elements = this.focusable();
                    (elements.find(element => this.$refs.slot.contains(element)) || elements[0] || this.$refs.modal).focus({ preventScroll: true });
                }
            });
        },
        trapFocus(event) {
            event.preventDefault();
            const elements = this.focusable();
            const index = elements.indexOf(document.activeElement);
            const next = event.shiftKey ? (index <= 0 ? elements.length - 1 : index - 1) : (index + 1) % elements.length;
            (elements[next] || this.$refs.modal).focus();
        }
    }"
    @keydown.window.escape="
        if (isActive() && escapable && !$event.defaultPrevented) {
            $event.preventDefault();
            open = false;
        }
    "
    @keydown.window.tab="
        if (isActive()) {
            trapFocus($event);
        }
    "
    @focusin.window="
        if (isActive() && !$refs.modal.contains($event.target)) {
            focusInput();
        }
    "
    :style="{ zIndex: 15 + Math.max(0, Alpine.store('uiModalStack').indexOf(modalId)) }"
    @open-modal.window="$event.detail === modalId ? (open = true) : null"
    @close-modal.window="$event.detail === modalId ? (open = false) : null"
    x-show="open"
    class="relative z-15"
    role="dialog"
    aria-labelledby="{{ $id ?: md5($title) }}-title"
    aria-label="{{ $title }}"
    aria-modal="true"
    x-cloak
>
    <div
        x-show="open"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-base-content/75 transition-opacity"
        aria-hidden="true"
    ></div>

    <div x-show="open" class="fixed inset-0 z-15 w-screen overflow-y-auto overscroll-contain">
        <div class="flex min-h-full min-w-0 items-center justify-center p-4 text-center">
            <div
                x-show="open"
                x-ref="modal"
                tabindex="-1"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 translate-y-0 scale-95"
                @click.window.outside="clickAway && isActive() ? (open = false) : null"
                @class([
                    'w-full min-w-0 max-w-lg max-h-[calc(100dvh-2rem)] overflow-hidden wrap-anywhere bg-base-100 relative transform rounded-xl shadow-xl p-0
                        pointer-events-auto transition-all flex flex-col items-start justify-start',
                    'max-w-2xl!'               => $lg,
                    'max-w-4xl!'               => $xl,
                    'max-w-6xl!'               => $xl2,
                    'max-w-7xl!'               => $xl3,
                    'divide-y divide-base-300' => $divided,
                ])
            >
                @if ($closeButton)
                    <button
                        class="absolute top-1 right-1 border-none bg-transparent p-2 shadow-none hover:cursor-pointer"
                        type="button"
                        @click="open = false"
                    >
                        <span class="sr-only">Fechar modal</span>
                        <x-icons.x-mark class="size-5! bg-none text-base-content/65" aria-hidden="true" />
                    </button>
                @endif

                <div
                    data-modal-header
                    @class([
                    'flex max-h-[40dvh] min-w-0 shrink-0 flex-col overflow-y-auto overscroll-contain px-6 pt-6 pb-3 w-full justify-start',
                    'pr-12' => $closeButton,
                    'items-start'  => $headerAlign === 'left',
                    'items-center' => $headerAlign === 'center',
                    'items-end'    => $headerAlign === 'right',
                    'text-left'    => $headerAlign === 'left',
                    'text-center'  => $headerAlign === 'center',
                    'text-right'   => $headerAlign === 'right',
                ])
                >
                    <h2 id="{{ $id ?: md5($title) }}-title" class="w-full min-w-0 text-lg leading-6 font-semibold text-base-content">
                        {{ $title }}
                    </h2>
                    <p class="w-full min-w-0 text-sm text-base-content/75">{{ $description }}</p>
                </div>

                <div
                    x-ref="slot"
                    @class([
                        'px-6 pb-3 w-full min-h-0 min-w-0 flex overflow-y-auto overscroll-contain text-start',
                        'py-5!'                                     => $divided,
                    ])
                >
                    <div class="w-full min-w-0">{{ $slot }}</div>
                </div>

                <div data-modal-footer class="max-h-[40dvh] w-full min-w-0 shrink-0 overflow-y-auto overscroll-contain rounded-b-xl">
                    @if ($footer)
                        {{ $footer }}
                    @else
                        <div class="flex w-full items-center justify-end gap-2 bg-base-200 p-3">
                            <x-ui.button
                                :id="$id . '-cancel-button'"
                                label="Cancelar"
                                ghost
                                @click="open = false"
                                class="hover:bg-base-200"
                            />
                            <x-ui.button :id="$id . '-save-button'" label="Salvar" primary wire:click="save" />
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
