<?php

declare(strict_types = 1);

use App\Enums\SortDirection;
use App\Traits\Components\WithTable;
use Livewire\Component;

it('applies and resets draft filters without changing search or sorting', function (): void {
    $component = new class () {
        use WithTable;

        public int $resets = 0;

        public function resetPage(string $pageName = 'page'): void
        {
            $this->resets++;
        }

        public function emptyFilters(): array
        {
            return ['status' => 'all'];
        }
    };
    $component->search = 'retained';
    $component->sortBy('name');
    $component->resetFilters();
    $component->filterDraft = ['status' => 'active'];

    expect($component->filters)->toBe(['status' => 'all']);

    $component->applyFilters();
    expect($component->filters)->toBe(['status' => 'active'])->and($component->resets)->toBe(2);
    $component->resetFilters();
    expect($component->filters)->toBe(['status' => 'all'])
        ->and($component->filterDraft)->toBe(['status' => 'all'])
        ->and($component->search)->toBe('retained')->and($component->sortKeyName)->toBe('name');
});

it('provides empty defaults for tables without custom filters', function (): void {
    $component = new class () {
        use WithTable;

        public function resetPage(string $pageName = 'page'): void
        {
        }
    };
    $component->filters     = ['old' => true];
    $component->filterDraft = ['draft' => true];
    $component->resetFilters();

    expect($component->filters)->toBeEmpty()->and($component->filterDraft)->toBeEmpty();
});

it('sorts by new key and toggles direction when key repeats', function (): void {
    $component = new class () {
        use WithTable;

        public function resetPage(string $pageName = 'page'): void
        {
        }
    };

    $component->sortBy('name');
    expect($component->sortKeyName)->toBe('name')
        ->and($component->sortDirection)->toBe(SortDirection::Asc->value);

    $component->sortBy('name');
    expect($component->sortDirection)->toBe(SortDirection::Desc->value);

    $component->sortBy('name');
    expect($component->sortDirection)->toBe(SortDirection::Asc->value);
});

it('resets pagination when search is updated', function (): void {
    $component = new class () {
        use WithTable;

        public int $resetCounter = 0;

        public function resetPage(string $pageName = 'page'): void
        {
            $this->resetCounter++;
        }
    };

    $component->updatedSearch();

    expect($component->resetCounter)->toBe(1);
});

it('normalizes page sizes against the server allowlist and resets pagination', function (mixed $input, int $expected): void {
    $component = new class () {
        use WithTable;

        public int $resets = 0;

        public function resetPage(string $pageName = 'page'): void
        {
            $this->resets++;
        }
    };
    $component->perPage       = $input;
    $component->perPageValues = [0, 1000000];
    $component->updatedPerPage();

    expect($component->perPage)->toBe($expected);
    expect($component->resets)->toBe(1);
})->with([
    'ten'               => [10, 10],
    'twenty five'       => [25, 25],
    'fifty'             => [50, 50],
    'select string'     => ['25', 25],
    'fifty string'      => ['50', 50],
    'ten string'        => ['10', 10],
    'zero'              => [0, 10],
    'negative'          => [-1, 10],
    'huge'              => [PHP_INT_MAX, 10],
    'huge string'       => ['999999999999999999999999', 10],
    'unsupported'       => [15, 10],
    'array'             => [[25], 10],
    'null'              => [null, 10],
    'boolean'           => [true, 10],
    'float'             => [25.0, 10],
    'decimal string'    => ['25.0', 10],
    'scientific string' => ['2.5e1', 10],
    'invalid string'    => ['all', 10],
]);

it('validates applied filters without validating or clearing unrelated form fields', function (): void {
    $component = new class () extends Component {
        use WithTable;

        protected function rules(): array
        {
            return [
                'filterDraft'        => ['required', 'array:status'],
                'filterDraft.status' => ['required', 'in:active'],
                'title'              => ['required'],
            ];
        }

        public function checkFilters(): bool
        {
            return $this->appliedFiltersAreValid();
        }
    };
    $component->filters     = ['status' => 'invalid'];
    $component->filterDraft = ['status' => 'draft'];
    $component->addError('title', 'Preserved error');

    expect($component->checkFilters())->toBeFalse();
    $component->filters = ['status' => 'active'];
    expect($component->checkFilters())->toBeTrue();
    expect($component->getErrorBag()->has('filters'))->toBeFalse();
    expect($component->getErrorBag()->first('title'))->toBe('Preserved error');
    expect($component->filterDraft)->toBe(['status' => 'draft']);
});
