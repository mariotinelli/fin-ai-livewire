@props(['color' => null, 'icon' => null])

@php
    $alertColors = [
        'primary' => ['icon' => 'text-primary', 'button' => 'btn-primary'],
        'secondary' => ['icon' => 'text-secondary', 'button' => 'btn-secondary'],
        'accent' => ['icon' => 'text-accent', 'button' => 'btn-accent'],
        'neutral' => ['icon' => 'text-neutral', 'button' => 'btn-neutral'],
        'success' => ['icon' => 'text-success', 'button' => 'btn-success'],
        'warning' => ['icon' => 'text-warning', 'button' => 'btn-warning'],
        'info' => ['icon' => 'text-info', 'button' => 'btn-info'],
        'error' => ['icon' => 'text-error', 'button' => 'btn-error'],
    ];
    $alertIcons = ['check-circle', 'exclamation-triangle', 'information-circle', 'x-circle', 'question-mark-circle'];
@endphp

<div
    x-cloak
    id="alert-modal"
    x-data="alertModal(@js(['colors' => $alertColors, 'icons' => $alertIcons, 'defaultColor' => $color, 'defaultIcon' => $icon]))"
    @alert.window="add($event.detail)"
    class="pointer-events-none fixed inset-0 z-75 flex flex-col items-end justify-center space-y-4 px-4 py-6 sm:justify-start sm:p-6"
    :class="alerts.length ? 'bg-base-content/50' : null"
>
    <template x-for="alert in alerts" :key="alert.key">
        <dialog
            x-bind:id="'info-modal-' + alert.key"
            class="modal"
            role="dialog"
            aria-modal="true"
            x-bind:aria-labelledby="'alert-modal-title-' + alert.key"
            x-on:keydown.tab="trapFocus($event, alert.key)"
            x-on:keydown.escape.prevent.stop="dismiss(alert)"
            x-on:cancel.prevent="dismiss(alert)"
            x-bind:aria-busy="alert.pending"
            tabindex="-1"
            open
        >
            <div class="pointer-events-auto modal-box w-full max-w-xl rounded-md p-0 shadow-lg">
                <div class="flex gap-2 p-6">
                    @foreach ($alertIcons as $alertIcon)
                        <x-dynamic-component
                            :component="'icons.' . $alertIcon"
                            class="size-8! shrink-0"
                            x-bind:class="colors[alert.color].icon"
                            x-show="alert.icon === '{{ $alertIcon }}'"
                            aria-hidden="true"
                        />
                    @endforeach

                    <div class="flex w-full flex-col gap-4">
                        <h3
                            x-show="alert.title"
                            x-text="alert.title"
                            x-bind:id="'alert-modal-title-' + alert.key"
                            class="text-xl font-bold text-base-content"
                        ></h3>

                        <template x-if="!alert.descriptionHighlight">
                            <p class="text-base-content/75" x-show="alert.description" x-text="alert.description"></p>
                        </template>
                        <template x-if="alert.descriptionHighlight">
                            <p class="text-base-content/75">
                                <template x-for="(part, index) in descriptionParts(alert)" :key="index"
                                    ><span :class="{ 'font-bold': part.bold }" x-text="part.text"></span
                                ></template>
                            </p>
                        </template>
                        <p role="alert" class="text-error" x-show="alert.error" x-text="alert.error"></p>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2 border-t bg-base-200 p-3">
                    <x-ui.button
                        label="Fechar"
                        ghost
                        class="hover:bg-base-200"
                        x-show="!alert.is_confirmation"
                        x-on:click="dismiss(alert)"
                        x-bind:disabled="alert.pending"
                        x-bind:data-ui-button-loading="alert.pending && alert.running === 'cancel'"
                    />
                    <x-ui.button
                        ghost
                        class="hover:bg-base-200"
                        x-show="alert.is_confirmation && alert.textCancel"
                        x-on:click="cancel(alert)"
                        x-bind:disabled="alert.pending"
                        x-bind:data-ui-button-loading="alert.pending && alert.running === 'cancel'"
                        data-alert-cancel
                    >
                        <span x-text="alert.textCancel"></span
                    ></x-ui.button>
                    <x-ui.button
                        x-bind:class="colors[alert.color].button"
                        x-show="alert.is_confirmation && (alert.method || typeof alert.onConfirm === 'function')"
                        x-on:click="confirm(alert)"
                        x-bind:disabled="alert.pending"
                        x-bind:data-ui-button-loading="alert.pending && alert.running === 'confirm'"
                        data-alert-confirm
                    >
                        <span x-text="alert.textConfirm"></span
                    ></x-ui.button>
                </div>
            </div>
        </dialog>
    </template>
</div>
