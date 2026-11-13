@props(['disableWhileLoading' => false])

@php
    $inputId = $attributes->get('id') ?? $attributes->get('name') ?? $attributes->wire('model')->value() ?? uniqid('password-');
    $fieldLabel = $attributes->get('label') ?: $attributes->get('aria-label');
@endphp

<div x-data="{ show: false }">
    <x-ui.input
        {{ $attributes->merge(['id' => $inputId, 'type' => 'password']) }}
        :disable-while-loading="$disableWhileLoading"
        x-cloak
        x-bind:type="show ? 'text' : 'password'"
    >
        <x-slot name="suffix">
            <button
                type="button"
                aria-label="{{ $fieldLabel ? 'Mostrar senha: ' . $fieldLabel : 'Mostrar senha' }}"
                aria-controls="{{ $inputId }}"
                aria-pressed="false"
                x-bind:aria-pressed="show.toString()"
                @click="show = !show"
                @disabled($attributes->get('disabled'))
                @if ($disableWhileLoading && !$attributes->get('disabled')) wire:loading.attr="disabled" @endif
                {{ $attributes->whereStartsWith('wire:target') }}
                class="flex size-10 shrink-0 cursor-pointer items-center justify-center text-base-content/65 hover:text-base-content focus-visible:outline-2 focus-visible:-outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed"
            >
                <x-icons.eye x-show="!show" aria-hidden="true" focusable="false" class="size-5" />
                <x-icons.eye-slash x-show="show" aria-hidden="true" focusable="false" class="size-5" />
            </button>
        </x-slot>
    </x-ui.input>
</div>
