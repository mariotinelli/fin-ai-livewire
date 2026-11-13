@props([
    'id' => null,
    'name' => null,
    'label' => null,
    'labelPosition' => 'top',
    'circle' => false,
    'xs' => false,
    'sm' => false,
    'md' => false,
    'lg' => false,
    'min' => null,
    'max' => null,
    'step' => 1,
    'showError' => true,
    'helperText' => null,
    'hint' => null,
    'parentClass' => null,
    'disabled' => false,
    'disableWhileLoading' => false,
])

@php
    $model = $attributes->wire('model')->value();
    $name ??= $model;
    $id = $id ?? $name ?? uniqid('counter-');

    $errorId = $id . '-error';
    $helperTextId = $id . '-helper';
    $describedBy = collect([
        $errors->has($name) ? $errorId : null,
        $helperText ? $helperTextId : null,
    ])->filter()->implode(' ');
    $accessibleSubject = $label ?: __('valor');

    $controlHeight = match (true) {
        $xs => 'h-8',
        $md => 'h-12',
        $lg => 'h-14',
        default => 'h-10',
    };
    $buttonSize = match (true) {
        $xs => 'size-6',
        $md => 'size-9',
        $lg => 'size-10',
        default => 'size-8',
    };
    $textSize = match (true) {
        $xs => 'text-xs',
        $md, $lg => 'text-base',
        default => 'text-sm',
    };
@endphp

<div class="relative flex w-full flex-col gap-1 {{ $parentClass }}">
    <div @class(['flex items-center gap-3', 'justify-between' => in_array($labelPosition, ['left', 'right'], true)])>
        @if ($label && $labelPosition === 'left')
            <x-ui.input.label :id="$id" :name="$name" :label="$label" :required="$attributes->get('required')" />
        @endif

        <div @class(['min-w-0', 'flex-1' => $labelPosition !== 'top'])>
            @if ($label && $labelPosition === 'top')
                <div class="mb-1 flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between sm:gap-0">
                    <x-ui.input.label :id="$id" :name="$name" :label="$label" :required="$attributes->get('required')" />

                    @if ($hint)
                        <small class="max-w-xs break-words text-base-content/75 sm:ml-2">{{ $hint }}</small>
                    @endif
                </div>
            @endif

            <div
                x-data="{
                    decimalPlaces(value) {
                        const text = String(value).toLowerCase();
                        if (text.includes('e-')) {
                            return Number(text.split('e-')[1]);
                        }

                        return (text.split('.')[1] || '').length;
                    },
                    adjust(direction) {
                        const input = this.$refs.input;
                        if (input.disabled) {
                            return;
                        }

                        const step = Number(input.step);
                        const increment = Number.isFinite(step) && step > 0 ? step : 1;
                        const minimum = input.min === '' ? null : Number(input.min);
                        const maximum = input.max === '' ? null : Number(input.max);
                        const fallback = minimum ?? 0;
                        const current = input.value === '' ? fallback : Number(input.value);
                        const precision = Math.max(
                            this.decimalPlaces(current),
                            this.decimalPlaces(increment),
                            minimum === null ? 0 : this.decimalPlaces(minimum),
                            maximum === null ? 0 : this.decimalPlaces(maximum),
                        );
                        const factor = 10 ** precision;
                        let next = (Math.round(current * factor) + direction * Math.round(increment * factor)) / factor;

                        if (minimum !== null) {
                            next = Math.max(minimum, next);
                        }
                        if (maximum !== null) {
                            next = Math.min(maximum, next);
                        }

                        input.value = String(next);
                        input.dispatchEvent(new Event('input', { bubbles: true }));
                        input.dispatchEvent(new Event('change', { bubbles: true }));
                        input.focus({ preventScroll: true });
                    },
                }"
                @class([
                    'inline-flex items-center gap-1 overflow-hidden rounded-lg border border-base-content/10 bg-base-100 px-1 focus-within:ring-2 focus-within:ring-primary',
                    $controlHeight,
                    'border-error!' => $errors->has($name),
                    'bg-base-200!' => $disabled
                ])
            >
                <button
                    type="button"
                    x-on:click="adjust(-1)"
                    @disabled($disabled)
                    @if ($disableWhileLoading && !$disabled) wire:loading.attr="disabled" @endif
                    {{ $attributes->whereStartsWith('wire:target') }}
                    aria-label="{{ __('Diminuir :label', ['label' => $accessibleSubject]) }}"
                    @class([
                        'inline-flex shrink-0 items-center justify-center bg-base-200 text-base-content/80 hover:cursor-pointer hover:bg-base-300 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-50',
                        $buttonSize,
                        'rounded-full' => $circle,
                        'rounded-md' => !$circle
                    ])
                >
                    <x-icons.minus class="size-4" aria-hidden="true" />
                </button>

                <input
                    x-ref="input"
                    {{ $attributes->wire('model') }}
                    {{
                        $attributes->whereDoesntStartWith('wire:model')->merge([
                            'id' => $id,
                            'name' => $name,
                            'type' => 'number',
                            'inputmode' => 'decimal',
                            'min' => $min,
                            'max' => $max,
                            'step' => $step,
                            'disabled' => $disabled,
                            'wire:loading.attr' => $disableWhileLoading && !$disabled ? 'disabled' : null,
                            'wire:target' => $disableWhileLoading && $attributes->whereStartsWith('wire:target')->isEmpty() ? '' : null,
                            'aria-describedby' => $describedBy ?: null,
                            'aria-invalid' => $errors->has($name) ? 'true' : null,
                            'aria-required' => $attributes->get('required') ? 'true' : null,
                        ])->class([
                            'input min-w-12 border-0 bg-transparent px-1 text-center font-medium text-base-content shadow-none focus:outline-none focus:ring-0 disabled:cursor-not-allowed disabled:bg-transparent',
                            $textSize,
                        ])
                    }}
                />

                <button
                    type="button"
                    x-on:click="adjust(1)"
                    @disabled($disabled)
                    @if ($disableWhileLoading && !$disabled) wire:loading.attr="disabled" @endif
                    {{ $attributes->whereStartsWith('wire:target') }}
                    aria-label="{{ __('Aumentar :label', ['label' => $accessibleSubject]) }}"
                    @class([
                        'inline-flex shrink-0 items-center justify-center bg-base-200 text-base-content/80 hover:cursor-pointer hover:bg-base-300 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-50',
                        $buttonSize,
                        'rounded-full' => $circle,
                        'rounded-md' => !$circle
                    ])
                >
                    <x-icons.plus class="size-4" aria-hidden="true" />
                </button>
            </div>

            @if ($showError)
                @error($name)
                    <x-ui.input.error :id="$errorId" :message="$message" />
                @enderror
            @endif

            @if ($helperText)
                <small id="{{ $helperTextId }}" class="wrap-break-word text-base-content/75">{{ $helperText }}</small>
            @endif
        </div>

        @if ($label && $labelPosition === 'right')
            <x-ui.input.label :id="$id" :name="$name" :label="$label" :required="$attributes->get('required')" />
        @endif
    </div>
</div>
