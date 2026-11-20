<?php

declare(strict_types = 1);

use App\Models\User;
use App\Support\Alerts\DiscordAlert;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as LaravelResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        channels: __DIR__ . '/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectGuestsTo(function (Request $request): string {
            if ($request->routeIs('verification.verify')) {
                $intended = $request->session()->get('url.intended');

                if ($intended !== $request->session()->get('verification.url')) {
                    $request->session()->put('verification.destination', $intended);
                }

                $request->session()->put('verification.url', $request->fullUrl());
                $owner = $request->hasValidSignature() ? User::query()->whereKey($request->route('id'))->first() : null;

                return route($owner?->type->loginRouteName() ?? 'customer.login');
            }

            return route(match (true) {
                $request->is('suporte', 'suporte/*')                                        => 'support.login',
                $request->is('cliente', 'cliente/*', 'dashboard', 'perfil', 'verify-email') => 'customer.login',
                default                                                                     => 'admin.login',
            });
        });

        $middleware->redirectUsersTo(function (Request $request): string {
            $user = $request->user();

            return route($user instanceof User ? $user->type->initialRouteName() : 'dashboard');
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->dontReportDuplicates();

        $exceptions->render(function (HttpExceptionInterface $exception, Request $request): ?LaravelResponse {
            if ($request->expectsJson()) {
                return null;
            }

            if ($exception->getStatusCode() === 429 && ($request->routeIs('verification.send') || $request->routeIs('register.store'))) {
                $headers = $exception->getHeaders();
                $view    = $request->routeIs('verification.send') ? 'auth.verify-email' : 'auth.register';

                return response()->view($view, ['retryAfter' => $headers['Retry-After']], 429, $headers);
            }

            if ($request->routeIs('verification.verify') && $exception->getStatusCode() === 403) {
                return response()->view('auth.verify-email', ['invalidLink' => true], 403);
            }

            return null;
        });

        $exceptions->shouldRenderJsonWhen(
            fn (Request $request, Throwable $throwable): bool => $request->is('api/*') || $request->expectsJson()
        );

        $exceptions->respond(function (Response $response, Throwable $throwable, Request $request): Response {
            if (!$request->is('api/*') || !$response instanceof JsonResponse) {
                return $response;
            }

            if ($response->isServerError()) {
                $response->setData([
                    'message' => $response->getStatusCode() === Response::HTTP_INTERNAL_SERVER_ERROR
                        ? 'Server Error'
                        : Response::$statusTexts[$response->getStatusCode()] ?? 'Server Error',
                ]);

                return $response;
            }

            $payload = $response->getData(true);

            if (!is_array($payload)) {
                return $response;
            }

            unset($payload['exception'], $payload['file'], $payload['line'], $payload['trace']);

            $response->setData($payload);

            return $response;
        });

        $exceptions->report(function (Throwable $throwable): void {
            app(DiscordAlert::class)->report($throwable);
        });
    })->create();
