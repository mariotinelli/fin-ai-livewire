<?php

declare(strict_types = 1);

use App\Models\User;
use App\Support\Alerts\DiscordAlert;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        channels: __DIR__ . '/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectGuestsTo(fn (Request $request): string => route(match (true) {
            $request->is('suporte', 'suporte/*') => 'support.login',
            $request->is('cliente', 'cliente/*') => 'customer.login',
            default                              => 'admin.login',
        }));

        $middleware->redirectUsersTo(function (Request $request): string {
            $user = $request->user();

            return route($user instanceof User ? $user->type->initialRouteName() : 'dashboard');
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->dontReportDuplicates();

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
