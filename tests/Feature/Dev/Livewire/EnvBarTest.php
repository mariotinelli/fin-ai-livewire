<?php

declare(strict_types = 1);

use App\Dev\Livewire\EnvBar;
use Dom\HTMLDocument;
use Dom\XPath;
use Illuminate\Support\Facades\Process;

use function Pest\Livewire\livewire;

it('renders the environment without development controls outside local', function (string $environment): void {
    app()->detectEnvironment(fn (): string => $environment);
    config()->set('app.env', $environment);
    Process::fake();

    $component = livewire(EnvBar::class)
        ->assertSeeText($environment)
        ->assertSet('branch', null);

    $document = HTMLDocument::createFromString($component->html(), LIBXML_NOERROR);
    $xpath    = new XPath($document);

    expect($xpath->evaluate('count(//*[local-name()="span"])'))->toBe(1.0);
    expect($xpath->evaluate('count(//*[local-name()="svg"])'))->toBe(0.0);
    Process::assertNothingRan();
})->with(['production', 'homolog']);

it('renders the local environment and the controlled Git result', function (string $output, string $errorOutput, int $exitCode, string $expectedBranch): void {
    app()->detectEnvironment(fn (): string => 'local');
    config()->set('app.env', 'local');
    Process::preventStrayProcesses();
    Process::fake([
        'git branch --show-current' => Process::result(
            output: $output,
            errorOutput: $errorOutput,
            exitCode: $exitCode,
        ),
    ]);

    $component = livewire(EnvBar::class)->assertSeeText('local');
    $document  = HTMLDocument::createFromString($component->html(), LIBXML_NOERROR);
    $xpath     = new XPath($document);

    expect($xpath->evaluate('count(//*[local-name()="span"])'))->toBe(2.0);
    expect($xpath->evaluate('normalize-space((//*[local-name()="span"])[2])'))->toBe($expectedBranch);
    expect($xpath->evaluate('count(//*[local-name()="svg"])'))->toBe(1.0);
    Process::assertRan('git branch --show-current');
})->with([
    'current branch'                         => ["feature/RSP-60\n", '', 0, 'feature/RSP-60'],
    'another branch and Windows newline'     => ["  fix/another-branch\r\n", '', 0, 'fix/another-branch'],
    'HTML in branch is escaped'              => ["feature/<b>branch</b>\n", '', 0, 'feature/<b>branch</b>'],
    'detached HEAD'                          => ['', '', 0, ''],
    'Git failure discards stdout and stderr' => ['invalid-branch', 'fatal: not a git repository', 128, ''],
    'Git missing on Unix'                    => ['', 'git: command not found', 127, ''],
    'Git missing on Windows'                 => ['', 'git is not recognized', 1, ''],
]);

it('renders the environment badge through its dedicated view', function (): void {
    app()->detectEnvironment(fn (): string => 'production');
    config()->set('app.env', 'production');

    livewire(EnvBar::class)
        ->assertSeeText('production')
        ->assertDontSeeHtml('icon="branch"');
});

it('displays the canonical environment for aliases without running Git', function (string $environment, string $label): void {
    app()->detectEnvironment(fn (): string => $environment);
    Process::preventStrayProcesses();
    Process::fake();

    livewire(EnvBar::class)->assertSeeText($label)->assertSet('branch', null);

    Process::assertNothingRan();
})->with([
    ['prod', 'production'],
    [' HML ', 'homolog'],
    [' QA ', 'qa'],
]);

it('keeps the local branch visible for a normalized local name', function (): void {
    app()->detectEnvironment(fn (): string => ' LOCAL ');
    Process::preventStrayProcesses();
    Process::fake(['git branch --show-current' => Process::result(output: "task/RSP-111\n")]);

    livewire(EnvBar::class)->assertSeeText('local')->assertSeeText('task/RSP-111');

    Process::assertRan('git branch --show-current');
});
