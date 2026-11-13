<section>
    <form wire:submit.prevent="updatePassword" class="mt-6 space-y-6">
        <x-ui.card
            class="border-0 shadow-none"
            :header="'Atualizar Senha'"
            :description="'Certifique-se de que sua conta está usando uma senha longa e aleatória para se manter segura.'"
            :divided="true"
        >
            <x-slot name="slot">
                <div class="space-y-4">
                    <x-ui.input.password
                        id="current_password"
                        label="Senha Atual"
                        name="current_password"
                        required
                        autocomplete="current-password"
                        wire:model="current_password"
                    />

                    <x-ui.input.password
                        id="new_password"
                        label="Nova Senha"
                        name="password"
                        required
                        autocomplete="new-password"
                        wire:model="password"
                    />

                    <x-ui.input.password
                        id="password_confirmation"
                        label="Confirmar Nova Senha"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                        wire:model="password_confirmation"
                    />
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-ui.button primary base class="ms-1" type="submit" loading="updatePassword"> Salvar </x-ui.button>
            </x-slot>
        </x-ui.card>
    </form>
</section>
