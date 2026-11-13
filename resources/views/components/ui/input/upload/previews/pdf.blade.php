@props(['prefix',])

<a
    x-bind:id="getPreviewId(@js($prefix), 'pdf', (typeof index !== 'undefined' ? index : null))"
    :href="file.preview"
    target="_blank"
    rel="noopener noreferrer"
    class="flex size-16 flex-shrink-0 items-center justify-center rounded-md bg-error/10 hover:cursor-pointer"
>
    <x-icons.document-text class="size-9 text-error" />
</a>
