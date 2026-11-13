<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Management\Users;

use App\Enums\SortDirection;
use App\Enums\Status;
use App\Enums\TypeUsers;
use App\Models\User;
use App\Traits\Components\WithTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    use WithTable {
        applyFilters as private applyTableFilters;
        resetFilters as private resetTableFilters;
    }

    /** @var array<string, mixed> */
    #[Locked]
    public array $filters = [];

    #[On('users::refresh')]
    public function render(): View
    {
        return view('livewire.admin.management.users.index');
    }

    public function mount(): void
    {
        $this->authorize('viewAny', User::class);

        $this->initializeFilters();
    }

    public function resetFilters(): void
    {
        $this->authorize('viewAny', User::class);
        $this->resetTableFilters();
        $this->resetValidation();
    }

    public function applyFilters(): bool
    {
        $this->authorize('viewAny', User::class);
        $this->validate(attributes: [
            'filterDraft'         => 'filtros',
            'filterDraft.roles'   => 'perfis',
            'filterDraft.roles.*' => 'perfil',
            'filterDraft.status'  => 'status',
        ]);

        return $this->applyTableFilters();
    }

    /** @return array<string, mixed> */
    protected function rules(): array
    {
        return [
            'filterDraft'         => ['required', 'array:roles,status'],
            'filterDraft.roles'   => ['present', 'array', 'list'],
            'filterDraft.roles.*' => ['required', 'integer', 'min:1', 'distinct'],
            'filterDraft.status'  => ['required', 'string', Rule::enum(Status::class)],
        ];
    }

    #[Computed]
    public function activeFilterCount(): int
    {
        if (!$this->appliedFiltersAreValid()) {
            return 0;
        }

        return (int) ($this->filters['roles'] !== []) + (int) ($this->filters['status'] !== Status::All->value);
    }

    /** @return array<string, mixed> */
    public function emptyFilters(): array
    {
        return [
            'roles'  => [],
            'status' => Status::All->value,
        ];
    }

    /** @return LengthAwarePaginator<int, User> */
    #[Computed]
    public function users(): LengthAwarePaginator
    {
        if (!$this->appliedFiltersAreValid()) {
            return new LengthAwarePaginator([], 0, $this->normalizedPerPage(), $this->normalizedPage());
        }

        /** @var array{roles: list<int|numeric-string>, status: string} $filters */
        $filters = $this->filters;

        return User::query()
            ->with('role')
            ->where('type', TypeUsers::User)
            ->withTrashed()
            ->when($filters['roles'], fn (Builder $query): Builder => $query->whereIn('role_id', $filters['roles']))
            ->filterByTrashed(Status::tryFrom((string) $filters['status']))
            ->search($this->search)
            ->orderBy($this->sortKeyName, SortDirection::from($this->sortDirection)->value)
            ->paginate($this->normalizedPerPage());
    }

    /** @return list<array<string, string>> */
    #[Computed]
    public function breadcrumb(): array
    {
        return [
            [
                'label' => 'Usuários',
            ],
        ];
    }
}
