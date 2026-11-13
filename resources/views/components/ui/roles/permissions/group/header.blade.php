@props(['group', 'groupKey', 'groupId'])

<div class="flex items-center justify-between bg-base-200" x-bind:class="{ 'border-b': open }">
    <div class="flex min-w-0 items-center gap-2 px-4 py-3" @click.stop>
        <x-ui.input.checkbox
            :id="$groupId . '-select'"
            name="permissions-{{ $groupKey }}"
            data-select-permissions-group
            sm
            x-bind:checked="allSelected"
            :label="$group->label"
            @change="selectGroup($event.target.checked)"
        />

        <div x-show="count > 0" class="flex items-center gap-1 rounded-full border border-base-300 px-3 py-0.5 text-xs font-semibold">
            <span x-text="count"></span>
            <span>/</span>
            <span>{{ count($group->permissions ?? collect($group->group)->pluck('permissions')->flatten()->toArray()) }}</span>
        </div>
    </div>

    <button
        id="{{ $groupId }}-toggle"
        type="button"
        data-toggle-permissions-group
        class="flex min-h-12 flex-1 cursor-pointer items-center justify-end self-stretch px-4 focus-visible:outline-2 focus-visible:-outline-offset-2 focus-visible:outline-primary"
        aria-controls="{{ $groupId }}-content"
        aria-expanded="false"
        aria-label="{{ 'Expandir grupo ' . $group->label }}"
        x-bind:aria-expanded="open"
        x-bind:aria-label="open ? @js('Recolher grupo ' . $group->label) : @js('Expandir grupo ' . $group->label)"
        @click="open = !open"
    >
        <x-icons.chevron-down
            class="size-4 text-base-content/50 transition-transform duration-200"
            x-bind:class="open ? 'rotate-180' : ''"
            aria-hidden="true"
        />
    </button>
</div>
