@use('App\Enums\Permissions\Management\RolePermissions')

<x-ui.page title="Perfis" description="Lista de perfis cadastrados" :breadcrumb="$this->breadcrumb">
    @can(RolePermissions::Create)
        <x-slot name="headerActions">
            <livewire:admin.management.roles.create />
        </x-slot>
    @endcan

    <div class="space-y-4">
        <x-ui.table :records="$this->roles">
            <x-slot name="header">
                <x-ui.table.th name="name">Nome</x-ui.table.th>
                <x-ui.table.th name="description">Descrição</x-ui.table.th>
                <x-ui.table.th name="created_at">Criado em</x-ui.table.th>
                <x-ui.table.th name="updated_at">Atualizado em</x-ui.table.th>
                <x-ui.table.th name="users_count">Total de usuários</x-ui.table.th>
                <x-ui.table.th>Ações</x-ui.table.th>
            </x-slot>

            <x-slot name="body">
                @forelse ($this->roles as $role)
                    <x-ui.table.tr wire:key="role-{{ $role->id }}">
                        <x-ui.table.td>{{ $role->name }}</x-ui.table.td>
                        <x-ui.table.td>
                            <span data-tip="{{ $role->description }}" @class(['tooltip' => str($role->description)->length() > 20])>
                                {{ str($role->description ?? '-')->limit(20) }}
                            </span>
                        </x-ui.table.td>
                        <x-ui.table.td>{{ $role->created_at->format('d/m/Y H:i') }}</x-ui.table.td>
                        <x-ui.table.td>{{ $role->updated_at->format('d/m/Y H:i') }}</x-ui.table.td>
                        <x-ui.table.td>{{ $role->users_count }}</x-ui.table.td>
                        <x-ui.table.td>
                            <div class="flex items-center">
                                @can(RolePermissions::Edit)
                                    <x-ui.table.action
                                        id="edit-role-button-{{ $role->id }}"
                                        tooltip="Editar"
                                        icon="pencil-square"
                                        class="text-info"
                                        @click="$dispatch('roles::update', { roleId: {{ $role->id }} })"
                                    />
                                @endcan
                            </div>
                        </x-ui.table.td>
                    </x-ui.table.tr>
                @empty
                    <x-ui.table.tr>
                        <x-ui.table.td colspan="6">
                            @if ($this->search !== '')
                                <x-ui.empty-state title="Nenhum perfil encontrado" description="Tente buscar por outro nome de perfil.">
                                    <x-ui.button xs neutral outline wire:click="$set('search', '')"> Limpar busca </x-ui.button>
                                </x-ui.empty-state>
                            @else
                                <x-ui.empty-state title="Nenhum perfil cadastrado" description="Os perfis cadastrados aparecerão aqui." />
                            @endif
                        </x-ui.table.td>
                    </x-ui.table.tr>
                @endforelse
            </x-slot>
        </x-ui.table>
    </div>

    @push('modals')
        <livewire:admin.management.roles.update />
    @endpush
</x-ui.page>
