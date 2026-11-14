@use(Illuminate\Support\Js)

@props(['notification', 'idPrefix' => '',])

<div
    {{ $attributes->except('class') }}
    data-notification-id="{{ $notification->id }}"
    data-notification-viewed="{{ $notification->viewed_at !== null ? 'true' : 'false' }}"
    @class([
        'min-w-0 [overflow-wrap:anywhere]',
        $notification->data['color'] ?? 'border-primary',
        'border-l-2' => is_null($notification->read_at)
    ])
>
    <div class="border-b border-base-300 bg-base-100 p-4 sm:p-6">
        <div class="flex min-w-0 flex-col gap-3">
            <div class="flex min-w-0 items-start justify-between gap-3">
                <div class="min-w-0 flex-1">
                    <div class="flex items-start gap-3">
                        @isset($notification->data['icon'])
                            <x-dynamic-component
                                :component="'icons.' . $notification->data['icon']"
                                class="size-6 shrink-0 text-primary"
                                aria-hidden="true"
                            />
                        @endisset

                        <p class="min-w-0 pt-0.5 leading-relaxed font-semibold text-base-content">{{ $notification->data['title'] }}</p>
                    </div>
                </div>

                <button
                    data-ui-loading-control
                    type="button"
                    id="{{ $idPrefix }}delete-notification-{{ $notification->id }}"
                    class="flex size-11 shrink-0 cursor-pointer items-center justify-center rounded-lg text-secondary hover:bg-base-200 hover:text-error focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-wait disabled:opacity-50"
                    aria-label="Excluir notificação"
                    wire:click="delete({{ Js::from($notification->id) }})"
                >
                    <x-icons.x-mark class="h-5 w-5" aria-hidden="true" />
                    <span data-ui-loading-spinner class="loading hidden loading-xs loading-spinner" aria-hidden="true"></span>
                </button>
            </div>

            <div class="flex min-w-0 flex-col items-start gap-3">
                @if ($notification->read_at === null)
                    <x-ui.button
                        xs
                        outline
                        primary
                        id="{{ $idPrefix }}read-notification-{{ $notification->id }}"
                        wire:click="markAsRead({{ Js::from($notification->id) }})"
                        class="h-auto min-h-11 max-w-full py-2 text-left whitespace-normal"
                    >
                        Marcar como lida</x-ui.button
                    >
                @else
                    <span class="rounded-lg bg-accent px-3 py-1 text-xs font-medium text-accent-content">Lida</span>
                @endif
                <p class="text-xs leading-relaxed text-secondary">
                    {{ $notification->created_at->translatedFormat('d \d\e F \d\e Y \à\s H:i') }}
                </p>

                @isset($notification->data['description'])
                    <p class="text-sm leading-relaxed text-base-content">{{ $notification->data['description'] }}</p>
                @endisset

                @isset($notification->data['details'])
                    <div class="flex w-full min-w-0 flex-col gap-3 rounded-lg bg-base-200 p-3 text-sm">
                        @foreach ($notification->data['details'] as $label => $content)
                            <div class="flex min-w-0 flex-col gap-1">
                                <div class="text-secondary">{{ $label }}:</div>
                                <div class="font-semibold text-base-content">{{ $content }}</div>
                            </div>
                        @endforeach
                    </div>
                @endisset

                @isset($notification->data['route'])
                    <div class="max-w-full">
                        <a
                            href="{{ $notification->data['route']['url'] }}"
                            class="inline-flex min-h-11 max-w-full items-center rounded-lg py-2 text-sm font-semibold text-primary underline underline-offset-4 hover:text-accent-content focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary"
                        >
                            {{ $notification->data['route']['action'] }}
                        </a>
                    </div>
                @endisset
            </div>
        </div>
    </div>
</div>
