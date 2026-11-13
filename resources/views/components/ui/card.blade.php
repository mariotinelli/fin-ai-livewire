@php
    use Illuminate\Support\HtmlString;
    use Illuminate\View\ComponentSlot;
@endphp

@props([
    'header' => null,
    'description' => null,
    'divided' => null,
    'headerAction' => null,
    'footer' => null,
    'collapse' => false,
    'collapsed' => false,
    'wizard' => false,
    'headingLevel' => 'h3',
    'asArticle' => false,
])

@php
    $allowedHeadingLevels = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'];
    $headingTag           = in_array($headingLevel, $allowedHeadingLevels, true) ? $headingLevel : 'h3';

    $simpleHeader = $header && !$header instanceof HtmlString && !$header instanceof ComponentSlot;

    $headingId    = 'card-title-' . str()->ulid();
    $containerTag = $asArticle ? 'article' : 'div';

    $fallbackHeadingText = trim(strip_tags((string) $header)) !== ''
        ? trim(strip_tags((string) $header))
        : 'Conteúdo do card';
@endphp

<{{ $containerTag }}
    {{
        $attributes->class([
            'bg-base-100',
            'divide-y divide-base-300'             => $divided && !$collapse,
            'sm:rounded-lg sm:shadow-sm sm:border' => !$wizard,
            'rounded-b-lg'                         => $wizard,
        ])
    }}
    @if ($asArticle) aria-labelledby="{{ $headingId }}" @endif
    @if ($collapse)
        x-data="{ open: @js(!$collapsed) }"
        x-bind:class="open ? 'divide-y divide-base-300' : ''"
    @endif
>
    <div
        @class([
            'px-4 sm:px-6 flex flex-col md:flex-row justify-between md:items-center focus:outline focus:outline-2 focus:outline-primary focus:outline-offset-2 focus:ring-2 focus:ring-primary focus:ring-inset focus-visible:outline focus-visible:outline-2 focus-visible:outline-primary focus-visible:outline-offset-2 focus-visible:ring-2 focus-visible:ring-primary focus-visible:ring-inset',
            'cursor-pointer select-none' => $collapse
        ])
        @if ($collapse)
            @click="open = !open"
            role="button"
            tabindex="0"
            @keydown.enter="open = !open"
            @keydown.space.prevent="open = !open"
            x-bind:aria-expanded="open"
        @endif
    >
        @if (!$wizard)
            @if ($simpleHeader)
                <div class="flex flex-col gap-1 py-4">
                    <{{ $headingTag }}
                        id="{{ $headingId }}"
                        @class(['py-0 font-semibold text-base-content text-xl', 'mb-1' => $description, 'mb-0' => !$description])
                    >
                        {{ $header }}
                    </{{ $headingTag }}>

                    @if ($description)
                        <p class="text-sm text-base-content/65">{{ $description }}</p>
                    @endif
                </div>

            @elseif ($header)
                <div class="flex flex-col gap-1 py-4">
                    <{{ $headingTag }} id="{{ $headingId }}" class="sr-only"> {{ $fallbackHeadingText }} </{{ $headingTag }}>

                    {{ $header }}
                </div>

            @elseif ($asArticle)
                <{{ $headingTag }} id="{{ $headingId }}" class="sr-only"> {{ $fallbackHeadingText }} </{{ $headingTag }}>
            @endif

        @endif

        <div class="mb-2 flex items-center gap-2 md:mb-0">
            @if ($headerAction)
                <div @click.stop @keydown.stop>{{ $headerAction }}</div>
            @endif

            @if ($collapse)
                <x-icons.chevron-up
                    class="h-5 w-5 text-base-content/50 transition-transform duration-300"
                    x-bind:class="open ? '' : 'rotate-180'"
                    aria-hidden="true"
                />
            @endif
        </div>
    </div>

    <div
        @if ($collapse)
            x-show="open"
            x-collapse.duration.300ms
        @endif
    >
        <div
            @class([
                'py-3 px-6' => !$header && !$description,
                'px-6 py-6' => $header || $description
            ])
        >
            {{ $slot }}
        </div>

        @if ($footer)
            <footer class="flex items-center justify-end border-t border-base-200 bg-base-200 p-3 sm:rounded-b-lg">{{ $footer }}</footer>
        @endif
    </div>
</{{ $containerTag }}>
