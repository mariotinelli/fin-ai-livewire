<?php

declare(strict_types = 1);

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Exceptions;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

use function Pest\Laravel\actingAs;

use function Pest\Laravel\get;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;

it('returns 401 when the Sanctum identity endpoint has no authenticated user', function (): void {
    getJson('/api/user')
        ->assertUnauthorized()
        ->assertJsonMissingPath('exception')
        ->assertJsonMissingPath('trace');
});

it('returns the authenticated user through the Sanctum identity endpoint', function (): void {
    $user = User::factory()->create();
    actingAs($user);

    getJson('/api/user')
        ->assertSuccessful()
        ->assertJson([
            'data' => [
                'id'    => $user->id,
                'email' => $user->email,
            ],
        ]);
});

it('returns 422 with validation errors for an invalid API request', function (): void {
    Route::post('/api/rsp-78/validation', fn (Request $request): array => $request->validate([
        'email' => ['required', 'email'],
    ]));

    postJson('/api/rsp-78/validation')
        ->assertUnprocessable()
        ->assertJsonValidationErrors('email')
        ->assertJsonMissingPath('exception')
        ->assertJsonMissingPath('trace');
});

it('returns 403 without exposing authorization internals for a denied API request', function (): void {
    Gate::define('rsp-78-denied', fn (User $user): bool => false);

    Route::get('/api/rsp-78/authorization', function (): array {
        Gate::authorize('rsp-78-denied');

        return [];
    })->middleware('auth:sanctum');

    actingAs(User::factory()->create());

    getJson('/api/rsp-78/authorization')
        ->assertForbidden()
        ->assertJsonMissingPath('exception')
        ->assertJsonMissingPath('trace');
});

it('returns 404 without exception details for an unknown API route', function (): void {
    get('/api/rsp-78/unknown')
        ->assertNotFound()
        ->assertHeader('content-type', 'application/json')
        ->assertJsonMissingPath('exception')
        ->assertJsonMissingPath('trace');
});

it('returns 500 without sensitive exception details for an API failure', function (): void {
    Exceptions::fake();
    config()->set('app.debug', true);

    Route::get('/api/rsp-78/failure', function (): never {
        throw new RuntimeException('database_password=confidential');
    });

    getJson('/api/rsp-78/failure')
        ->assertInternalServerError()
        ->assertJsonPath('message', 'Server Error')
        ->assertJsonMissingPath('exception')
        ->assertJsonMissingPath('trace')
        ->assertDontSee('database_password', false)
        ->assertDontSee('confidential', false);

    Exceptions::assertReported(RuntimeException::class);
});
