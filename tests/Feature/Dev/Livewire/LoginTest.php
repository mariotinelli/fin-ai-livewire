<?php

declare(strict_types = 1);

use App\Dev\Livewire\Login;
use App\Models\User;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;
use Livewire\Livewire;

use function Pest\Livewire\livewire;

beforeEach(function (): void {
    $this->users = User::factory(10)->create();
});

it('should be list all users', function (): void {
    livewire(Login::class)
        ->assertSet('users', fn (Collection $users): bool => $users->count() === 10);
});

it('can be able to login with the selected user', function (): void {
    livewire(Login::class)
        ->set('selectedUser', $this->users->first()->id)
        ->call('login')
        ->assertRedirectToRoute('home');

    expect(session('fake_login'))->toBeTrue()
        ->and(auth()->id())->toBe($this->users->first()->id);
});

it('can not be able to login with has not selected user', function (): void {
    livewire(Login::class)
        ->set('selectedUser')
        ->call('login')
        ->assertHasErrors('selectedUser');

    expect(session('fake_login'))->toBeNull()
        ->and(auth()->id())->toBeNull();
});

it('renders the login control through its dedicated view', function (): void {
    livewire(Login::class)
        ->assertSeeHtml('wire:model="selectedUser"')
        ->assertSeeHtml('wire:click="login"')
        ->assertSeeText('LOGIN');
});

it('rejects direct access when the environment bar is disabled', function (string $environment): void {
    app()->detectEnvironment(fn (): string => $environment);
    livewire(Login::class)->assertUnauthorized();
})->with(['prod', 'production', 'qa', 'hml', 'homolog']);

it('rejects further requests from a mounted component after the bar is disabled', function (string $action): void {
    $actor = actingAsAdmin();
    app()->detectEnvironment(fn (): string => 'qa');
    $component = Livewire::withCookies(['envbar_enabled' => '1'])->test(Login::class)
        ->set('selectedUser', $this->users->first()->id);
    request()->cookies->remove('envbar_enabled');
    request()->cookies->remove('qa_envbar_enabled');

    $component->call($action)->assertUnauthorized();

    expect(auth()->id())->toBe($actor->id);
    expect(session('fake_login'))->toBeNull();
})->with(['$refresh', 'login']);

it('rejects production access even when enable cookies are supplied', function (string $environment): void {
    app()->detectEnvironment(fn (): string => $environment);

    Livewire::withCookies(['envbar_enabled' => '1', 'qa_envbar_enabled' => '1'])
        ->test(Login::class)->assertUnauthorized();
})->with(['prod', 'production']);

it('regenerates the session without queuing an enable cookie during simulated login', function (string $environment): void {
    app()->detectEnvironment(fn (): string => $environment);
    $component = Livewire::withCookies(['envbar_enabled' => '1'])->test(Login::class)
        ->set('selectedUser', $this->users->first()->id);
    $sessionId = session()->getId();
    $token     = session()->token();

    $component->call('login')->assertRedirectToRoute('home');

    expect(auth()->id())->toBe($this->users->first()->id);
    expect(session()->getId())->not->toBe($sessionId);
    expect(session()->token())->not->toBe($token);
    expect(Cookie::hasQueued('envbar_enabled'))->toBeFalse();
    expect(Cookie::hasQueued('qa_envbar_enabled'))->toBeFalse();
})->with(['qa', 'hml', 'homolog']);

it('does not mark or change identity when the selected user is unavailable', function (bool $deleted): void {
    $actor      = actingAsAdmin();
    $target     = $this->users->first();
    $selectedId = $deleted ? $target->id : PHP_INT_MAX;

    if ($deleted) {
        $target->delete();
    }

    livewire(Login::class)->set('selectedUser', $selectedId)->call('login')->assertHasErrors('selectedUser');

    expect(auth()->id())->toBe($actor->id);
    expect(session('fake_login'))->toBeNull();
})->with([false, true]);
