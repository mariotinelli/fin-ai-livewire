@props([
    'label' => 'CPF/CNPJ',
    'placeholder' => 'CPF/CNPJ',
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
    x-mask:dynamic="/[A-Za-z]/.test($input) || $input.replace(/\D/g, '').length > 11 ? '**.***.***/****-99' : '999.999.999-99'"
    {{ $attributes->merge(['inputmode' => 'text', 'maxlength' => 18]) }}
/>
