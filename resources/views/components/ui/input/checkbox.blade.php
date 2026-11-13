@use(Illuminate\Support\HtmlString)
@use(Illuminate\Support\Str)
@use(Illuminate\Support\ViewErrorBag)
@use(Illuminate\View\ComponentSlot)

@props([
    'id' => null,
    'name' => null,
    'label' => null,
    'xs' => false,
    'sm' => false,
    'md' => false,
    'lg' => false,
    'primary' => false,
    'success' => false,
    'warning' => false,
    'error' => false,
    'info' => false,
    'showError' => true,
    'helperText' => null,
    'inline' => true,
    'rightLabel' => true,
])

@php
    $name       = $name ?? $attributes->wire('model')->value();
    $value      = (string) ($attributes->get('value') ?? 'on');
    $id         = $id ?? ($name ? Str::slug($name . '-' . $value) : uniqid('checkbox-'));
    $viewErrors = $errors ?? new ViewErrorBag();
    $errors     = $viewErrors;
    $hasError   = $name ? $viewErrors->has($name) : false;

    $errorId      = $id . '-error';
    $helperTextId = $id . '-helper';

    $describedBy = collect([
        $showError && $hasError ? $errorId : null,
        $helperText ? $helperTextId : null,
    ])->filter()->implode(' ');
@endphp

<fieldset class="relative m-0 flex min-w-0 flex-col gap-1 border-0 p-0">
    @if ($label && !$inline)
        <legend @class(['text-base-content text-sm font-medium leading-5', 'text-error' => $hasError])>{{ $label }}</legend>
    @endif

    <div>
        <div class="flex items-center gap-2">
            @if ($label && $inline && !$rightLabel)
                <x-ui.input.label :id="$id" :name="$name" :label="$label" :required="$attributes->get('required')" />
            @endif

            <div class="flex items-center">
                <input
                    type="checkbox"
                    {{ $attributes->wire('model') }}
                    {{
                        $attributes->except('type')->merge([
                            'id'                => $id,
                            'name'              => $name,
                            'autocomplete'      => 'off',
                            'aria-describedby'  => $describedBy ?: null,
                            'aria-invalid'      => $hasError ? 'true' : null,
                            'aria-errormessage' => $showError && $hasError ? $errorId : null,
                            'aria-required'     => $attributes->get('required') ? 'true' : null,
                        ])->class([
                            'checkbox border-base-content/25',
                            'checkbox-error'         => $hasError,
                            'checkbox-primary'       => $primary || (!$success && !$warning && !$error && !$info),
                            'checkbox-success'       => $success,
                            'checkbox-warning'       => $warning,
                            'checkbox-error'         => $error,
                            'checkbox-info'          => $info,
                            'checkbox-xs rounded-md' => $xs || (!$sm && !$md && !$lg),
                            'checkbox-sm'            => $sm,
                            'checkbox-md'            => $md,
                            'checkbox-lg'            => $lg,
                        ])
                    }}
                />
            </div>

            @if ($label && !$inline)
                <x-ui.input.label :id="$id" :name="$name" :label="$label" :required="$attributes->get('required')" class="sr-only" />
            @endif

            @if ($label && $inline && $rightLabel)
                <x-ui.input.label :id="$id" :name="$name" :label="$label" :required="$attributes->get('required')" class="cursor-pointer" />
            @endif
        </div>

        @if ($showError)
            @error($name)
                <x-ui.input.error :id="$errorId" :message="$message" />
            @enderror
        @endif

        @if ($helperText)
            <small id="{{ $helperTextId }}" class="text-sm break-words text-base-content/65">{{ $helperText }}</small>
        @endif
    </div>
</fieldset>
