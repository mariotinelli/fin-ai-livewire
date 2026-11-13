<?php

declare(strict_types = 1);

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

it('returns authorization and validation rules', function (): void {
    $request = LoginRequest::create('/login', 'POST');

    expect($request->authorize())->toBeTrue()
        ->and($request->rules())->toBe([
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);
});

it('authenticates and clears rate limiter on success', function (): void {
    $request = LoginRequest::create('/login', 'POST', [
        'email'    => 'user@example.com',
        'password' => 'secret',
        'remember' => '1',
    ], [], [], ['REMOTE_ADDR' => '127.0.0.1']);

    RateLimiter::shouldReceive('tooManyAttempts')->once()->with('user@example.com|127.0.0.1', 5)->andReturnFalse();
    Auth::shouldReceive('attempt')->once()->with([
        'email'    => 'user@example.com',
        'password' => 'secret',
    ], true)->andReturnTrue();
    RateLimiter::shouldReceive('clear')->once()->with('user@example.com|127.0.0.1');

    $request->authenticate();
});

it('throws validation exception and hits rate limiter on failed authentication', function (): void {
    $request = LoginRequest::create('/login', 'POST', [
        'email'    => 'user@example.com',
        'password' => 'wrong',
    ], [], [], ['REMOTE_ADDR' => '127.0.0.1']);

    RateLimiter::shouldReceive('tooManyAttempts')->once()->with('user@example.com|127.0.0.1', 5)->andReturnFalse();
    Auth::shouldReceive('attempt')->once()->with([
        'email'    => 'user@example.com',
        'password' => 'wrong',
    ], false)->andReturnFalse();
    RateLimiter::shouldReceive('hit')->once()->with('user@example.com|127.0.0.1');

    expect(fn () => $request->authenticate())
        ->toThrow(ValidationException::class);
});

it('throws lockout validation exception when too many attempts', function (): void {
    Event::fake([Lockout::class]);

    $request = LoginRequest::create('/login', 'POST', [
        'email' => 'user@example.com',
    ], [], [], ['REMOTE_ADDR' => '127.0.0.1']);

    RateLimiter::shouldReceive('tooManyAttempts')->once()->with('user@example.com|127.0.0.1', 5)->andReturnTrue();
    RateLimiter::shouldReceive('availableIn')->once()->with('user@example.com|127.0.0.1')->andReturn(120);

    expect(fn () => $request->ensureIsNotRateLimited())
        ->toThrow(ValidationException::class);

    Event::assertDispatched(Lockout::class, fn (Lockout $event): bool => $event->request === $request);
});

it('builds throttle key from lowercased transliterated email and ip', function (): void {
    $request = LoginRequest::create('/login', 'POST', [
        'email' => 'Tést@Example.COM',
    ], [], [], ['REMOTE_ADDR' => '127.0.0.1']);

    expect($request->throttleKey())->toBe('test@example.com|127.0.0.1');
});
