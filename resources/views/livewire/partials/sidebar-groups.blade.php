@foreach ($this->groups as $group)
    @if ($group->label)
        <x-ui.sidebar.group :name="$group->label" :context="$group->key" :mode="$sidebarMode">
            @foreach ($group->items as $item)
                <x-ui.sidebar.link
                    :route="$item->route"
                    :icon="$item->icon"
                    :name="$item->name"
                    :prefix="$item->prefix"
                    :mode="$sidebarMode"
                />
            @endforeach
        </x-ui.sidebar.group>
    @else
        <x-ui.sidebar.links>
            @foreach ($group->items as $item)
                <x-ui.sidebar.link
                    :route="$item->route"
                    :icon="$item->icon"
                    :name="$item->name"
                    :prefix="$item->prefix"
                    :mode="$sidebarMode"
                />
            @endforeach
        </x-ui.sidebar.links>
    @endif
@endforeach
