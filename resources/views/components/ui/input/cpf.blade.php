@props([
    'label' => 'CPF',
    'placeholder' => '000.000.000-00',
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
    x-mask="999.999.999-99"
    {{ $attributes->merge(['inputmode' => 'numeric', 'maxlength' => 14]) }}
/>
