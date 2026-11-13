@props([
    'label' => 'CNPJ',
    'placeholder' => '00.000.000/0000-00',
    'helperText' => null,
    'parentClass' => null,
    'showError' => true,
    'disableWhileLoading' => false,
])

<x-ui.input
    :label="$label"
    :placeholder="$placeholder"
    :helper-text="$helperText"
    :parent-class="$parentClass"
    :show-error="$showError"
    :disable-while-loading="$disableWhileLoading"
    x-mask="**.***.***/****-99"
    {{ $attributes->merge(['inputmode' => 'text', 'maxlength' => 18]) }}
/>
