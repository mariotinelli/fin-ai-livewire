@props([
    'id' => null,
    'label' => null,
    'placeholder' => null,
    'xs' => false,
    'sm' => false,
    'md' => false,
    'lg' => false,
    'showError' => true,
    'maxLength' => 500,
    'hint' => null,
    'helperText' => null,
    'parentClass' => null,
])

@php($name ??= $attributes->wire('model')->value())
@php($id ??= $name)

<div class="w-full {{ $parentClass }}">
    <div class="flex flex-col gap-1">
        @if ($label)
            <div class="flex items-center justify-between">
                <x-ui.input.label :id="$id" :name="$name" :label="$label" :required="$attributes->get('required')" />

                @if ($hint)
                    <span class="text-sm text-base-content/65">{{ $hint }}</span>
                @endif
            </div>
        @endif

        <textarea
            {{ $attributes->wire('model') }}
            {{
                $attributes->merge([
                    'id'          => $id,
                    'name'        => $name,
                    'placeholder' => $placeholder ?? $label,
                    'maxlength'   => $maxLength,
                ])->class([
                    'text-base-content resize-none p-2 border border-base-content/10 rounded-lg w-full text-sm font-normal
                focus:ring-1 focus:ring-primary focus:border-primary focus:outline-hidden disabled:bg-base-200',
                    'border-error! ring-0!' => $errors->has($name),
                ])
            }}
            x-ref="textarea{{ $id }}"
        ></textarea>
    </div>

    @if ($showError)
        @error($name)
            <x-ui.input.error :message="$message" />
        @enderror
    @endif

    @if ($helperText)
        <span class="text-sm break-words text-base-content/65">{{ $helperText }}</span>
    @endif
</div>
