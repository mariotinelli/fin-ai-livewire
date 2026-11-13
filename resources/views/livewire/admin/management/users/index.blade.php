@use('App\Enums\Status')
@use('App\Enums\Permissions\Management\UserPermissions')

<x-ui.page title="Usuários" :breadcrumb="$this->breadcrumb" description="Lista de usuários cadastrados">
    <x-slot name="headerActions">
        @can(UserPermissions::Create)
            <livewire:admin.management.users.create />
        @endcan
    </x-slot>

    <x-ui.table :records="$this->users" draft-filters :active-filter-count="$this->activeFilterCount">
        <x-slot name="filtersDropdown">
            <x-ui.input.multi-select-search
                id="user-filter-roles"
                label="Perfil"
                wire:model="filterDraft.roles"
                :route="route('search.roles')"
            />

            <x-ui.input.select
                id="user-filter-status"
                label="Status"
                :options="Status::toArray()"
                :clearable="false"
                wire:model="filterDraft.status"
            />
        </x-slot>

        <x-slot name="header">
            <x-ui.table.th name="name">Nome</x-ui.table.th>
            <x-ui.table.th name="email">E-mail</x-ui.table.th>
            <x-ui.table.th name="role_id">Perfil</x-ui.table.th>
            <x-ui.table.th name="deleted_at">Status</x-ui.table.th>
            <x-ui.table.th>Ações</x-ui.table.th>
        </x-slot>

        <x-slot name="body">
            @forelse ($this->users as $user)
                <x-ui.table.tr wire:key="user-{{ $user->id }}">
                    <x-ui.table.td>{{ $user->name }}</x-ui.table.td>
                    <x-ui.table.td>{{ $user->email }}</x-ui.table.td>
                    <x-ui.table.td>{{ $user->role->name }}</x-ui.table.td>
                    <x-ui.table.td>
                        @if ($user->trashed())
                            <x-ui.badge error>Inativo</x-ui.badge>
                        @else
                            <x-ui.badge success>Ativo</x-ui.badge>
                        @endif
                    </x-ui.table.td>
                    <x-ui.table.td>
                        <div class="flex items-center">
                            @can('resendInvitation', $user)
                                <x-ui.table.action
                                    id="resend-user-invitation-button-{{ $user->id }}"
                                    tooltip="Reenviar convite"
                                    icon="arrow-path"
                                    class="text-info"
                                    @click="$dispatch('users::resend-invitation', { id: {{ $user->id }} })"
                                />
                            @endcan
                            @can(UserPermissions::Edit)
                                <x-ui.table.action
                                    id="edit-user-button-{{ $user->id }}"
                                    tooltip="Editar"
                                    icon="pencil-square"
                                    class="text-info"
                                    @click="$dispatch('users::update', { userId: {{ $user->id }} })"
                                    wire:target="$dispatch('users::update', { userId: {{ $user->id }} })"
                                />
                            @endcan
                            @if (!$user->trashed())
                                @can(UserPermissions::Delete)
                                    <x-ui.table.action
                                        id="delete-user-button-{{ $user->id }}"
                                        tooltip="Desativar"
                                        icon="x-circle"
                                        class="text-error"
                                        @click="$dispatch('users::delete', { id: {{ $user->id }} })"
                                    />
                                @endcan
                            @else
                                @can(UserPermissions::Restore)
                                    <x-ui.table.action
                                        id="restore-user-button-{{ $user->id }}"
                                        tooltip="Ativar"
                                        icon="arrow-path"
                                        class="text-success"
                                        @click="$dispatch('users::restore', { id: {{ $user->id }} })"
                                    />
                                @endcan
                            @endif
                        </div>
                    </x-ui.table.td>
                </x-ui.table.tr>
            @empty
                <x-ui.table.tr>
                    <x-ui.table.td colspan="5">
                        @if ($errors->has('filters'))
                            <x-ui.empty-state title="Consulta não executada" description="Revise os filtros para continuar." />
                        @elseif ($this->search !== '' ||
                            $this->filters['roles'] !== [] ||
                            (string) $this->filters['status'] !== (string) Status::All->value)
                            <x-ui.empty-state
                                title="Nenhum usuário encontrado"
                                description="Tente ajustar a busca ou os filtros aplicados."
                            >
                                @if ($this->search !== '')
                                    <x-ui.button xs neutral outline wire:click="$set('search', '')"> Limpar busca </x-ui.button>
                                @endif
                            </x-ui.empty-state>
                        @else
                            <x-ui.empty-state title="Nenhum usuário cadastrado" description="Os usuários cadastrados aparecerão aqui." />
                        @endif
                    </x-ui.table.td>
                </x-ui.table.tr>
            @endforelse
        </x-slot>
    </x-ui.table>

    @push('modals')
        <livewire:admin.management.users.delete />
        <livewire:admin.management.users.restore />
        <livewire:admin.management.users.update />
        <livewire:admin.management.users.resend-invitation />
    @endpush
</x-ui.page>
