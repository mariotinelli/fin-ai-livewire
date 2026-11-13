@props([
    'header' => null,
    'title' => null,
    'subtitle' => null,
    'addButtonText' => null,
    'addButton' => null,
    'model' => null,
    'openAll' => true,
    'wizard' => false,
])

<div
    @class(['space-y-6 bg-base-100', 'rounded-lg border border-base-300' => !$wizard, 'rounded-b-lg' => $wizard])
    x-data="{
        items: @entangle($model),
        previousCount: 0,
        liveMessage: '',
    }"
    x-init="
        previousCount = Array.isArray(items) ? items.length : 0;
        $watch('items', (value) => {
            const currentCount = Array.isArray(value) ? value.length : 0;

            if (currentCount > previousCount) {
                liveMessage = 'Item adicionado';
            }

            if (currentCount < previousCount) {
                liveMessage = 'Item removido';
            }

            previousCount = currentCount;
        });
    "
>
    <div>
        @if (!$wizard && !$header)
            <div class="flex items-center justify-between px-6 py-3">
                <div class="space-y-1">
                    <div class="text-xl font-semibold text-base-content">{{ $title ?? 'Itens' }}</div>
                    <p class="text-sm text-base-content/65">{{ $subtitle ?? 'Adicione os itens desejados' }}</p>
                </div>

                @if (count($this->$model ?? []) > 0)
                    <x-ui.badge primary> {{ count($this->$model) . ' ' . (count($this->$model) > 1 ? 'items' : 'item') }} </x-ui.badge>
                @endif
            </div>
        @elseif (!$wizard)
            {{ $header }}
        @endif

        <ul class="m-0 list-none p-0" aria-label="{{ $title ?? 'Lista de itens' }}">
            {{ $slot }}
        </ul>

        <div aria-live="polite" class="sr-only" x-text="liveMessage"></div>

        @error($model)
            <div class="px-6 py-3">
                <x-ui.input.error :message="$message" />
            </div>
        @enderror

        @if ($addButton)
            {{ $addButton }}
        @else
            <div @class(['py-3 flex justify-center items-center w-full bg-base-200', 'border-t' => count($this->$model ?? []) === 0])>
                <x-ui.button
                    id="repeater-add-button"
                    wire:click="addItem(@js($model))"
                    aria-label="{{ $addButtonText ?? 'Adicionar item à lista' }}"
                    primary
                    outline
                    md
                    icon="plus"
                >
                    {{ $addButtonText ?? 'Adicionar item' }}
                </x-ui.button>
            </div>
        @endif
    </div>
</div>
