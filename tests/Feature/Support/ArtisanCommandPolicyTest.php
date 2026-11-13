<?php

declare(strict_types = 1);

use App\Support\ArtisanCommandPolicy;
use Illuminate\Validation\ValidationException;

it('accepts exact argument combinations and normalizes optional prefixes', function (string $input): void {
    expect(app(ArtisanCommandPolicy::class)->prepare($input))->toBe([
        'name' => 'about', 'arguments' => ['--only=environment'], 'command' => 'php artisan about --only=environment',
    ]);
})->with(['about --only=environment', 'artisan about --only=environment', ' php artisan about  --only=environment ']);

it('rejects unapproved commands and arguments', function (string $input): void {
    expect(fn () => app(ArtisanCommandPolicy::class)->prepare($input))->toThrow(ValidationException::class);
})->with([
    '', 'php artisan', 'tinker', 'config:show app', 'env', 'queue:work', 'schedule:run',
    'about --env=production', 'about --help', 'about -vvv', 'about --only=database',
    'about --only environment', 'about --only=environment --only=environment',
    'about --password=canary', 'about ; whoami', "about\n", 'about "--only=environment"',
    'a', 'abou', 'about ' . str_repeat('x', 1001),
]);

it('denies missing empty or malformed environment policies despite legacy broad settings', function (mixed $policy): void {
    config()->set('artisan-executor.commands_by_environment', $policy);
    config()->set('artisan-executor.allowed_commands', ['about']);
    config()->set('artisan-executor.allowed_command_prefixes', ['']);

    expect(app(ArtisanCommandPolicy::class)->commands())->toBeEmpty();
    expect(fn () => app(ArtisanCommandPolicy::class)->prepare('about'))->toThrow(ValidationException::class);
})->with([[null], [[]], [''], [['testing' => []]], [['production' => ['about' => [[]]]]], [['testing' => ['about' => []]]], [['testing' => ['about' => true]]]]);

it('discards malformed command rules', function (mixed $rule): void {
    config()->set('artisan-executor.commands_by_environment.testing', ['about' => $rule]);

    expect(app(ArtisanCommandPolicy::class)->commands())->toBeEmpty();
})->with([[['named' => []]], [[true]], [[['x' => 'value']]], [[[1]]], [[['--env=production']]], [[['*']]]]);

it('rejects sensitive arguments even when explicitly configured', function (): void {
    config()->set('artisan-executor.commands_by_environment.testing.about', [['--token=canary']]);

    expect(fn () => app(ArtisanCommandPolicy::class)->prepare('about --token=canary'))->toThrow(ValidationException::class);
});

it('honors explicit blocks and hides nonexistent commands', function (): void {
    config()->set('artisan-executor.commands_by_environment.testing', ['about' => [[]], 'not:a:command' => [[]], '*' => [[]]]);
    config()->set('artisan-executor.blocked_commands', ['about']);

    expect(app(ArtisanCommandPolicy::class)->commands())->toBeEmpty();
});

it('fails closed on malformed block configuration', function (): void {
    config()->set('artisan-executor.blocked_commands');

    expect(fn () => app(ArtisanCommandPolicy::class)->prepare('about'))->toThrow(ValidationException::class);
});

it('uses only the current environment policy', function (): void {
    app()->instance('env', 'production');

    expect(app(ArtisanCommandPolicy::class)->prepare('about --only=environment')['arguments'])->toBe(['--only=environment']);
    expect(app(ArtisanCommandPolicy::class)->suggestions())->toBe(['about --only=environment']);
    expect(fn () => app(ArtisanCommandPolicy::class)->prepare('about'))->toThrow(ValidationException::class);
});

it('never suggests sensitive or blocked variants', function (): void {
    config()->set('artisan-executor.commands_by_environment.testing', [
        'about' => [[], ['--token=canary']], 'migrate:fresh' => [[]],
    ]);

    expect(app(ArtisanCommandPolicy::class)->suggestions())->toBe(['about']);
});
