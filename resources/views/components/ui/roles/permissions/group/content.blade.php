@use(Illuminate\Support\Js)

@props(['group', 'groupId'])

<div id="{{ $groupId }}-content" x-cloak x-show="open" x-collapse.duration.400ms class="px-4 sm:px-6" x-bind:class="{ 'pb-6 pt-4': open }">
    <div class="space-y-3">
        @if ($group->permissions ?? null)
            <div class="grid grid-cols-1 gap-4 @xl:grid-cols-2">
                @foreach ($group->permissions as $permission)
                    <div class="flex min-w-0 items-start gap-3 rounded-lg border border-base-300 bg-base-100 p-4">
                        <x-ui.input.checkbox
                            :id="$groupId . '-permission-' . str($permission->value)->slug()"
                            data-permission-checkbox
                            :data-permission-value="$permission->value"
                            sm
                            :label="$permission->label()"
                            :helper-text="$permission->description()"
                            x-bind:checked="groupSelected || selectedPermissions.includes({{ Js::from($permission->value) }})"
                            @change="selectPermission($event.target.checked, {{ Js::from($permission->value) }})"
                        />
                    </div>
                @endforeach
            </div>
        @else
            <div class="space-y-6">
                @foreach ($group->group as $permissionsGroup)
                    <div class="space-y-3">
                        <p class="border-b border-base-300 pb-2 text-sm font-semibold text-primary">{{ $permissionsGroup->label }}</p>
                        <div class="grid grid-cols-1 gap-4 @xl:grid-cols-2">
                            @foreach ($permissionsGroup->permissions as $permission)
                                <div class="flex min-w-0 items-start gap-3 rounded-lg border border-base-300 bg-base-100 p-4">
                                    <x-ui.input.checkbox
                                        :id="$groupId . '-permission-' . str($permission->value)->slug()"
                                        data-permission-checkbox
                                        :data-permission-value="$permission->value"
                                        sm
                                        :label="$permission->label()"
                                        :helper-text="$permission->description()"
                                        x-bind:checked="groupSelected || selectedPermissions.includes({{ Js::from($permission->value) }})"
                                        @change="selectPermission($event.target.checked, {{ Js::from($permission->value) }})"
                                    />
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
