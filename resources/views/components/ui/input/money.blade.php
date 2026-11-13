@props([
    'locale' => 'pt-BR',
    'prefix' => false,
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
    $blurEvent = '$refs.model.dispatchEvent(new Event("blur")); ' . $attributes->get('@blur');
@endphp

<div
    x-data="{
        displayValue: '',
        hydrate(value) {
            this.displayValue = Money.formatAmount(value, @js($locale));
        },
        handleInput(event) {
            this.displayValue = @js($locale) === 'pt-BR' ? Money.brlMask(event.target.value) : Money.usdMask(event.target.value);
            event.target.value = this.displayValue;
            // The server converters consume Brazilian decimal strings in either display locale.
            $refs.model.value = @js($locale) === 'pt-BR' ? this.displayValue : this.displayValue.replaceAll(',', '').replace('.', ',');
            $refs.model.dispatchEvent(new Event('input'));
        }
    }"
    x-effect="hydrate($wire.$get(@js($wireModel)))"
>
    <input type="hidden" wire:ignore x-ref="model" {{ $binding }}="{{ $wireModel }}" />
    <x-ui.input
        {{ $attributes->whereDoesntStartWith('wire:model')->except(['@input', '@blur']) }}
        :name="$attributes->get('name', $wireModel)"
        x-bind:value="displayValue"
        x-on:input="{{ $inputEvent }}"
        x-on:blur="{{ $blurEvent }}"
        :prefix="$prefix ? ($locale === 'pt-BR' ? 'R$' : '$') : ''"
    />
</div>
