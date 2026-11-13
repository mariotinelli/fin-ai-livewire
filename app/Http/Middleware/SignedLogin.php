<?php

declare(strict_types = 1);

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SignedLogin
{
    /** @param Closure(Request): Response $next */
    public function handle(Request $request, Closure $next): Response
    {
        abort_unless($request->hasValidSignature() === true, Response::HTTP_FORBIDDEN);

        $userId = $request->integer('user');

        abort_if($userId < 1, Response::HTTP_FORBIDDEN);

        $user = User::query()->find($userId);

        abort_if($user === null, Response::HTTP_FORBIDDEN);

        if (!$request->user()?->is($user)) {
            $request->session()->put('fake_login', true);
            Auth::login($user);
            $request->session()->regenerate();
        }

        return $next($request);
    }
}
