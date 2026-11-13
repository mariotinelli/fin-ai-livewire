<?php

declare(strict_types = 1);

namespace App\Livewire\Support\ArtisanCommands;

use App\Enums\CommandExecutionStatuses;
use App\Jobs\ExecuteArtisanCommandJob;
use App\Models\CommandExecution;
use App\Models\User;
use App\Support\ArtisanCommandPolicy;
use App\Traits\Components\WithToast;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Index extends Component
{
    use WithToast;

    protected ArtisanCommandPolicy $commandPolicy;

    public function boot(ArtisanCommandPolicy $commandPolicy): void
    {
        $this->commandPolicy = $commandPolicy;
    }

    public function mount(): void
    {
        $this->authorize('viewAny', CommandExecution::class);
    }

    public function render(): View
    {
        return view('livewire.support.artisan-commands.index');
    }

    public function executeCommand(string $command): void
    {
        $this->authorize('create', CommandExecution::class);

        $authenticatedUser = user();

        if (!$authenticatedUser instanceof User) {
            abort(403);
        }

        if (trim($command) === '') {
            $this->addError('commandInput', 'Informe um comando artisan válido.');

            return;
        }

        $prepared = $this->commandPolicy->prepare($command);

        $commandExecution = CommandExecution::query()->create([
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

        ExecuteArtisanCommandJob::dispatch(commandExecutionId: $commandExecution->id);

        $this->dispatch('artisan-commands::refresh-history');
        $this->dispatch('artisan-commands-clear-input');

        $this->toast('Comando enviado para a fila de execução.');
    }

    /** @return list<string> */
    #[Computed]
    public function artisanCommands(): array
    {
        return $this->commandPolicy->suggestions();
    }

    /** @return list<array<string, string>> */
    #[Computed]
    public function breadcrumb(): array
    {
        return [
            ['label' => 'Suporte'],
            ['label' => 'Comandos'],
        ];
    }
}
