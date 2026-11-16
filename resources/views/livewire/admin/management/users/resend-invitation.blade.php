<div>
    <x-ui.modal id="resend-invitation-modal" title="Reenviar convite de acesso" divided>
        <p class="text-base leading-relaxed wrap-anywhere">Deseja reenviar o convite para {{ $user?->name }} ({{ $user?->email }})?</p>
        <p class="mt-4 text-sm leading-relaxed text-secondary">O convite anterior será substituído por um novo link para definir a senha.</p>

        @error('invitation')
            <p role="alert" class="text-error">{{ $message }}</p>
        @enderror

        <x-slot name="footer">
            <div class="flex w-full flex-wrap items-center justify-end gap-3 bg-base-200 p-4 sm:px-6">
                <x-ui.button id="cancel-resend-invitation-button" neutral outline class="min-h-11" wire:click="closeModal">
                    Cancelar</x-ui.button
                >
                <x-ui.button id="resend-invitation-button" primary class="min-h-11" wire:click="resend">Reenviar convite</x-ui.button>
            </div>
        </x-slot>
    </x-ui.modal>
</div>
