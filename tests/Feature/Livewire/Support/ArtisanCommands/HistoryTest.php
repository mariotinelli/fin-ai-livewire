<?php

declare(strict_types = 1);

use App\Enums\CommandExecutionStatuses;
use App\Enums\TypeUsers;
use App\Jobs\ExecuteArtisanCommandJob;
use App\Livewire\Support\ArtisanCommands\History;
use App\Models\CommandExecution;
use App\Models\User;
use App\Support\ArtisanCommandPolicy;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Queue;

use Livewire\Component;

use Livewire\Features\SupportLockedProperties\CannotUpdateLockedPropertyException;

use Livewire\Livewire;

use function Pest\Livewire\livewire;

use Symfony\Component\HttpKernel\Exception\HttpException;

it('searches commands and operators without accents or case while preserving the status filter', function (string $field, string $search): void {
    actingAsSupport();
    $attributes = ['status' => CommandExecutionStatuses::Error, 'command' => 'php artisan about', 'user_name' => 'Other operator', $field => 'João da Conceição'];
    $matching   = CommandExecution::factory()->create($attributes);
    CommandExecution::factory()->create([...$attributes, 'status' => CommandExecutionStatuses::Success]);
    CommandExecution::factory()->create([...$attributes, $field => 'Another operation']);

    $component = livewire(History::class)
        ->set('filterDraft.status', (string) CommandExecutionStatuses::Error->value)->call('applyFilters')
        ->set('search', $search);

    expect($component->get('commandExecutions')->getCollection()->modelKeys())->toBe([$matching->id]);
})->with(['command', 'user_name'])->with(['joao', 'JOÃO', 'CONCEICAO']);

it('searches zero and pattern characters literally', function (string $search, string $otherName): void {
    actingAsSupport();
    $matching = CommandExecution::factory()->create(['user_name' => 'Operator ' . $search, 'ip_address' => '192.168.1.1']);
    CommandExecution::factory()->create(['user_name' => $otherName, 'command' => 'php artisan about', 'ip_address' => '192.168.1.1']);

    $component = livewire(History::class)->set('search', $search);
    expect($component->get('commandExecutions')->getCollection()->modelKeys())->toBe([$matching->id]);
})->with([['0', 'Other operator'], ['100%_done!', 'Operator 100XXdone!']]);

it('filters command history by status', function (): void {
    actingAsSupport();

    CommandExecution::factory()->create([
        'status' => CommandExecutionStatuses::Success,
    ]);

    CommandExecution::factory()->create([
        'status' => CommandExecutionStatuses::Error,
    ]);

    livewire(History::class)
        ->set('filterDraft.status', (string) CommandExecutionStatuses::Error->value)
        ->call('applyFilters')
        ->assertSet('commandExecutions', function (LengthAwarePaginator $paginator): bool {
            expect($paginator->total())->toBe(1)
                ->and($paginator->items()[0]->status)->toBe(CommandExecutionStatuses::Error);

            return true;
        });
});

it('distinguishes an empty history from a search without results', function (): void {
    actingAsSupport();

    livewire(History::class)
        ->assertSee('Nenhum comando executado')
        ->assertDontSee('Nenhuma execução encontrada')
        ->set('search', 'comando inexistente')
        ->assertSee('Nenhuma execução encontrada')
        ->assertSee('Tente ajustar a busca ou os filtros aplicados.')
        ->assertSee('Limpar busca');
});

it('renders the results empty state when filters match no executions', function (): void {
    actingAsSupport();

    livewire(History::class)
        ->set('filterDraft.status', (string) CommandExecutionStatuses::Error->value)
        ->call('applyFilters')
        ->assertSee('Nenhuma execução encontrada')
        ->assertDontSee('Nenhum comando executado')
        ->assertDontSee('Limpar busca');
});

it('reexecutes only commands permitted by the current policy', function (): void {
    actingAsSupport();
    $execution = CommandExecution::factory()->create(['command' => 'php artisan about']);
    Queue::fake();

    livewire(History::class)->call('reExecute', $execution->id)->assertHasNoErrors();

    $this->assertDatabaseCount('command_executions', 2);
    Queue::assertPushed(ExecuteArtisanCommandJob::class, 1);
});

it('rejects a historical command after its policy is removed', function (): void {
    actingAsSupport();
    $execution = CommandExecution::factory()->create(['command' => 'php artisan about']);
    Queue::fake();
    config()->set('artisan-executor.commands_by_environment', []);

    livewire(History::class)->call('reExecute', $execution->id)->assertHasErrors('commandInput');

    $this->assertDatabaseCount('command_executions', 1);
    Queue::assertNothingPushed();
});

it('reauthorizes history actions after permission is revoked', function (string $action): void {
    $user      = actingAsSupport();
    $execution = CommandExecution::factory()->create(['command' => 'php artisan about']);
    $component = livewire(History::class);
    $user->update(['type' => TypeUsers::Customer]);
    Queue::fake();

    $component->call($action, $execution->id)->assertForbidden();

    $this->assertDatabaseCount('command_executions', 1);
    Queue::assertNothingPushed();
})->with(['reExecute', 'openOutput']);

it('does not expose legacy secrets in the table or output modal', function (): void {
    actingAsSupport();
    $execution = CommandExecution::factory()->create();
    DB::table('command_executions')->where('id', $execution->id)->update([
        'command' => 'example --token canary', 'output' => 'password=canary',
    ]);

    livewire(History::class)->assertDontSee('canary')->call('openOutput', $execution->id)->assertDontSee('canary')->assertSee('[REDACTED]');
});

it('refreshes computed history and resets filters', function (): void {
    actingAsSupport();

    livewire(History::class)
        ->set('filterDraft.status', (string) CommandExecutionStatuses::Error->value)
        ->call('applyFilters')
        ->call('refreshHistory')
        ->call('resetFilters')
        ->assertSet('filters', ['status' => '']);
});

it('forbids history re-execution when no authenticated user remains', function (): void {
    Gate::before(fn (?User $user): bool => true);

    expect(fn () => new History()->reExecute(app(ArtisanCommandPolicy::class), 1))->toThrow(HttpException::class);
});

it('keeps drafts separate and preserves applied filters during sorting and pagination', function (): void {
    actingAsSupport();
    $component = livewire(History::class)
        ->assertSet('filterDraft', ['status' => ''])
        ->set('search', 'retained')
        ->set('filterDraft.status', (string) CommandExecutionStatuses::Error->value)
        ->assertSet('filters', ['status' => ''])
        ->call('applyFilters')
        ->assertHasNoErrors()
        ->assertSet('paginators.page', 1)
        ->call('sortBy', 'status')
        ->call('setPage', 2)
        ->assertSet('filters.status', (string) CommandExecutionStatuses::Error->value)
        ->assertSet('paginators.page', 2)
        ->set('filterDraft.status', '')
        ->assertSet('filters.status', (string) CommandExecutionStatuses::Error->value)
        ->call('resetFilters')
        ->assertSet('filters', ['status' => ''])
        ->assertSet('filterDraft', ['status' => ''])
        ->assertSet('paginators.page', 1)
        ->assertSet('search', 'retained')
        ->assertSet('sortKeyName', 'status');
});

it('rejects invalid drafts without replacing applied filters or pagination', function (array $draft, string $error): void {
    actingAsSupport();
    livewire(History::class)
        ->call('setPage', 2)
        ->set('filterDraft', $draft)
        ->call('applyFilters')
        ->assertHasErrors($error)
        ->assertSet('filters', ['status' => ''])
        ->assertSet('paginators.page', 2)
        ->call('resetFilters')
        ->assertHasNoErrors();
})->with([
    [['status' => 'invalid'], 'filterDraft.status'],
    [['status' => '', 'unexpected' => true], 'filterDraft'],
    [[], 'filterDraft.status'],
]);

it('prevents direct updates to applied filters', function (): void {
    actingAsSupport();
    expect(fn () => livewire(History::class)->set('filters.status', '1'))
        ->toThrow(CannotUpdateLockedPropertyException::class);
});

it('reauthorizes filter actions', function (string $action): void {
    $user      = actingAsSupport();
    $component = livewire(History::class);
    $user->update(['type' => TypeUsers::Customer]);
    $component->call($action)->assertForbidden();
})->with(['applyFilters', 'resetFilters']);

it('bounds page size at the query and resets the page when the size changes', function (): void {
    actingAsSupport();
    CommandExecution::factory()->count(26)->create();
    $component = livewire(History::class)
        ->assertSet('perPage', 10)
        ->call('setPage', 2)
        ->set('perPage', '25')
        ->assertSet('perPage', 25)
        ->assertSet('paginators.page', 1)
        ->assertSet('commandExecutions', fn (LengthAwarePaginator $records): bool => $records->perPage() === 25 && $records->count() === 25)
        ->call('nextPage')
        ->assertSet('commandExecutions', fn (LengthAwarePaginator $records): bool => $records->currentPage() === 2 && $records->count() === 1)
        ->set('perPage', 0)
        ->assertSet('perPage', 10)
        ->assertSet('paginators.page', 1);

    $instance          = $component->instance();
    $instance->perPage = 1000000;
    unset($instance->commandExecutions);
    expect($instance->commandExecutions->perPage())->toBe(10);
    expect($instance->commandExecutions->count())->toBe(10);
});

it('does not query records when the applied state is invalid', function (array $applied): void {
    actingAsSupport();
    $instance              = livewire(History::class)->instance();
    $instance->filterDraft = ['status' => ''];
    $instance->search      = 'retained';
    $instance->filters     = $applied;
    $instance->addError('unrelated', 'Retained validation error');
    unset($instance->commandExecutions);
    DB::enableQueryLog();
    DB::flushQueryLog();

    try {
        $records = $instance->commandExecutions;
        expect(DB::getQueryLog())->toBeEmpty();
        expect($records->total())->toBe(0);
        expect($records->perPage())->toBe(10);
        expect($instance->getErrorBag()->first('filters'))->toBe('Os filtros aplicados são inválidos. Limpe ou aplique filtros válidos para continuar.');
        expect($instance->getErrorBag()->first('unrelated'))->toBe('Retained validation error');
        expect($instance->filterDraft)->toBe(['status' => '']);
        expect($instance->filters)->toBe($applied);
        expect($instance->search)->toBe('retained');
    } finally {
        DB::disableQueryLog();
    }
})->with([
    'invalid status' => [['status' => 'invalid']],
    'unknown status' => [['status' => 99]],
    'array status'   => [['status' => []]],
    'missing key'    => [[]],
    'unexpected key' => [['status' => '', 'extra' => true]],
]);

it('renders invalid applied filters safely and recovers after clearing them', function (): void {
    actingAsSupport();
    $component = livewire(History::class)->set('search', 'retained');
    $stop      = Livewire::listen('hydrate', function (Component $instance): void {
        if ($instance instanceof History) {
            $instance->filters = [];
        }
    });

    try {
        $component->call('$refresh')->assertOk()->assertHasErrors('filters')
            ->assertSee('Consulta não executada')->assertSee('Os filtros aplicados são inválidos.')
            ->assertSet('filterDraft', ['status' => ''])->assertSet('search', 'retained');
    } finally {
        $stop();
    }

    $component->call('resetFilters')->assertOk()->assertHasNoErrors('filters')
        ->assertSet('filters', ['status' => ''])->assertSet('search', 'retained');
});

it('treats null optional filters as absent without changing the draft', function (): void {
    actingAsSupport();
    livewire(History::class)->set('filterDraft', ['status' => null])->call('applyFilters')
        ->assertSee('Nenhum comando executado');

    CommandExecution::factory()->count(2)->create();
    livewire(History::class)->set('filterDraft', ['status' => null])->call('applyFilters')
        ->assertHasNoErrors()->assertSet('filterDraft', ['status' => null])
        ->assertSet('commandExecutions', fn (LengthAwarePaginator $records): bool => $records->total() === 2);
});
