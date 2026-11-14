<section>
    <form
        wire:submit.prevent="updatePassword"
        class="[&_input]:min-h-11 [&_input]:h-11! [&_input]:min-w-0 [&_input]:border-base-300 [&_input]:focus:ring-primary [&_input]:focus-visible:outline-primary [&_input+span]:min-h-11 [&_input+span_button]:size-11 [&_div:has(>input)]:h-11! min-w-0"
    >
        <x-ui.card
            class="overflow-hidden rounded-2xl border border-base-300 shadow-none sm:rounded-2xl! sm:shadow-none!"
            heading-level="h2"
            :header="'Atualizar Senha'"
            :description="'Certifique-se de que sua conta está usando uma senha longa e aleatória para se manter segura.'"
            :divided="true"
        >
            <x-slot name="slot">
                <div class="flex max-w-xl flex-col gap-5">
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
                <x-ui.button primary class="min-h-11 w-full sm:w-auto" type="submit" loading="updatePassword"> Salvar </x-ui.button>
            </x-slot>
        </x-ui.card>
    </form>
</section>
