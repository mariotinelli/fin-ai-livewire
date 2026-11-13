<div>
    <x-ui.modal id="resend-invitation-modal" title="Reenviar convite de acesso" divided>
        <p>Deseja reenviar o convite para {{ $user?->name }} ({{ $user?->email }})?</p>
        <p>O convite anterior será substituído por um novo link para definir a senha.</p>

        @error('invitation')
            <p role="alert" class="text-error">{{ $message }}</p>
        @enderror

        <x-slot name="footer">
            <div class="flex w-full items-center justify-end gap-2 bg-base-200 p-3">
                <x-ui.button id="cancel-resend-invitation-button" neutral sm wire:click="closeModal">Cancelar</x-ui.button>
                <x-ui.button id="resend-invitation-button" info sm wire:click="resend">Reenviar convite</x-ui.button>
            </div>
        </x-slot>
    </x-ui.modal>
</div>
