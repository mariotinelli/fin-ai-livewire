<?php

declare(strict_types = 1);

use App\Http\Middleware\SignedLogin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

use function Pest\Laravel\actingAs;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

it('rejects a request without a signature', function (): void {
    $user    = User::factory()->create();
    $request = Request::create('/signed-login?user=' . $user->id, 'GET');
    app()->instance('request', $request);

    expect(fn (): Response => new SignedLogin()->handle($request, fn (): Response => response('ok')))
        ->toThrow(HttpException::class);

    expect(Auth::id())->toBeNull()
        ->and(session('fake_login'))->toBeNull();
});

it('logs in the active user from a valid temporary signed URL', function (): void {
    /** @var User $loggedUser */
    $loggedUser = User::factory()->create();
    /** @var User $targetUser */
    $targetUser = User::factory()->create();
    actingAs($loggedUser);
    $request = signedLoginRequest($targetUser->id);

    $response = new SignedLogin()->handle($request, fn (): Response => response('ok'));

    expect($response->getContent())->toBe('ok')
        ->and(session('fake_login'))->toBeTrue()
        ->and(Auth::id())->toBe($targetUser->id);
});

it('keeps the current authentication when the signed user matches', function (): void {
    /** @var User $user */
    $user = User::factory()->create();
    actingAs($user);
    $request = signedLoginRequest($user->id);

    $response = new SignedLogin()->handle($request, fn (): Response => response('ok'));

    expect($response->getContent())->toBe('ok')
        ->and(session('fake_login'))->toBeNull()
        ->and(Auth::id())->toBe($user->id);
});

it('rejects a valid signature without a user', function (): void {
    $request = signedLoginRequest();

    expect(fn (): Response => new SignedLogin()->handle($request, fn (): Response => response('ok')))
        ->toThrow(HttpException::class);

    expect(Auth::id())->toBeNull()
        ->and(session('fake_login'))->toBeNull();
});

it('rejects a valid signature for a missing user', function (): void {
    $request = signedLoginRequest(999999);

    expect(fn (): Response => new SignedLogin()->handle($request, fn (): Response => response('ok')))
        ->toThrow(HttpException::class);

    expect(Auth::id())->toBeNull()
        ->and(session('fake_login'))->toBeNull();
});

it('rejects an expired signature', function (): void {
    $user = User::factory()->create();
    $url  = URL::temporarySignedRoute('home', now()->addMinute(), ['user' => $user->id]);
    $this->travel(2)->minutes();
    $request = Request::create($url, 'GET');
    app()->instance('request', $request);

    expect(fn (): Response => new SignedLogin()->handle($request, fn (): Response => response('ok')))
        ->toThrow(HttpException::class);

    expect(Auth::id())->toBeNull()
        ->and(session('fake_login'))->toBeNull();
});

it('rejects a signed login for a deleted user', function (): void {
    $user = User::factory()->create();
    $user->delete();

    $request = signedLoginRequest($user->id);

    expect(fn (): Response => new SignedLogin()->handle($request, fn (): Response => response('ok')))
        ->toThrow(HttpException::class);

    expect(Auth::id())->toBeNull()
        ->and(session('fake_login'))->toBeNull();
});

function signedLoginRequest(?int $userId = null): Request
{
    $parameters = $userId === null ? [] : ['user' => $userId];
    $url        = URL::temporarySignedRoute('home', now()->addMinute(), $parameters);
    $request    = Request::create($url, 'GET');
    $request->setLaravelSession(app('session')->driver());

    app()->instance('request', $request);

    return $request;
}
