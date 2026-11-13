<?php

declare(strict_types = 1);

namespace App\Livewire\Support\SystemErrorAlerts;

use App\Enums\SystemErrorAlertSeverities;
use App\Enums\SystemErrorAlertStatuses;
use App\Models\SystemErrorAlert;
use App\Queries\SystemErrorAlertsQuery;
use App\Traits\Components\WithTable;
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

    protected SystemErrorAlertsQuery $alertsQuery;

    public function boot(SystemErrorAlertsQuery $alertsQuery): void
    {
        $this->alertsQuery = $alertsQuery;
    }

    public function mount(): void
    {
        $this->authorize('viewAny', SystemErrorAlert::class);

        $this->sortKeyName = 'last_seen_at';
        $this->initializeFilters();
    }

    #[On('system-error-alerts::refresh')]
    public function render(): View
    {
        return view('livewire.support.system-error-alerts.index');
    }

    /** @return array<string, mixed> */
    public function emptyFilters(): array
    {
        return [
            'status'      => '',
            'severity'    => '',
            'environment' => '',
        ];
    }

    public function resetFilters(): void
    {
        $this->authorize('viewAny', SystemErrorAlert::class);
        $this->resetTableFilters();
        $this->resetValidation();
    }

    public function applyFilters(): bool
    {
        $this->authorize('viewAny', SystemErrorAlert::class);
        $this->validate();

        return $this->applyTableFilters();
    }

    /** @return array<string, mixed> */
    protected function rules(): array
    {
        return [
            'filterDraft'             => ['required', 'array:status,severity,environment'],
            'filterDraft.status'      => ['present', 'nullable', 'integer', Rule::enum(SystemErrorAlertStatuses::class)],
            'filterDraft.severity'    => ['present', 'nullable', 'integer', Rule::enum(SystemErrorAlertSeverities::class)],
            'filterDraft.environment' => ['present', 'nullable', 'string', 'max:255'],
        ];
    }

    /** @return LengthAwarePaginator<int, SystemErrorAlert> */
    #[Computed]
    public function alerts(): LengthAwarePaginator
    {
        if (!$this->appliedFiltersAreValid()) {
            return new LengthAwarePaginator([], 0, $this->normalizedPerPage(), $this->normalizedPage());
        }

        /** @var array{status: int|numeric-string|null, severity: int|numeric-string|null, environment: string|null} $filters */
        $filters = $this->filters;

        return $this->alertsQuery->paginate(
            search: $this->search,
            status: ($filters['status'] ?? '') === '' ? null : (int) $filters['status'],
            severity: ($filters['severity'] ?? '') === '' ? null : (int) $filters['severity'],
            environment: ($filters['environment'] ?? '') === '' ? null : $filters['environment'],
            sortBy: $this->sortKeyName,
            sortDirection: $this->sortDirection,
            perPage: $this->normalizedPerPage(),
        );
    }

    /** @return list<array<string, string>> */
    #[Computed]
    public function breadcrumb(): array
    {
        return [
            ['label' => 'Suporte'],
            ['label' => 'Alertas de Erro'],
        ];
    }

    /** @return array<int|string, string> */
    #[Computed]
    public function environmentOptions(): array
    {
        return $this->alertsQuery->environments();
    }

    /** @return array<int|string, string> */
    #[Computed]
    public function statuses(): array
    {
        return SystemErrorAlertStatuses::options();
    }

    /** @return array<int|string, string> */
    #[Computed]
    public function severities(): array
    {
        return SystemErrorAlertSeverities::options();
    }
}
