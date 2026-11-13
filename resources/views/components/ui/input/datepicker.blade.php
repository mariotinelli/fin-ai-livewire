<div
    x-cloak
    x-data="datepicker(
        @js(!isset($attributes->getAttributes()['wire:model'])),
        @js($attributes->whereStartsWith('wire:model')->first()),
        @entangle($attributes->wire('model')),
        @js($getConfig())
    )"
    class="w-full"
>
    <div class="relative">
        @if ($isRange())
            <x-ui.input
                {{ $attributes->whereDoesntStartWith('wire:model') }}
                :name="$attributes->wire('model')->value()"
                x-ref="datepicker"
                x-model="model"
            >
                <x-slot name="suffix">
                    <x-icons.calendar class="h-5 w-5 text-base-content/50 hover:cursor-pointer" @click="openCalendar" />
                </x-slot>
            </x-ui.input>
        @else
            <x-ui.input
                {{ $attributes->whereDoesntStartWith('wire:model') }}
                :name="$attributes->wire('model')->value()"
                x-ref="datepicker"
                x-model="model"
                x-mask="{{ $mask }}"
            >
                <x-slot name="suffix">
                    <x-icons.calendar class="h-5 w-5 text-base-content/50 hover:cursor-pointer" @click="openCalendar" />
                </x-slot>
            </x-ui.input>
        @endif
    </div>
</div>
