@props([
    'title',
    'breadcrumb',
    'description' => null,
    'headerActions' => null,
    'widgets' => null,
    'contentClass' => null,
    'fullHeight' => false,
])

<div data-page-title="{{ $title }}" @class(['flex h-full min-h-0 flex-col' => $fullHeight])>
    <div @class(['shrink-0' => $fullHeight])>
        <x-ui.breadcrumb :items="$breadcrumb" />

        <x-ui.page.header :title="$title" :description="$description" :actions="$headerActions" />

        @if ($widgets)
            <x-ui.page.widgets> {{ $widgets }} </x-ui.page.widgets>
        @endif
    </div>

    <div @class(['mt-6' => !$fullHeight, 'min-h-0 flex-1' => $fullHeight, $contentClass])>{{ $slot }}</div>
</div>
