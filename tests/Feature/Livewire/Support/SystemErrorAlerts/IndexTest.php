<?php

declare(strict_types = 1);

use App\Enums\SystemErrorAlertSeverities;
use App\Enums\SystemErrorAlertStatuses;
use App\Enums\TypeUsers;
use App\Livewire\Support\SystemErrorAlerts\Index;
use App\Models\SystemErrorAlert;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Features\SupportLockedProperties\CannotUpdateLockedPropertyException;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

use function Pest\Livewire\livewire;

beforeEach(function (): void {
    /** @var User $supportUser */
    $supportUser = User::factory()->create([
        'type' => TypeUsers::SupportRemSoft,
    ]);

    actingAs($supportUser);
});

it('can access index with permission', function (): void {
    livewire(Index::class)
        ->assertOk();
});

it('forbids access when user type is not support rem soft', function (): void {
    actingAs(User::factory()->admin()->create());

    livewire(Index::class)
        ->assertForbidden();
});

it('filters alerts by status and severity', function (): void {
    SystemErrorAlert::factory()->create([
        'status'   => SystemErrorAlertStatuses::Open,
        'severity' => SystemErrorAlertSeverities::Critical,
    ]);

    SystemErrorAlert::factory()->create([
        'status'   => SystemErrorAlertStatuses::Resolved,
        'severity' => SystemErrorAlertSeverities::Emergency,
    ]);

    livewire(Index::class)
        ->set('filterDraft.status', (string) SystemErrorAlertStatuses::Resolved->value)
        ->set('filterDraft.severity', (string) SystemErrorAlertSeverities::Emergency->value)
        ->call('applyFilters')
        ->assertSet('alerts', function (LengthAwarePaginator $paginator): bool {
            expect($paginator->total())->toBe(1)
                ->and($paginator->items()[0]->status)->toBe(SystemErrorAlertStatuses::Resolved)
                ->and($paginator->items()[0]->severity)->toBe(SystemErrorAlertSeverities::Emergency);

            return true;
        });
});

it('distinguishes no alerts from a search without results', function (): void {
    livewire(Index::class)
        ->assertSee('Nenhum alerta registrado')
        ->assertDontSee('Nenhum alerta encontrado')
        ->set('search', 'Exceção inexistente')
        ->assertSee('Nenhum alerta encontrado')
        ->assertSee('Tente ajustar a busca ou os filtros aplicados.')
        ->assertSee('Limpar busca');
});

it('renders the results empty state when filters match no alerts', function (): void {
    livewire(Index::class)
        ->set('filterDraft.status', (string) SystemErrorAlertStatuses::Resolved->value)
        ->call('applyFilters')
        ->assertSee('Nenhum alerta encontrado')
        ->assertDontSee('Nenhum alerta registrado')
        ->assertDontSee('Limpar busca');
});

it('resets alert filters to their defaults', function (): void {
    livewire(Index::class)
        ->set('filterDraft.status', (string) SystemErrorAlertStatuses::Resolved->value)
        ->call('applyFilters')
        ->call('resetFilters')
        ->assertSet('filters', ['status' => '', 'severity' => '', 'environment' => '']);
});

it('uses the selected environment and search after subsequent requests', function (): void {
    $matching = SystemErrorAlert::factory()->create(['environment' => 'qa', 'message' => 'connection unavailable']);
    SystemErrorAlert::factory()->create(['environment' => 'production', 'message' => 'connection unavailable']);

    livewire(Index::class)
        ->set('filterDraft.environment', 'qa')
        ->call('applyFilters')
        ->set('search', 'connection unavailable')
        ->assertSet('alerts', fn (LengthAwarePaginator $alerts): bool => $alerts->total() === 1 && $alerts->items()[0]->is($matching))
        ->assertSet('environmentOptions', ['production' => 'production', 'qa' => 'qa']);
});

it('keeps drafts separate and preserves applied filters during sorting and pagination', function (): void {
    actingAsSupport();
    $component = livewire(Index::class)
        ->assertSet('filterDraft', ['status' => '', 'severity' => '', 'environment' => ''])
        ->set('search', 'retained')
        ->set('filterDraft.status', (string) SystemErrorAlertStatuses::Resolved->value)
        ->assertSet('filters', ['status' => '', 'severity' => '', 'environment' => ''])
        ->call('applyFilters')
        ->assertHasNoErrors()
        ->assertSet('paginators.page', 1)
        ->call('sortBy', 'status')
        ->call('setPage', 2)
        ->assertSet('filters.status', (string) SystemErrorAlertStatuses::Resolved->value)
        ->assertSet('paginators.page', 2)
        ->set('filterDraft.status', '')
        ->assertSet('filters.status', (string) SystemErrorAlertStatuses::Resolved->value)
        ->call('resetFilters')
        ->assertSet('filters', ['status' => '', 'severity' => '', 'environment' => ''])
        ->assertSet('filterDraft', ['status' => '', 'severity' => '', 'environment' => ''])
        ->assertSet('paginators.page', 1)
        ->assertSet('search', 'retained')
        ->assertSet('sortKeyName', 'status');
});

it('rejects invalid drafts without replacing applied filters or pagination', function (array $draft, string $error): void {
    actingAsSupport();
    livewire(Index::class)
        ->call('setPage', 2)
        ->set('filterDraft', $draft)
        ->call('applyFilters')
        ->assertHasErrors($error)
        ->assertSet('filters', ['status' => '', 'severity' => '', 'environment' => ''])
        ->assertSet('paginators.page', 2)
        ->call('resetFilters')
        ->assertHasNoErrors();
})->with([
    [['status' => 'invalid', 'severity' => '', 'environment' => ''], 'filterDraft.status'],
    [['status' => '', 'severity' => 'invalid', 'environment' => ''], 'filterDraft.severity'],
    [['status' => '', 'severity' => '', 'environment' => []], 'filterDraft.environment'],
    [['status' => '', 'severity' => '', 'environment' => '', 'unexpected' => true], 'filterDraft'],
    [['status' => ''], 'filterDraft.severity'],
]);

it('prevents direct updates to applied filters', function (): void {
    actingAsSupport();
    expect(fn () => livewire(Index::class)->set('filters.status', '1'))
        ->toThrow(CannotUpdateLockedPropertyException::class);
});

it('reauthorizes filter actions', function (string $action): void {
    $user      = actingAsSupport();
    $component = livewire(Index::class);
    $user->update(['type' => TypeUsers::Customer]);
    $component->call($action)->assertForbidden();
})->with(['applyFilters', 'resetFilters']);

it('bounds page size at the query and resets the page when the size changes', function (): void {
    SystemErrorAlert::factory()->count(26)->create();
    $component = livewire(Index::class)
        ->assertSet('perPage', 10)
        ->call('setPage', 2)
        ->set('perPage', '25')
        ->assertSet('perPage', 25)
        ->assertSet('paginators.page', 1)
        ->assertSet('alerts', fn (LengthAwarePaginator $records): bool => $records->perPage() === 25 && $records->count() === 25)
        ->call('nextPage')
        ->assertSet('alerts', fn (LengthAwarePaginator $records): bool => $records->currentPage() === 2 && $records->count() === 1)
        ->set('perPage', 0)
        ->assertSet('perPage', 10)
        ->assertSet('paginators.page', 1);

    $instance          = $component->instance();
    $instance->perPage = 1000000;
    unset($instance->alerts);
    expect($instance->alerts->perPage())->toBe(10);
    expect($instance->alerts->count())->toBe(10);
});

it('does not query records when the applied state is invalid', function (array $applied): void {

    $instance              = livewire(Index::class)->instance();
    $instance->filterDraft = ['status' => '', 'severity' => '', 'environment' => ''];
    $instance->search      = 'retained';
    $instance->filters     = $applied;
    $instance->addError('unrelated', 'Retained validation error');
    unset($instance->alerts);
    DB::enableQueryLog();
    DB::flushQueryLog();

    try {
        $records = $instance->alerts;
        expect(DB::getQueryLog())->toBeEmpty();
        expect($records->total())->toBe(0);
        expect($records->perPage())->toBe(10);
        expect($instance->getErrorBag()->first('filters'))->toBe('Os filtros aplicados são inválidos. Limpe ou aplique filtros válidos para continuar.');
        expect($instance->getErrorBag()->first('unrelated'))->toBe('Retained validation error');
        expect($instance->filterDraft)->toBe(['status' => '', 'severity' => '', 'environment' => '']);
        expect($instance->filters)->toBe($applied);
        expect($instance->search)->toBe('retained');
    } finally {
        DB::disableQueryLog();
    }
})->with([
    'invalid status'    => [['status' => 'invalid', 'severity' => '', 'environment' => '']],
    'array status'      => [['status' => [], 'severity' => '', 'environment' => '']],
    'invalid severity'  => [['status' => '', 'severity' => 99, 'environment' => '']],
    'array environment' => [['status' => '', 'severity' => '', 'environment' => []]],
    'missing keys'      => [[]],
    'unexpected key'    => [['status' => '', 'severity' => '', 'environment' => '', 'extra' => true]],
]);

it('renders invalid applied filters safely and recovers after clearing them', function (): void {

    $component = livewire(Index::class)->set('search', 'retained');
    $stop      = Livewire::listen('hydrate', function (Component $instance): void {
        if ($instance instanceof Index) {
            $instance->filters = [];
        }
    });

    try {
        $component->call('$refresh')->assertOk()->assertHasErrors('filters')
            ->assertSee('Consulta não executada')->assertSee('Os filtros aplicados são inválidos.')
            ->assertSet('filterDraft', ['status' => '', 'severity' => '', 'environment' => ''])->assertSet('search', 'retained');
    } finally {
        $stop();
    }

    $component->call('resetFilters')->assertOk()->assertHasNoErrors('filters')
        ->assertSet('filters', ['status' => '', 'severity' => '', 'environment' => ''])->assertSet('search', 'retained');
});

it('treats null optional filters as absent without changing the draft', function (): void {

    livewire(Index::class)->set('filterDraft', ['status' => null, 'severity' => null, 'environment' => null])->call('applyFilters')
        ->assertSee('Nenhum alerta registrado');

    SystemErrorAlert::factory()->count(2)->create();
    livewire(Index::class)->set('filterDraft', ['status' => null, 'severity' => null, 'environment' => null])->call('applyFilters')
        ->assertHasNoErrors()->assertSet('filterDraft', ['status' => null, 'severity' => null, 'environment' => null])
        ->assertSet('alerts', fn (LengthAwarePaginator $records): bool => $records->total() === 2);
});
