<?php

declare(strict_types = 1);

use App\Enums\TypeUsers;
use App\Jobs\ExecuteArtisanCommandJob;
use App\Mail\BrevoTransport;
use App\Models\CommandExecution;
use App\Providers\AppServiceProvider;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\URL;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->withoutVite();
});

it('applies production safeguards to canonical and aliased names', function (string $environment): void {
    app()->detectEnvironment(fn (): string => $environment);
    config()->set('queue.prefix.value', '');
    URL::forceRootUrl('http://environment.example');

    new AppServiceProvider(app())->boot();

    expect(URL::to('/environment-check'))->toBe('https://environment.example/environment-check');
    expect(Model::preventsLazyLoading())->toBeFalse();
    $this->artisan('db:wipe', ['--database' => 'nonexistent_rsp111_connection', '--force' => true])
        ->expectsOutputToContain('This command is prohibited from running in this environment.')
        ->assertFailed();
})->with(['production', 'prod', ' PROD ']);

it('keeps strict models and the configured HTTP scheme outside production', function (string $environment): void {
    app()->detectEnvironment(fn (): string => $environment);
    config()->set('queue.prefix.value', '');
    URL::forceRootUrl('http://environment.example');

    new AppServiceProvider(app())->boot();

    expect(URL::to('/environment-check'))->toBe('http://environment.example/environment-check');
    expect(Model::preventsLazyLoading())->toBeTrue();
})->with(['local', 'testing', 'qa', 'hml', 'homolog']);

it('rejects an unknown environment during provider boot', function (): void {
    app()->detectEnvironment(fn (): string => 'preview');

    expect(fn () => new AppServiceProvider(app())->boot())->toThrow(InvalidArgumentException::class);
});

function adminUpdateSnapshot(string $html, string $name): string
{
    preg_match_all('/wire:snapshot="([^"]+)"/', $html, $matches);

    foreach ($matches[1] as $encoded) {
        $snapshot = html_entity_decode($encoded, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $decoded  = json_decode($snapshot, true, flags: JSON_THROW_ON_ERROR);

        if (app('livewire.factory')->resolveComponentClass($decoded['memo']['name']) === app('livewire.factory')->resolveComponentClass($name)) {
            return $snapshot;
        }
    }

    throw new RuntimeException("Snapshot not found: {$name}");
}

dataset('executor updates', [
    'execute'              => ['support.artisan-commands.index', 'executeCommand'],
    'history re-execution' => ['support.artisan-commands.history', 'reExecute'],
]);

it('returns 403 for executor updates after the client IP becomes denied', function (string $component, string $method): void {
    actingAsSupport();
    Queue::fake();
    Process::fake();
    config()->set('artisan-executor.allowed_ips', ['192.0.2.10']);
    $execution = CommandExecution::factory()->create(['command' => 'php artisan about']);
    $page      = $this->withServerVariables(['REMOTE_ADDR' => '192.0.2.10'])
        ->get(route('support.artisan-commands.index'))->assertOk();
    $snapshot = adminUpdateSnapshot($page->getContent(), $component);

    $this->withServerVariables(['REMOTE_ADDR' => '192.0.2.20'])
        ->postJson(Livewire::getUpdateUri(), ['components' => [[
            'snapshot' => $snapshot, 'updates' => [],
            'calls'    => [['method' => $method, 'params' => [$method === 'reExecute' ? $execution->id : 'php artisan about'], 'path' => '']],
        ]]], ['X-Livewire' => 'true'])
        ->assertForbidden()->assertJsonPath('message', 'Seu IP não está autorizado para usar o executor de comandos.');

    $this->assertDatabaseCount('command_executions', 1);
    Queue::assertNotPushed(ExecuteArtisanCommandJob::class);
    Process::assertNothingRan();
})->with('executor updates');

it('allows authorized executor updates and queues the requested command', function (string $component, string $method): void {
    $user = actingAsSupport();
    Queue::fake();
    Process::fake();
    config()->set('artisan-executor.allowed_ips', ['192.0.2.10']);
    $execution = CommandExecution::factory()->create(['command' => 'php artisan about']);
    $page      = $this->withServerVariables(['REMOTE_ADDR' => '192.0.2.10'])
        ->get(route('support.artisan-commands.index'))->assertOk();

    $this->postJson(Livewire::getUpdateUri(), ['components' => [[
        'snapshot' => adminUpdateSnapshot($page->getContent(), $component), 'updates' => [],
        'calls'    => [['method' => $method, 'params' => [$method === 'reExecute' ? $execution->id : 'php artisan about'], 'path' => '']],
    ]]], ['X-Livewire' => 'true'])->assertOk();

    $this->assertDatabaseCount('command_executions', 2);
    $this->assertDatabaseHas('command_executions', [
        'user_id' => $user->id, 'command' => 'php artisan about', 'ip_address' => '192.0.2.10',
    ]);
    Queue::assertPushed(ExecuteArtisanCommandJob::class, 1);
    Process::assertNothingRan();
})->with('executor updates');

it('returns 403 for administrative updates after area access is revoked even if gates allow access', function (string $route, string $component, string $method): void {
    $user = actingAsSupport();

    if (str_starts_with($route, 'admin.')) {
        $user->update(['type' => TypeUsers::Admin]);
    }

    Queue::fake();
    Process::fake();
    config()->set('artisan-executor.allowed_ips', ['127.0.0.1']);
    Gate::before(fn (): bool => true);
    $execution = CommandExecution::factory()->create(['command' => 'php artisan about']);
    $page      = $this->get(route($route))->assertOk();
    $snapshot  = adminUpdateSnapshot($page->getContent(), $component);
    $user->update(['type' => TypeUsers::Customer]);

    $this->postJson(Livewire::getUpdateUri(), ['components' => [[
        'snapshot' => $snapshot, 'updates' => [],
        'calls'    => [['method' => $method, 'params' => match ($method) {
            'executeCommand' => ['php artisan about'],
            'reExecute'      => [$execution->id],
            default          => [],
        }, 'path' => '']],
    ]]], ['X-Livewire' => 'true'])
        ->assertForbidden()->assertJsonPath('message', 'Acesso não autorizado.');

    $this->assertDatabaseCount('command_executions', 1);
    Queue::assertNotPushed(ExecuteArtisanCommandJob::class);
    Process::assertNothingRan();
})->with([
    'executor'        => ['support.artisan-commands.index', 'support.artisan-commands.index', 'executeCommand'],
    'nested history'  => ['support.artisan-commands.index', 'support.artisan-commands.history', 'reExecute'],
    'user management' => ['admin.management.users.index', 'admin.management.users.index', '$refresh'],
]);

it('denies guests access to the log viewer interface', function (): void {
    $this->get(route('log-viewer.index'))->assertForbidden();
});

it('denies guests access to the log viewer API', function (): void {
    $this->getJson(route('log-viewer.hosts'))->assertForbidden();
});

it('denies non-admin users access to the log viewer interface', function (): void {
    actingAsUser();

    $this->get(route('log-viewer.index'))->assertForbidden();
});

it('denies non-admin users access to the log viewer API', function (): void {
    actingAsUser();

    $this->getJson(route('log-viewer.hosts'))->assertForbidden();
});

it('allows administrators to access the log viewer interface', function (): void {
    actingAsAdmin();

    $this->get(route('log-viewer.index'))->assertOk()->assertViewIs('log-viewer::index');
});

it('allows administrators to access the log viewer API', function (): void {
    actingAsAdmin();

    $this->getJson(route('log-viewer.hosts'))->assertOk()->assertJsonStructure([
        'data' => [['identifier', 'name']],
    ]);
});

it('calculates whole calendar day differences across timezones', function (): void {
    $local = Carbon::parse('2026-09-17 23:30:00', 'America/Sao_Paulo');
    $other = Carbon::parse('2026-09-19 01:00:00', 'UTC');
    $macro = Carbon::getMacro('diffInWholeDays');

    if (!$macro instanceof Closure) {
        throw new RuntimeException('The whole-day difference macro was not registered.');
    }

    $boundMacro = $macro->bindTo($local, Carbon::class);

    if (!$boundMacro instanceof Closure) {
        throw new RuntimeException('The whole-day difference macro could not be bound.');
    }

    expect($boundMacro($other))->toBe(1)
        ->and($boundMacro($other, utc: true))->toBe(1);
});

it('builds the Brevo transport with the configured service key', function (): void {
    config()->set('services.brevo.key', 'service-key');
    config()->set('mail.mailers.brevo', ['transport' => 'brevo']);

    $transport = Mail::mailer('brevo')->getSymfonyTransport();

    expect($transport)->toBeInstanceOf(BrevoTransport::class);
});
