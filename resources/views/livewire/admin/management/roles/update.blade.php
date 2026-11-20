<div>
    <x-ui.modal id="update-role-modal" xl3 :clickAway="false" divided scrollable>
        <x-slot name="title">
            Editar Perfil
        </x-slot>

        <x-slot name="description">
            Atualize os campos abaixo para editar o perfil.
        </x-slot>

        <fieldset class="flex w-full min-w-0 flex-col gap-8" aria-label="Dados do perfil" wire:loading.attr="disabled" wire:target="save">
            <div class="grid grid-cols-1 gap-6 rounded-2xl border border-base-300 bg-base-200/50 p-4 sm:grid-cols-2 sm:p-6">
                <x-ui.input id="update-role-name" required label="Nome" placeholder="Nome do perfil" wire:model="role.name" />

                <x-ui.input.select-search
                    id="update-role-template"
                    :route="route('search.roles')"
                    wire:model.blur="template"
                    label="Modelo"
                />

                <x-ui.input.textarea
                    id="update-role-description"
                    parent-class="col-span-full"
                    label="Descrição"
                    wire:model="role.description"
                />
            </div>

            <x-ui.roles.permissions.group wire:model="selectedPermissions" />
        </fieldset>
    </x-ui.modal>
</div>
