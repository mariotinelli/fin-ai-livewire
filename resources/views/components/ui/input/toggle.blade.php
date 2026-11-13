@props([
    'id' => null,
    'label' => null,
    'success' => null,
    'info' => null,
    'warning' => null,
    'error' => null,
    'primary' => null,
    'labelRight' => false,
    'inline' => false,
    'helperText' => null,
])

@php
    $name               = $attributes->get('name') ?? $attributes->wire('model')->value();
    $id                 = $id ?? $name ?? uniqid();
    $labelElementId     = $id . '-label';
    $helperTextId       = $id . '-helper-text';
    $hasValidationError = isset($errors) && $errors->has($name ?? $id);
    $iconClasses = match (true) {
        $primary => 'h-[0.6rem]! text-primary-content',
        $success => 'h-[0.6rem]! text-success-content',
        default  => 'h-[0.6rem]!',
    };
@endphp

@if ($attributes->wire('model')->value())
    <div class="relative flex flex-col gap-1" x-data="{ checked: @entangle($attributes->wire('model')) }">
@else
    <div class="relative flex flex-col gap-1" x-data="{ checked: {{ $attributes->has('checked') ? 'true' : 'false' }} }">
@endif
@if (!$inline && $label)
    <span id="{{ $labelElementId }}">
        <x-ui.input.label :id="$id" :name="$name" :label="$label" :required="$attributes->get('required')" />
    </span>
@endunless

<div class="flex items-center gap-2">
    @if ($inline && !$labelRight && $label)
        <span id="{{ $labelElementId }}">
            <x-ui.input.label :id="$id" :name="$name" :label="$label" :required="$attributes->get('required')" class="pb-[0.1rem]!" />
        </span>
    @endunless

    <div class="relative w-fit">
        <input
            x-model="checked"
            :checked="checked"
            x-bind:aria-checked="checked ? 'true' : 'false'"
            @if ($attributes->wire('model')->value())
                {{ $attributes->wire('model') }}
            @endif
            @if ($label && !$attributes->has('aria-labelledby'))
                aria-labelledby="{{ $labelElementId }}"
            @elseif (!$label && !$attributes->has('aria-label') && !$attributes->has('aria-labelledby'))
                aria-label="{{ $name ?? 'Alternar opcao' }}"
            @endif
            @if ($hasValidationError)
                aria-invalid="true"
            @endif
            @if ($helperText && !$attributes->has('aria-describedby'))
                aria-describedby="{{ $helperTextId }}"
            @endif
            {{
                $attributes->merge([
                    'id'   => $id,
                    'name' => $name,
                    'type' => 'checkbox',
                    'role' => 'switch',
                ])->class([
                    'toggle',
                    'toggle-primary' => $primary || (!$success && !$info && !$warning && !$error),
                    'toggle-success' => $success,
                    'toggle-info'    => $info,
                    'toggle-warning' => $warning,
                    'toggle-error'   => $error,
                ])
            }}
        />

        <span
            class="pointer-events-none absolute top-2 right-[7px] z-2 ml-[-1.98rem]"
            x-cloak
            x-show="checked"
            x-transition
            aria-hidden="true"
        >
            <x-icons.check class="{{ $iconClasses }}" aria-hidden="true" stroke-width="3" focusable="false" />
        </span>
    </div>

    @if ($inline && $labelRight && $label)
        <span id="{{ $labelElementId }}">
            <x-ui.input.label :id="$id" :name="$name" :label="$label" :required="$attributes->get('required')" class="pb-[0.1rem]!" />
        </span>
    @endif
</div>
@if ($helperText)
    <span id="{{ $helperTextId }}" class="text-sm break-words text-base-content/65">{{ $helperText }}</span>
@endif
</div>
