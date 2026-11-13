<?php

declare(strict_types = 1);

use App\Enums\CommandExecutionStatuses;
use App\Enums\TypeUsers;
use App\Jobs\ExecuteArtisanCommandJob;
use App\Livewire\Support\ArtisanCommands\Index;
use App\Models\CommandExecution;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Queue;

use function Pest\Livewire\livewire;

use Symfony\Component\HttpKernel\Exception\HttpException;

it('allows only support users to access the page', function (): void {
    actingAsUser();

    livewire(Index::class)
        ->assertForbidden();

    actingAsSupport();

    livewire(Index::class)
        ->assertOk();
});

it('queues a command and persists queued execution log', function (): void {
    actingAsSupport();

    Queue::fake();

    livewire(Index::class)
        ->call('executeCommand', 'php artisan about')
        ->assertHasNoErrors()
        ->assertDispatched('artisan-commands-clear-input');

    expect(CommandExecution::query()->count())->toBe(1)
        ->and(CommandExecution::query()->first()?->status)->toBe(CommandExecutionStatuses::Queued);

    Queue::assertPushed(ExecuteArtisanCommandJob::class);
});

it('rejects sensitive input before recording or dispatching it', function (): void {
    actingAsSupport();
    Queue::fake();

    livewire(Index::class)->call('executeCommand', 'about --password=canary')->assertHasErrors('commandInput');

    $this->assertDatabaseCount('command_executions', 0);
    Queue::assertNothingPushed();
});

it('asks for a command before recording or dispatching it', function (): void {
    actingAsSupport();
    Queue::fake();

    livewire(Index::class)->call('executeCommand', '   ')->assertHasErrors('commandInput')->assertSee('Informe um comando artisan válido.');

    $this->assertDatabaseCount('command_executions', 0);
    Queue::assertNothingPushed();
});

it('filters suggestions through the active policy', function (): void {
    actingAsSupport();

    livewire(Index::class)->assertSet('artisanCommands', ['about', 'about --only=environment']);

    config()->set('artisan-executor.commands_by_environment', []);
    livewire(Index::class)->assertSet('artisanCommands', []);
});

it('reauthorizes execution after permission is revoked', function (): void {
    $user      = actingAsSupport();
    $component = livewire(Index::class);
    $user->update(['type' => TypeUsers::Customer]);
    Queue::fake();

    $component->call('executeCommand', 'about')->assertForbidden();

    $this->assertDatabaseCount('command_executions', 0);
    Queue::assertNothingPushed();
});

it('forbids execution when no authenticated user remains', function (): void {
    Gate::before(fn (?User $user): bool => true);

    expect(fn () => new Index()->executeCommand('about'))->toThrow(HttpException::class);
});
