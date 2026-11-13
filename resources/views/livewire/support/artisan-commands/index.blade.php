<x-ui.page
    title="Comandos"
    description="Execute comandos autorizados para este ambiente. Dados sensíveis são omitidos do histórico."
    :breadcrumb="$this->breadcrumb"
>
    <x-ui.card divided>
        <div
            x-data="{ commandInput: '' }"
            x-on:autocomplete-local-updated.window="commandInput = $event.detail.value"
            x-on:artisan-commands-clear-input.window="commandInput = ''"
            class="flex flex-col gap-4"
        >
            <div class="flex w-full">
                <x-ui.input.commands.autocomplete
                    id="artisan-command-input"
                    label="Comando"
                    placeholder="php artisan about"
                    helper-text="Somente comandos e combinações de argumentos explicitamente autorizados."
                    :items="$this->artisanCommands"
                    event-name="autocomplete-local-updated"
                />
            </div>

            @error('commandInput')
                <x-ui.input.error :message="$message" />
            @enderror
        </div>
    </x-ui.card>

    <livewire:support.artisan-commands.history />
</x-ui.page>
