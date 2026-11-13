@use('App\Enums\Can')

@props(['header', 'description', 'id' => null])

@php
    $model = $attributes->wire('model')->value();
    $instanceId = $id ?? 'permissions-' . (isset($__livewire) ? $__livewire->getId() : str()->ulid()) . '-' . substr(hash('sha256', (string) $model), 0, 12);
@endphp

<div
    id="{{ $instanceId }}"
    data-permissions-list
    x-data="{ selectedPermissions: @entangle($model), totalPermissions: 0, checkedAll: false }"
>
    <x-ui.card
        divided
        :header="$header ?? 'Permissões'"
        :description="$description ?? 'Selecione as permissões que deseja atribuir a este perfil.'"
    >
        <x-slot name="headerAction">
            <x-ui.button
                x-show="!checkedAll"
                id="{{ $instanceId }}-select-all"
                data-select-all-permissions
                primary
                xs
                outline
                icon="check"
                @click="$dispatch('select-all-permissions')"
            >
                Marcar todas
            </x-ui.button>

            <x-ui.button
                x-effect="checkedAll = this.selectedPermissions?.length < this.totalPermissions"
                x-show="checkedAll"
                id="{{ $instanceId }}-unmark-all"
                data-unmark-all-permissions
                primary
                xs
                outline
                icon="x-mark"
                @click="$dispatch('unmark-all-permissions')"
            >
                Desmarcar todas
            </x-ui.button>
        </x-slot>

        <div class="space-y-4">
            @foreach (Can::groups() as $groupKey => $group)
                @php
                    $groupId = $instanceId . '-group-' . $groupKey;
                    $permissions = $group->permissions ?? collect($group->group)->pluck('permissions')->flatten()->toArray();
                @endphp

                <div
                    id="{{ $groupId }}"
                    wire:key="{{ $groupId }}"
                    data-permissions-group
                    class="overflow-hidden rounded-lg border"
                    x-ref="group"
                    x-data="{
                        open: false,
                        group: @js($group),
                        permissions: @js($permissions),
                        count: 0,
                        groupSelected: false,
                        model: @js($model),
                        init: function () {
                            this.totalPermissions += this.permissions.length;

                            this.refreshPermissions();

                            this.$watch('selectedPermissions', (value) => {
                                this.checkedAll = value.length === this.totalPermissions;

                                this.syncProperty();
                            });

                            this.$wire.on('select-template', (templatePermissions) => {
                                this.selectedPermissions = [...new Set(...templatePermissions)];
                                this.refreshPermissions();
                            });

                            this.$wire.on('select-all-permissions', () => {
                                this.selectedPermissions = [...new Set(this.selectedPermissions.concat(this.permissions))];
                                this.refreshPermissions();
                            });

                            this.$wire.on('unmark-all-permissions', () => {
                                this.selectedPermissions = this.selectedPermissions.filter(permission => ! this.permissions.includes(permission));
                                this.refreshPermissions();
                            });
                        },
                        get allSelected() {
                            return this.count === this.permissions.length;
                        },
                        refreshPermissions() {
                            this.count = 0;
                             if (this.selectedPermissions.length > 0) {
                                this.permissions.forEach(permission => {
                                    if (this.selectedPermissions.includes(permission)) {
                                        this.count++;
                                    }
                                });
                            }
                        },
                        selectPermission: function (checked, value) {
                            if (checked === true) {
                                const permission = this.permissions.find(permission => permission === value);
                                this.selectedPermissions = [...new Set(this.selectedPermissions.concat(permission))];
                                this.count++;

                                return;
                            }

                            this.groupSelected = false;
                            this.selectedPermissions = this.selectedPermissions.filter(permission => permission !== value);
                            this.count--;
                        },
                        selectGroup: function(checked) {
                            this.groupSelected = checked;

                            if (checked === true) {
                                this.selectedPermissions = [...new Set(this.selectedPermissions.concat(this.permissions))];
                                this.count = this.permissions.length;

                                return;
                            }

                            this.selectedPermissions = this.selectedPermissions.filter(permission => ! this.permissions.includes(permission));
                            this.count = 0;
                        },
                        syncProperty: function() {
                            this.$wire.set(this.model, this.selectedPermissions, false);
                        }
                    }"
                >
                    <x-ui.roles.permissions.group.header :group="$group" :group-key="$groupKey" :group-id="$groupId" />

                    <x-ui.roles.permissions.group.content :group="$group" :group-id="$groupId" />
                </div>
            @endforeach
        </div>

        @error($model)
            <x-ui.input.error :message="$message" />
        @enderror
    </x-ui.card>
</div>
