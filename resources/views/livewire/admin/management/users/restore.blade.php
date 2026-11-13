<div>
    <x-ui.modal id="restore-modal" title="Ativar" divided>
        <p class="text-md text-base-content/65">Tem certeza que deseja ativar o usuário?</p>

        <x-slot name="footer">
            <div class="flex w-full items-center justify-end gap-2 bg-base-200 p-3">
                <x-ui.button id="cancel-button" neutral sm wire:click="closeModal">Cancelar</x-ui.button>
                <x-ui.button id="restore-button" success sm wire:click="restore">Ativar</x-ui.button>
            </div>
        </x-slot>
    </x-ui.modal>
</div>
