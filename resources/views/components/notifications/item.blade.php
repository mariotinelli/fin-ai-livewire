@use(Illuminate\Support\Js)

@props(['notification', 'idPrefix' => '',])

<div
    {{ $attributes->except('class') }}
    data-notification-id="{{ $notification->id }}"
    data-notification-viewed="{{ $notification->viewed_at !== null ? 'true' : 'false' }}"
    @class([$notification->data['color'] ?? 'border-primary', 'border-l border-l-2' => is_null($notification->read_at)])
>
    <div class="items-center border-b border-base-300 bg-base-100 p-4">
        <div class="w-full items-center">
            <div class="mb-1 flex w-full justify-between">
                <div>
                    <div class="flex justify-between gap-3">
                        @isset($notification->data['icon'])
                            <x-dynamic-component
                                :component="'icons.' . $notification->data['icon']"
                                class="z-50 h-6 w-6 text-base-content/50"
                            />
                        @endisset

                        <p class="font-semibold">{{ $notification->data['title'] }}</p>
                    </div>
                </div>

                <button
                    data-ui-loading-control
                    type="button"
                    id="{{ $idPrefix }}delete-notification-{{ $notification->id }}"
                    class="cursor-pointer text-base-content/50"
                    aria-label="Excluir notificação"
                    wire:click="delete({{ Js::from($notification->id) }})"
                >
                    <x-icons.x-mark class="h-5 w-5" aria-hidden="true" />
                    <span data-ui-loading-spinner class="loading hidden loading-xs loading-spinner" aria-hidden="true"></span>
                </button>
            </div>

            <div>
                @if ($notification->read_at === null)
                    <x-ui.button
                        xs
                        outline
                        primary
                        id="{{ $idPrefix }}read-notification-{{ $notification->id }}"
                        wire:click="markAsRead({{ Js::from($notification->id) }})"
                        class="mb-2"
                    >
                        Marcar como lida</x-ui.button
                    >
                @else
                    <span class="mb-2 block text-xs text-base-content/65">Lida</span>
                @endif
                <p class="mb-1 pl-9 text-sm text-base-content/65">
                    {{ $notification->created_at->translatedFormat('d \d\e F \d\e Y \à\s H:i') }}
                </p>

                @isset($notification->data['description'])
                    <p class="mb-2 pl-9 text-base-content">{{ $notification->data['description'] }}</p>
                @endisset

                @isset($notification->data['details'])
                    <div class="mt-2 space-y-2 pl-9 text-sm">
                        @foreach ($notification->data['details'] as $label => $content)
                            <div class="flex space-x-1">
                                <div class="text-sm text-base-content">{{ $label }}:</div>
                                <div class="font-semibold text-base-content">{{ $content }}</div>
                            </div>
                        @endforeach
                    </div>
                @endisset

                @isset($notification->data['route'])
                    <div class="my-2 pl-9">
                        <a
                            href="{{ $notification->data['route']['url'] }}"
                            class="w-fit border-none bg-transparent text-sm font-bold text-primary underline hover:cursor-pointer"
                        >
                            {{ $notification->data['route']['action'] }}
                        </a>
                    </div>
                @endisset
            </div>
        </div>
    </div>
</div>
