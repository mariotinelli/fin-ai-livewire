<?php

declare(strict_types = 1);

use App\Enums\ApplicationEnvironments;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Number;

function user(): ?User
{
    $user = auth()->user();

    return $user instanceof User ? $user : null;
}

function authenticatedUser(?Request $request = null): User
{
    $user = $request instanceof Request ? $request->user() : user();
    abort_unless($user instanceof User, 401);

    return $user;
}

function applicationEnvironment(): ApplicationEnvironments
{
    return ApplicationEnvironments::fromName(app()->environment());
}

function withEnvBar(): bool
{
    return match (applicationEnvironment()) {
        ApplicationEnvironments::Local, ApplicationEnvironments::Testing => true,
        ApplicationEnvironments::Qa                                      => request()->cookie('envbar_enabled') === '1' || request()->cookie('qa_envbar_enabled') === '1',
        ApplicationEnvironments::Homolog                                 => request()->cookie('envbar_enabled') === '1',
        default                                                          => false,
    };
}

function currency(float | int | string | null $value): string
{
    if (is_string($value)) {
        $value = str($value)
            ->replace('.', '')
            ->replace(',', '.')
            ->toFloat();
    }

    return Number::currency($value ?? 0, in: 'BRL', locale: config()->string('app.locale'))
        ?: throw new RuntimeException('Não foi possível formatar o valor monetário.');
}

function percentage(float | int | null $value): string
{
    return Number::percentage($value ?? 0)
        ?: throw new RuntimeException('Não foi possível formatar a porcentagem.');
}

/** @return array<int, string> */
function defaultStatuses(): array
{
    return [
        1 => 'Ativo',
        0 => 'Inativo',
    ];
}

function compareMoney(float | int | string | null $oldValue, float | int | string | null $newValue, string $operator = '!=='): bool
{
    return $operator === '!=='
        ? currency($oldValue) !== currency($newValue)
        : currency($oldValue) === currency($newValue);
}
