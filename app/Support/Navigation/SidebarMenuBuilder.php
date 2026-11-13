<?php

declare(strict_types = 1);

namespace App\Support\Navigation;

use App\Models\User;
use App\Support\Navigation\Contracts\DefinesSidebarMenu;
use App\Support\Navigation\Definitions\AdminSidebarMenu;
use App\Support\Navigation\Definitions\BaseSidebarMenu;
use App\Support\Navigation\Definitions\SupportRemSoftSidebarMenu;

final class SidebarMenuBuilder
{
    /**
     * @return array<int, SidebarGroup>
     */
    public function buildFor(?User $user): array
    {
        if (!$user instanceof User) {
            return [];
        }

        $groups = [];

        foreach ($this->definitionsFor($user) as $definition) {
            foreach ($definition->groups() as $group) {
                $groups[$group->key] ??= new SidebarGroup($group->key, $group->label, []);
                $groups[$group->key] = new SidebarGroup(
                    key: $groups[$group->key]->key,
                    label: $groups[$group->key]->label ?? $group->label,
                    items: [...$groups[$group->key]->items, ...$group->items],
                );
            }
        }

        return array_values($this->filterVisibleGroups($groups, $user));
    }

    /**
     * @return array<int, DefinesSidebarMenu>
     */
    private function definitionsFor(User $user): array
    {
        if ($user->isCustomer()) {
            return [new BaseSidebarMenu('customer.dashboard')];
        }

        if ($user->isSupportRemSoft()) {
            return [new SupportRemSoftSidebarMenu()];
        }

        return [new AdminSidebarMenu()];
    }

    /**
     * @param  array<string, SidebarGroup>  $groups
     * @return array<string, SidebarGroup>
     */
    private function filterVisibleGroups(array $groups, User $user): array
    {
        $visibleGroups = [];

        foreach ($groups as $group) {
            $visibleItems = [];

            foreach ($group->items as $item) {
                if ($item->permission && !$user->can($item->permission->ability, ...$item->permission->arguments)) {
                    continue;
                }

                $visibleItems[] = $item;
            }

            if ($visibleItems === []) {
                continue;
            }

            $visibleGroups[$group->key] = new SidebarGroup(
                key: $group->key,
                label: $group->label,
                items: $visibleItems,
            );
        }

        return $visibleGroups;
    }
}
