<?php

declare(strict_types = 1);

namespace App\Livewire\Support\ArtisanCommands;

use App\Enums\CommandExecutionStatuses;
use App\Enums\SortDirection;
use App\Jobs\ExecuteArtisanCommandJob;
use App\Models\CommandExecution;
use App\Models\User;
use App\Support\ArtisanCommandPolicy;
use App\Traits\Components\WithModal;
use App\Traits\Components\WithTable;
use App\Traits\Components\WithToast;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

class History extends Component
{
    use WithModal;
    use WithTable {
        applyFilters as private applyTableFilters;
        resetFilters as private resetTableFilters;
    }
    use WithToast;

    /** @var array<string, mixed> */
    #[Locked]
    public array $filters = [];

    public ?int $selectedExecutionId = null;

    public function mount(): void
    {
        $this->authorize('viewAny', CommandExecution::class);

        $this->sortKeyName = 'executed_at';
        $this->initializeFilters();
    }

    #[On('artisan-commands::refresh-history')]
    public function refreshHistory(): void
    {
    }

    public function render(): View
    {
        return view('livewire.support.artisan-commands.history');
    }

    /** @return array<string, mixed> */
    public function emptyFilters(): array
    {
        return [
            'status' => '',
        ];
    }

    public function resetFilters(): void
    {
        $this->authorize('viewAny', CommandExecution::class);
        $this->resetTableFilters();
        $this->resetValidation();
    }

    public function applyFilters(): bool
    {
        $this->authorize('viewAny', CommandExecution::class);
        $this->validate();

        return $this->applyTableFilters();
    }

    /** @return array<string, mixed> */
    protected function rules(): array
    {
        return [
            'filterDraft'        => ['required', 'array:status'],
            'filterDraft.status' => ['present', 'nullable', 'integer', Rule::enum(CommandExecutionStatuses::class)],
        ];
    }

    public function reExecute(ArtisanCommandPolicy $commandPolicy, int $commandExecutionId): void
    {
        $this->authorize('create', CommandExecution::class);

        $authenticatedUser = user();

        if (!$authenticatedUser instanceof User) {
            abort(403);
        }

        $commandExecution = CommandExecution::query()->findOrFail($commandExecutionId);

        $this->authorize('view', $commandExecution);
        $prepared = $commandPolicy->prepare($commandExecution->command);

        $queuedExecution = CommandExecution::query()->create([
            'user_id'           => $authenticatedUser->id,
            'user_name'         => $authenticatedUser->name,
            'ip_address'        => request()->ip(),
            'command'           => $prepared['command'],
            'command_name'      => $prepared['name'],
            'command_arguments' => $prepared['arguments'],
            'status'            => CommandExecutionStatuses::Queued,
            'exit_code'         => null,
            'output'            => null,
            'duration_ms'       => 0,
            'executed_at'       => now(),
        ]);

        ExecuteArtisanCommandJob::dispatch(commandExecutionId: $queuedExecution->id);

        $this->toast('Reexecução enviada para a fila.');
    }

    public function openOutput(int $commandExecutionId): void
    {
        $commandExecution = CommandExecution::query()->findOrFail($commandExecutionId);

        $this->authorize('view', $commandExecution);

        $this->selectedExecutionId = $commandExecution->id;
        $this->openModal();
    }

    /** @return LengthAwarePaginator<int, CommandExecution> */
    #[Computed]
    public function commandExecutions(): LengthAwarePaginator
    {
        $this->authorize('viewAny', CommandExecution::class);

        if (!$this->appliedFiltersAreValid()) {
            return new LengthAwarePaginator([], 0, $this->normalizedPerPage(), $this->normalizedPage());
        }

        /** @var array{status: int|numeric-string|null} $filters */
        $filters = $this->filters;

        return CommandExecution::query()
            ->with('user')
            ->when(($filters['status'] ?? '') !== '', fn (Builder $query) => $query->where('status', (int) $filters['status']))
            ->when($this->search !== '', function (Builder $query): void {
                $search = $this->search;

                $query->where(function (Builder $subQuery) use ($search): void {
                    $subQuery->whereInsensitive('command', $search)
                        ->orWhereInsensitive('user_name', $search)
                        ->orWhereInsensitive('ip_address', $search);
                });
            })
            ->orderBy($this->sortKeyName, SortDirection::from($this->sortDirection)->value)
            ->paginate($this->normalizedPerPage());
    }

    #[Computed]
    public function selectedExecution(): ?CommandExecution
    {
        $this->authorize('viewAny', CommandExecution::class);

        if ($this->selectedExecutionId === null) {
            return null;
        }

        return CommandExecution::query()->find($this->selectedExecutionId);
    }

    /** @return array<int|string, string> */
    #[Computed]
    public function statuses(): array
    {
        return CommandExecutionStatuses::options();
    }
}
