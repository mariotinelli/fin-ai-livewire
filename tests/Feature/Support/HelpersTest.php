<?php

declare(strict_types = 1);

use App\Enums\ApplicationEnvironments;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

use function Pest\Laravel\actingAs;

it('returns current authenticated user and null when guest', function (): void {
    expect(user())->toBeNull();

    /** @var User $authUser */
    $authUser = User::factory()->create();
    actingAs($authUser);

    expect(user())->toBeInstanceOf(User::class)
        ->and(user()?->id)->toBe($authUser->id);
});

it('resolves env bar visibility based on environment and qa cookie flag', function (): void {
    app()->detectEnvironment(fn (): string => 'production');

    expect(withEnvBar())->toBeFalse();

    app()->detectEnvironment(fn (): string => 'qa');
    request()->cookies->set('qa_envbar_enabled', '1');

    expect(withEnvBar())->toBeTrue();

    app()->detectEnvironment(fn (): string => 'testing');
});

it('recognizes normalized environments while preserving env bar access rules', function (string $environment, bool $cookieEnabled, bool $visible): void {
    app()->detectEnvironment(fn (): string => $environment);
    request()->cookies->set('qa_envbar_enabled', $cookieEnabled ? '1' : '0');

    expect(withEnvBar())->toBe($visible);
})->with([
    'local'             => [' LOCAL ', false, true],
    'testing'           => [' Testing ', false, true],
    'qa without cookie' => [' QA ', false, false],
    'qa with cookie'    => [' QA ', true, true],
    'homolog alias'     => ['hml', true, false],
    'homolog'           => ['homolog', true, false],
    'production alias'  => ['prod', true, false],
    'production'        => ['production', true, false],
]);

it('queues env bar cookie on real login in permitted deployed environments', function (string $environment): void {
    $user = User::factory()->create();

    app()->detectEnvironment(fn (): string => 'production');
    Auth::login($user);

    expect(collect(Cookie::getQueuedCookies())->contains(
        fn (Symfony\Component\HttpFoundation\Cookie $cookie): bool => $cookie->getName() === 'envbar_enabled',
    ))->toBeFalse();

    app()->detectEnvironment(fn (): string => $environment);
    Auth::logout();
    Auth::login($user);

    expect(collect(Cookie::getQueuedCookies())->contains(
        fn (Symfony\Component\HttpFoundation\Cookie $cookie): bool => $cookie->getName() === 'envbar_enabled',
    ))->toBeTrue();

    app()->detectEnvironment(fn (): string => 'testing');
})->with([' QA ', 'hml', 'homolog']);

it('supports the shared env bar cookie only in permitted environments', function (string $environment, bool $visible): void {
    app()->detectEnvironment(fn (): string => $environment);
    request()->cookies->set('envbar_enabled', '1');

    expect(withEnvBar())->toBe($visible);
})->with([
    ['qa', true], ['hml', true], ['homolog', true], ['prod', false], ['production', false],
]);

it('classifies the runtime environment without rewriting its configured identifier', function (): void {
    app()->detectEnvironment(fn (): string => 'hml');

    expect(applicationEnvironment())->toBe(ApplicationEnvironments::Homolog);
    expect(app()->environment())->toBe('hml');
});

it('rejects unknown environments when deciding whether to expose development controls', function (): void {
    app()->detectEnvironment(fn (): string => 'preview');

    expect(fn (): bool => withEnvBar())->toThrow(InvalidArgumentException::class);
});

it('returns default statuses and compares money values', function (): void {
    expect(defaultStatuses())->toBe([1 => 'Ativo', 0 => 'Inativo'])
        ->and(percentage(25))->toContain('25')
        ->and(percentage(null))->toContain('0')
        ->and(compareMoney('1,00', '1,00'))->toBeFalse()
        ->and(compareMoney('1,00', '2,00'))->toBeTrue()
        ->and(compareMoney('1,00', '1,00', '==='))->toBeTrue();
});
