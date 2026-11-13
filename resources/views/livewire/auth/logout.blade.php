<button
    data-ui-loading-control
    type="button"
    wire:click="logout"
    class="flex w-full cursor-pointer items-center justify-start gap-2 rounded-lg p-2 text-base text-base-content/65 hover:bg-base-200 active:bg-base-300"
>
    <x-icons.arrow-left-start-on-rectangle class="h-6 min-h-6 w-6 min-w-6" />
    Sair
    <span data-ui-loading-spinner class="loading hidden loading-xs loading-spinner" aria-hidden="true"></span>
</button>
