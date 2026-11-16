<div>
    <x-ui.modal id="restore-modal" title="Ativar" divided>
        <p class="text-base leading-relaxed text-secondary">Tem certeza que deseja ativar o usuário?</p>

        <x-slot name="footer">
            <div class="flex w-full flex-wrap items-center justify-end gap-3 bg-base-200 p-4 sm:px-6">
                <x-ui.button id="cancel-button" neutral outline class="min-h-11" wire:click="closeModal">Cancelar</x-ui.button>
                <x-ui.button id="restore-button" success class="min-h-11" wire:click="restore">Ativar</x-ui.button>
            </div>
        </x-slot>
    </x-ui.modal>
</div>
