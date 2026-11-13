<?php

declare(strict_types = 1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestrictByIp
{
    /** @param Closure(Request): Response $next */
    public function handle(Request $request, Closure $next): Response
    {
        $allowedIps = config('artisan-executor.allowed_ips', []);

        $clientIp = $request->ip();

        if (!is_array($allowedIps) || $clientIp === null || !in_array($clientIp, $allowedIps, true)) {
            abort(403, 'Seu IP não está autorizado para usar o executor de comandos.');
        }

        return $next($request);
    }
}
