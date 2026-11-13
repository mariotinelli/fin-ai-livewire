@props(['prefix', 'oldFile' => false, 'disabled' => false,])

<div class="flex items-start space-x-4 rounded-lg border border-base-300 bg-base-100 p-4 shadow-sm">
    <template x-if="file.type.includes('video') || getPreviewMimeTypes('video').includes(file.type)">
        <x-ui.input.upload.previews.video :prefix="$prefix" />
    </template>

    <template x-if="file.type.includes('pdf') || getPreviewMimeTypes('document').includes(file.type)">
        <x-ui.input.upload.previews.pdf :prefix="$prefix" />
    </template>

    <template x-if="file.type.includes('image') || getPreviewMimeTypes('image').includes(file.type)">
        <x-ui.input.upload.previews.image :prefix="$prefix" />
    </template>

    <x-ui.input.upload.details :loading="!$disabled" />

    @if (!$disabled)
        <x-ui.input.upload.remove-button :prefix="$prefix" :old-file="$oldFile" />
    @endif
</div>
