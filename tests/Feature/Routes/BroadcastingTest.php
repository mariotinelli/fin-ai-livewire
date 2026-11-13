<?php

declare(strict_types = 1);

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

it('registers the channel authorization endpoint', function (): void {
    $routes = Route::getRoutes();

    expect($routes->match(Request::create('/broadcasting/auth', 'POST'))->uri())->toBe('broadcasting/auth')
        ->and(fn () => $routes->match(Request::create('/broadcasting/auth', 'DELETE')))
        ->toThrow(MethodNotAllowedHttpException::class);
});

it('authorizes only the authenticated user private channel', function (): void {
    $user      = User::factory()->create();
    $channels  = Broadcast::getChannels();
    $authorize = $channels->get('App.Models.User.{id}');

    expect($authorize)->toBeCallable()
        ->and($authorize($user, $user->id))->toBeTrue()
        ->and($authorize($user, $user->id + 1))->toBeFalse();
});
