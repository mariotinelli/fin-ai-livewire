<?php

declare(strict_types = 1);

namespace App\Livewire;

use App\Support\Navigation\SidebarGroup;
use App\Support\Navigation\SidebarItem;
use App\Support\Navigation\SidebarMenuBuilder;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

/** @property-read array<int, SidebarGroup> $groups */
class Sidebar extends Component
{
    protected SidebarMenuBuilder $menuBuilder;

    public function boot(SidebarMenuBuilder $menuBuilder): void
    {
        $this->menuBuilder = $menuBuilder;
    }

    public function render(): View
    {
        return view('livewire.sidebar');
    }

    /** @return array<int, SidebarGroup> */
    #[Computed]
    public function groups(): array
    {
        return $this->menuBuilder->buildFor(user());
    }

    /** @return array<int, SidebarItem> */
    #[Computed]
    public function mobileItems(): array
    {
        return collect($this->groups)
            ->flatMap(fn (SidebarGroup $group): array => $group->items)
            ->take(3)
            ->values()
            ->all();
    }
}
