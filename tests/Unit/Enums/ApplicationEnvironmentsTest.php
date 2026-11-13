<?php

declare(strict_types = 1);

use App\Enums\ApplicationEnvironments;

it('resolves names and aliases to canonical environments', function (string $name, ApplicationEnvironments $expected): void {
    expect(ApplicationEnvironments::fromName($name))->toBe($expected);
})->with([
    'local'                 => ['local', ApplicationEnvironments::Local],
    'testing'               => ['testing', ApplicationEnvironments::Testing],
    'qa'                    => ['qa', ApplicationEnvironments::Qa],
    'homolog'               => ['homolog', ApplicationEnvironments::Homolog],
    'hml'                   => ['hml', ApplicationEnvironments::Homolog],
    'production'            => ['production', ApplicationEnvironments::Production],
    'prod'                  => ['prod', ApplicationEnvironments::Production],
    'normalized local'      => [' LOCAL ', ApplicationEnvironments::Local],
    'normalized testing'    => [' Testing ', ApplicationEnvironments::Testing],
    'normalized qa'         => [' QA ', ApplicationEnvironments::Qa],
    'normalized homolog'    => [' HML ', ApplicationEnvironments::Homolog],
    'normalized production' => [' PROD ', ApplicationEnvironments::Production],
]);

it('rejects unknown names instead of assuming a permissive environment', function (string $name): void {
    expect(fn (): ApplicationEnvironments => ApplicationEnvironments::fromName($name))
        ->toThrow(InvalidArgumentException::class, 'Ambiente de aplicação inválido:');
})->with(['', ' ', 'preview', 'development', 'test', 'production-typo', 'staging', ' STAGING ']);

it('distinguishes deployed environments from local development and tests', function (ApplicationEnvironments $environment, bool $deployed): void {
    expect($environment->isDeployed())->toBe($deployed);
})->with([
    [ApplicationEnvironments::Local, false],
    [ApplicationEnvironments::Testing, false],
    [ApplicationEnvironments::Qa, true],
    [ApplicationEnvironments::Homolog, true],
    [ApplicationEnvironments::Production, true],
]);
