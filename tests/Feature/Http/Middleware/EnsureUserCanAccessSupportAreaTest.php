<?php

declare(strict_types = 1);

use App\Enums\TypeUsers;
use App\Http\Middleware\EnsureUserCanAccessSupportArea;
use App\Models\User;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

it('allows only support through the area boundary', function (): void {
    $request = Request::create('/suporte/meu-perfil');
    $user    = User::factory()->make(['type' => TypeUsers::SupportRemSoft]);
    $request->setUserResolver(fn (): User => $user);
    $response = new EnsureUserCanAccessSupportArea()->handle($request, fn (): ResponseFactory | \Illuminate\Http\Response => response('allowed'));
    expect($response->getContent())->toBe('allowed');
});

it('rejects guests and other types at the area boundary', function (?TypeUsers $type): void {
    $request = Request::create('/suporte/meu-perfil');
    $user    = $type instanceof TypeUsers ? User::factory()->make(['type' => $type]) : null;
    $request->setUserResolver(fn (): ?User => $user);
    expect(fn (): Response => new EnsureUserCanAccessSupportArea()->handle($request, fn (): ResponseFactory | \Illuminate\Http\Response => response('unexpected')))
        ->toThrow(HttpException::class, 'Acesso não autorizado.');
})->with([null, TypeUsers::Admin, TypeUsers::User, TypeUsers::Customer]);
