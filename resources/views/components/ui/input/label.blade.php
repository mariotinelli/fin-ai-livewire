@props(['id', 'name' => null, 'labelId' => null, 'label', 'required' => false,])

<label for="{{ $id }}" @if ($labelId) id="{{ $labelId }}" @endif {{ $attributes }}>
    <span
        @class([
            'text-base-content text-sm font-medium leading-5 relative',
            'text-error' => isset($errors) && $errors->has($name ?? $id)
        ])
    >
        {{ $label ?? $slot }}

        @if ($required)
            <span class="absolute top-0 -right-2 text-xs text-error"> * </span>
        @endif
    </span>
</label>
