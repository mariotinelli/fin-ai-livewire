<section>
    <form wire:submit.prevent="save" novalidate class="mt-6 space-y-6">
        <x-ui.card
            class="border-0 shadow-none"
            :header="'Informações do Perfil'"
            :description="'Atualize as informações do perfil e o endereço de email da sua conta.'"
            :divided="true"
        >
            <x-slot name="slot">
                <div class="space-y-4">
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
                <x-ui.button primary base class="ms-1" type="submit" loading="save"> Salvar </x-ui.button>
            </x-slot>
        </x-ui.card>
    </form>
</section>
