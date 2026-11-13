<?php

declare(strict_types = 1);

namespace App\Jobs;

use App\Enums\CommandExecutionStatuses;
use App\Enums\Queues;
use App\Models\CommandExecution;
use App\Support\ArtisanCommandPolicy;
use App\Support\ArtisanHistoryRedactor;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\Attributes\Backoff;
use Illuminate\Queue\Attributes\FailOnTimeout;
use Illuminate\Queue\Attributes\Queue;
use Illuminate\Queue\Attributes\Timeout;
use Illuminate\Queue\Attributes\Tries;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Process;
use Illuminate\Validation\ValidationException;
use LengthException;
use Symfony\Component\Process\PhpExecutableFinder;
use Throwable;

#[Queue(Queues::LongTimeout)]
#[Timeout(150)]
#[FailOnTimeout]
#[Tries(1)]
#[Backoff([10])]
class ExecuteArtisanCommandJob implements ShouldQueue
{
    use Queueable;

    public function __construct(public int $commandExecutionId)
    {
    }

    public function handle(): void
    {
        $execution = CommandExecution::query()->findOrFail($this->commandExecutionId);
        $input     = $execution->command;

        /** Redige registros legados antes que a auditoria serialize os valores originais. */
        $execution->updateQuietly([
            'command'           => $input,
            'command_arguments' => $execution->command_arguments,
            'output'            => $execution->output,
        ]);

        $execution->update([
            'status'      => CommandExecutionStatuses::InProgress,
            'output'      => null,
            'exit_code'   => null,
            'duration_ms' => 0,
            'executed_at' => now(),
        ]);

        $startedAtNs = hrtime(true);
        $output      = '';
        $process     = null;
        $redactor    = app(ArtisanHistoryRedactor::class);

        try {
            $allowedIps = config('artisan-executor.allowed_ips');

            if ($execution->user === null || !Gate::forUser($execution->user)->allows('create', CommandExecution::class)
                || !is_array($allowedIps) || $execution->ip_address === null || !in_array($execution->ip_address, $allowedIps, true)) {
                throw ValidationException::withMessages(['commandInput' => 'Execução não autorizada.']);
            }

            $prepared = app(ArtisanCommandPolicy::class)->prepare($input);
            $execution->update([
                'command'           => $prepared['command'],
                'command_name'      => $prepared['name'],
                'command_arguments' => $prepared['arguments'],
            ]);

            $process = Process::path(base_path())
                ->timeout(max(1, min(120, config()->integer('artisan-executor.timeout', 120))))
                ->start([$this->phpBinary(), 'artisan', $prepared['name'], ...$prepared['arguments'], '--no-interaction', '--no-ansi']);

            $result = $process->wait(function (string $type, string $chunk) use (&$output, $redactor): void {
                if (strlen($chunk) > $redactor->limit() - strlen($output)) {
                    throw new LengthException('Limite de saída excedido.');
                }

                $output .= $chunk;
            });

            $execution->update([
                'status'    => $result->successful() ? CommandExecutionStatuses::Success : CommandExecutionStatuses::Error,
                'exit_code' => $result->exitCode(),
                'output'    => $redactor->redact($output),
            ]);
        } catch (Throwable $throwable) {
            $execution->update([
                'status' => CommandExecutionStatuses::Error,
                'output' => match (true) {
                    $throwable instanceof LengthException     => 'Saída omitida: limite excedido; execução interrompida.',
                    $throwable instanceof ValidationException => 'Este comando não pode ser executado: acesso ou argumentos não autorizados.',
                    default                                   => 'Falha na execução. Detalhes omitidos por segurança.',
                },
            ]);
        } finally {
            rescue(static fn () => $process?->stop(0), report: false);

            $execution->update(['duration_ms' => (int) round((hrtime(true) - $startedAtNs) / 1_000_000)]);
        }
    }

    private function phpBinary(): string
    {
        $configuredBinary = config('artisan-executor.php_binary');

        if (is_string($configuredBinary) && trim($configuredBinary) !== '') {
            return trim($configuredBinary);
        }

        $detectedBinary = new PhpExecutableFinder()->find(false);

        return is_string($detectedBinary) && trim($detectedBinary) !== '' ? $detectedBinary : 'php';
    }
}
