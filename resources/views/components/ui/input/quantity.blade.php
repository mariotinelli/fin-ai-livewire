{{--
    Quantidade não negativa com três casas: valor canônico string "1234.567", exibição "1234,567".
    Digitação usa fluxo de milésimos; colagem aceita decimal explícito e agrupamento pt-BR com vírgula.
    Precisão excedente, negativos e texto inválido são rejeitados (funções retornam null; campo envia vazio).
    Sem limite de magnitude para strings; números JS limitados a MAX_SAFE_INTEGER / 1000. Use strings para valores grandes.
    Não use wire:model.number: o canônico deve permanecer string.
    Hidratação apenas apresenta o valor; o consumidor valida os limites de negócio no servidor.
--}}
@props([
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
            this.apply(Quantity.formatQuantity(value), false);
        },
        handleInput(event) {
            this.apply(Quantity.maskQuantity(event.target.value));
        },
        handlePaste(event) {
            event.preventDefault();
            this.apply(Quantity.pasteQuantity(event.clipboardData.getData('text')));
        },
    }"
    x-effect="hydrate($wire.$get(@js($wireModel)))"
>
    <input type="hidden" wire:ignore x-ref="model" {{ $binding }}="{{ $wireModel }}" />
    <x-ui.input
        {{ $attributes->whereDoesntStartWith('wire:model')->except(['@input', '@paste', '@blur']) }}
        :name="$attributes->get('name', $wireModel)"
        :placeholder="$placeholder ?? '0,000'"
        inputmode="decimal"
        x-bind:value="displayValue"
        x-on:input="{{ $inputEvent }}"
        x-on:paste="{{ $pasteEvent }}"
        x-on:blur="{{ $blurEvent }}"
    />
</div>
