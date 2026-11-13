@props(['prefix', 'oldFile' => false,])

<div
    x-bind:id="@js($prefix) + '-file-remove-' + index"
    class="p-1 text-base-content/50 hover:cursor-pointer hover:bg-base-200 hover:text-error"
    @click="removeFile(index, @js((bool) $oldFile))"
>
    <x-icons.x-mark class="size-5" />
</div>
