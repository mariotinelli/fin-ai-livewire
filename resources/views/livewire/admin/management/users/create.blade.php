<div>
    <x-ui.button id="create-user-button" primary wire:click="loadUser" icon="plus"> Novo Usuário </x-ui.button>

    <x-ui.modal id="create-user-modal" xl :clickAway="false" divided>
        <x-slot name="title">
            Novo Usuário
        </x-slot>

        <x-slot name="description">
            Preencha os campos abaixo para adicionar um novo usuário.
        </x-slot>

        <fieldset class="flex w-full flex-col gap-6" aria-label="Dados do usuário" wire:loading.attr="disabled" wire:target="save">
            <div class="w-full">
                <x-ui.input id="create-user-name" required label="Nome" placeholder="Nome do usuário" wire:model="user.name" />
            </div>

            <div class="flex w-full gap-6">
                <div class="min-w-0 flex-1">
                    <x-ui.input
                        id="create-user-email"
                        type="email"
                        required
                        label="E-mail"
                        placeholder="E-mail do usuário"
                        wire:model="user.email"
                    />
                </div>
                <div class="min-w-0 flex-1">
                    <x-ui.input.select-search
                        id="create-user-role"
                        name="user.role_id"
                        label="Perfil"
                        required
                        wire:model.blur="user.role_id"
                        :route="route('search.roles')"
                    />
                </div>
            </div>
        </fieldset>
    </x-ui.modal>
</div>
