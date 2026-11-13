@props(['prefix',])

<a
    x-bind:id="getPreviewId(@js($prefix), 'video', (typeof index !== 'undefined' ? index : null))"
    :href="file.preview"
    target="_blank"
    rel="noopener noreferrer"
    class="flex size-16 shrink-0 items-center justify-center rounded-md bg-info/10"
>
    <x-icons.video-camera class="size-9 text-info" />
</a>
