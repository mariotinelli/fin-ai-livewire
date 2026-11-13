<?php

declare(strict_types = 1);

namespace App\Traits\Components;

use App\Enums\SortDirection;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\Locked;
use Livewire\WithPagination;

trait WithTable
{
    use WithPagination;

    private const array SAFE_PER_PAGE_VALUES = [10, 25, 50];

    public mixed $perPage = 10;

    /** @var list<int> */
    #[Locked]
    public array $perPageValues = self::SAFE_PER_PAGE_VALUES;

    public string $search = '';

    /** @var array<string, mixed> */
    public array $filters = [];

    /** @var array<string, mixed> */
    public array $filterDraft = [];

    public string $sortKeyName = 'id';

    public string $sortDirection = SortDirection::Desc->value;

    public bool $toggleOnlyTrashed = false;

    public function sortBy(string $key): void
    {
        if ($key === $this->sortKeyName) {
            $this->sortDirection = $this->sortDirection === SortDirection::Asc->value ? SortDirection::Desc->value : SortDirection::Asc->value;

            return;
        }

        $this->sortKeyName   = $key;
        $this->sortDirection = SortDirection::Asc->value;
    }

    public function updatedPerPage(): void
    {
        $this->perPage = $this->normalizedPerPage();
        $this->resetPage();
    }

    protected function appliedFiltersAreValid(): bool
    {
        /** @var array<string, mixed> $componentRules */
        $componentRules = $this->getRules();
        $rules          = array_filter(
            $componentRules,
            fn (string $key): bool => $key === 'filterDraft' || str_starts_with($key, 'filterDraft.'),
            ARRAY_FILTER_USE_KEY,
        );
        $validator = Validator::make(['filterDraft' => $this->filters], $rules);

        if ($validator->fails()) {
            $this->addError('filters', 'Os filtros aplicados são inválidos. Limpe ou aplique filtros válidos para continuar.');

            return false;
        }

        $this->resetValidation('filters');

        return true;
    }

    protected function normalizedPage(): int
    {
        $page = $this->getPage();

        return is_numeric($page) ? max(1, (int) $page) : 1;
    }

    protected function normalizedPerPage(): int
    {
        foreach (self::SAFE_PER_PAGE_VALUES as $value) {
            if ($this->perPage === $value || $this->perPage === (string) $value) {
                return $value;
            }
        }

        return 10;
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    protected function initializeFilters(): void
    {
        $this->filters     = $this->emptyFilters();
        $this->filterDraft = $this->filters;
    }

    public function applyFilters(): bool
    {
        $this->filters = $this->filterDraft;
        $this->resetPage();

        return true;
    }

    public function resetFilters(): void
    {
        $this->initializeFilters();
        $this->resetPage();
    }

    /** @return array<string, mixed> */
    public function emptyFilters(): array
    {
        return [];
    }
}
