<section>
    <form
        wire:submit.prevent="save"
        novalidate
        class="[&_input]:min-h-11 [&_input]:h-11! [&_input]:min-w-0 [&_input]:border-base-300 [&_input]:focus:ring-primary [&_input]:focus-visible:outline-primary [&_input+span]:min-h-11 [&_input+span_button]:size-11 [&_div:has(>input)]:h-11! min-w-0"
    >
        <x-ui.card
            class="overflow-hidden rounded-2xl border border-base-300 shadow-none sm:rounded-2xl! sm:shadow-none!"
            heading-level="h2"
            :header="'Informações do Perfil'"
            :description="'Atualize as informações do perfil e o endereço de e-mail da sua conta.'"
            :divided="true"
        >
            <x-slot name="slot">
                <div class="flex max-w-xl flex-col gap-5">
                    <x-ui.input id="name" label="Nome" name="name" type="text" required wire:model="name" placeholder="Digite seu nome" />

                    <x-ui.input
                        id="email"
                        label="Email"
                        name="email"
                        type="email"
                        required
                        wire:model="email"
                        placeholder="Digite seu e-mail"
                    />
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-ui.button primary class="min-h-11 w-full sm:w-auto" type="submit" loading="save"> Salvar </x-ui.button>
            </x-slot>
        </x-ui.card>
    </form>
</section>
