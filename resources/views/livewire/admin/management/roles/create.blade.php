<div>
    <x-ui.button id="create-role-button" primary wire:click="loadRole" icon="plus"> Novo Perfil </x-ui.button>

    <x-ui.modal id="create-role-modal" xl3 :clickAway="false" divided scrollable>
        <x-slot name="title">
            Novo Perfil
        </x-slot>

        <x-slot name="description">
            Preencha os campos abaixo para cadastrar um novo perfil no sistema.
        </x-slot>

        <fieldset class="w-full space-y-6" aria-label="Dados do perfil" wire:loading.attr="disabled" wire:target="save">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <x-ui.input id="create-role-name" required label="Nome" placeholder="Nome do perfil" wire:model="role.name" />

                <x-ui.input.select-search
                    id="create-role-template"
                    :route="route('search.roles')"
                    wire:model.blur="template"
                    label="Modelo"
                />

                <x-ui.input.textarea
                    id="create-role-description"
                    parent-class="col-span-full"
                    label="Descrição"
                    wire:model="role.description"
                />
            </div>

            <x-ui.roles.permissions.group wire:model="selectedPermissions" />
        </fieldset>
    </x-ui.modal>
</div>
