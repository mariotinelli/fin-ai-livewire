<?php

declare(strict_types = 1);

namespace App\Support;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Validation\ValidationException;

class ArtisanCommandPolicy
{
    /** @return array{name: string, arguments: list<string>, command: string} */
    public function prepare(string $input): array
    {
        if (strlen($input) > 1000 || preg_match('/[\x00-\x1f\x7f]/', $input) === 1) {
            $this->deny();
        }

        $tokens = array_values(array_filter(explode(' ', trim($input)), static fn (string $token): bool => $token !== ''));

        if (($tokens[0] ?? null) === 'php') {
            array_shift($tokens);
        }

        if (($tokens[0] ?? null) === 'artisan') {
            array_shift($tokens);
        }

        $name     = array_shift($tokens);
        $policies = $this->policies();

        if ($name === null || !in_array($name, $this->commands(), true) || !in_array($tokens, $policies[$name], true)) {
            $this->deny();
        }

        $command = implode(' ', ['php', 'artisan', $name, ...$tokens]);

        if (app(ArtisanHistoryRedactor::class)->redact($command) !== $command) {
            $this->deny();
        }

        return ['name' => $name, 'arguments' => $tokens, 'command' => $command];
    }

    /** @return list<string> */
    public function commands(): array
    {
        $blocked = config('artisan-executor.blocked_commands', []);

        if (!is_array($blocked)) {
            return [];
        }

        $available = Artisan::all();

        return array_values(array_filter(
            array_keys($this->policies()),
            static fn (string $name): bool => !in_array($name, $blocked, true) && array_key_exists($name, $available)
        ));
    }

    /** @return list<string> */
    public function suggestions(): array
    {
        $policies    = $this->policies();
        $suggestions = [];

        foreach ($this->commands() as $name) {
            foreach ($policies[$name] as $arguments) {
                $suggestion = implode(' ', [$name, ...$arguments]);

                if (app(ArtisanHistoryRedactor::class)->redact($suggestion) === $suggestion) {
                    $suggestions[] = $suggestion;
                }
            }
        }

        return array_values(array_unique($suggestions));
    }

    /** @return array<string, list<list<string>>> */
    private function policies(): array
    {
        $environments = config('artisan-executor.commands_by_environment');
        $policies     = is_array($environments) ? ($environments[app()->environment()] ?? null) : null;

        if (!is_array($policies)) {
            return [];
        }

        $valid = [];

        foreach ($policies as $name => $variants) {
            if (!is_string($name) || preg_match('/^[a-z][a-z0-9:-]*$/D', $name) !== 1 || !is_array($variants) || $variants === [] || !array_is_list($variants)) {
                continue;
            }

            foreach ($variants as $arguments) {
                if (!is_array($arguments) || !array_is_list($arguments)) {
                    continue 2;
                }

                foreach ($arguments as $argument) {
                    if (!is_string($argument) || preg_match('/^[a-zA-Z0-9_:.,=\/-]+$/D', $argument) !== 1 || str_starts_with($argument, '--env')) {
                        continue 3;
                    }
                }
            }

            /** @var list<list<string>> $variants */
            $valid[$name] = $variants;
        }

        return $valid;
    }

    private function deny(): never
    {
        throw ValidationException::withMessages([
            'commandInput' => 'Este comando ou seus argumentos não podem ser executados por segurança.',
        ]);
    }
}
