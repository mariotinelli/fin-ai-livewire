<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Management\Roles;

use App\Enums\SortDirection;
use App\Livewire\BaseComponent;
use App\Models\Role;
use App\Traits\Components\WithTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

class Index extends BaseComponent
{
    use WithTable;

    #[On('roles::refresh')]
    public function render(): View
    {
        return view('livewire.admin.management.roles.index');
    }

    public function mount(): void
    {
        $this->authorize('viewAny', Role::class);
    }

    /** @return LengthAwarePaginator<int, Role> */
    #[Computed]
    public function roles(): LengthAwarePaginator
    {
        return Role::query()
            ->withCount('users')
            ->when($this->search !== '', fn (Builder $query): Builder => $query->whereInsensitive('name', $this->search))
            ->orderBy($this->sortKeyName, SortDirection::from($this->sortDirection)->value)
            ->paginate($this->normalizedPerPage());
    }

    /** @return list<array<string, string>> */
    #[Computed]
    public function breadcrumb(): array
    {
        return [
            ['label' => 'Perfis'],
        ];
    }
}
