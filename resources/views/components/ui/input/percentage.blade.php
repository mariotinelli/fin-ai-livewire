{{--
    Contract: the Livewire value is a percentage point (12.5 means 12.5%, not 0.125).
    Values are inclusive of min/max, use decimalPlaces digits (0..10), and round half away from zero.
    Empty or invalid user input serializes as null; serialized decimals always use a dot separator.
--}}
@props([
    'decimalPlaces' => 2,
    'min' => 0,
    'max' => 100,
    'placeholder' => null,
])

@php
    $wireModel = $attributes->wire('model')->value();
    $modifiers = $attributes->wire('model')->modifiers()->all();
    $isBlur = in_array('blur', $modifiers, true);
    if ($isBlur) {
        $modifiers = ['live', 'blur', ...array_values(array_diff($modifiers, ['live', 'blur']))];
    }
    if (in_array('live', $modifiers, true) && !in_array('debounce', $modifiers, true)) {
        foreach ($modifiers as $modifier) {
            if (preg_match('/^\d+ms$/', $modifier)) {
                $modifiers = array_values(array_diff($modifiers, [$modifier]));
                $modifiers[] = 'debounce';
                $modifiers[] = $modifier;
                break;
            }
        }
    }
    $binding = 'wire:model' . ($modifiers ? '.' . implode('.', $modifiers) : '');
    $inputEvent = 'handleInput($event); ' . $attributes->get('@input');
    $pasteEvent = 'handlePaste($event); ' . $attributes->get('@paste');
    $blurEvent = '$refs.model.dispatchEvent(new Event("blur")); ' . $attributes->get('@blur');
@endphp

<div
    x-data="{
        displayValue: '',
        apply(result, dispatch = true) {
            this.displayValue = result.display;
            if (!dispatch) return;
            $refs.model.value = result.value ?? '';
            $refs.model.dispatchEvent(new Event('input', { bubbles: true }));
        },
        hydrate(value) {
            this.apply(Percentage.formatPercentage(value, @js($decimalPlaces), @js($min), @js($max)), false);
        },
        handleInput(event) {
            this.apply(Percentage.maskPercentage(event.target.value, @js($decimalPlaces), @js($min), @js($max)));
        },
        handlePaste(event) {
            event.preventDefault();
            this.apply(Percentage.pastePercentage(event.clipboardData.getData('text'), @js($decimalPlaces), @js($min), @js($max)));
        }
    }"
    x-effect="hydrate($wire.$get(@js($wireModel)))"
>
    <input type="hidden" wire:ignore x-ref="model" {{ $binding }}="{{ $wireModel }}" />
    <x-ui.input
        {{ $attributes->whereDoesntStartWith('wire:model')->except(['@input', '@paste', '@blur']) }}
        :name="$attributes->get('name', $wireModel)"
        :placeholder="$placeholder ?? ($decimalPlaces > 0 ? '0,' . str_repeat('0', min(10, max(0, (int) $decimalPlaces))) : '0')"
        inputmode="decimal"
        x-bind:value="displayValue"
        x-on:input="{{ $inputEvent }}"
        x-on:paste="{{ $pasteEvent }}"
        x-on:blur="{{ $blurEvent }}"
        suffix="%"
    />
</div>
