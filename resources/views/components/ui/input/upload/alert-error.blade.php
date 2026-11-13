@props(['model',])

<div
    x-data="{
        model: @js($model),
        showAlertError: false,
        message: null,
        description: null,
        show(event) {
            if (event.detail.model !== this.model) {
                return;
            }

            this.message = event.detail.message;
            this.description = event.detail.description;
            this.showAlertError = true;
        }
    }"
    x-show="showAlertError"
    @validation-error-alert.window="show($event)"
    @clear-validation-errors.window="showAlertError = false"
    class="mt-2"
>
    <x-ui.quote error>
        <div class="flex items-start gap-3">
            <x-icons.exclamation-triangle class="size-5 text-error" />
            <div class="text-sm text-error">
                <p x-text="message"></p>
                <p class="mt-1 text-xs text-base-content/65" x-show="description" x-text="description"></p>
            </div>
        </div>
    </x-ui.quote>
</div>
