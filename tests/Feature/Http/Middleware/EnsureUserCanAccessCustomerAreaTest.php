<?php

declare(strict_types = 1);

use App\Enums\TypeUsers;
use App\Http\Middleware\EnsureUserCanAccessCustomerArea;
use App\Models\User;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

it('allows a customer through the customer boundary', function (): void {
    $request = Request::create('/cliente/dashboard');
    $user    = User::factory()->customer()->make();
    $request->setUserResolver(fn (): User => $user);
    expect(new EnsureUserCanAccessCustomerArea()->handle($request, fn (): ResponseFactory | \Illuminate\Http\Response => response('allowed'))->getContent())->toBe('allowed');
});

it('rejects guests and internal types', function (?TypeUsers $type): void {
    $request = Request::create('/cliente/dashboard');
    $user    = $type instanceof TypeUsers ? User::factory()->make(['type' => $type]) : null;
    $request->setUserResolver(fn (): ?User => $user);
    expect(fn (): Response => new EnsureUserCanAccessCustomerArea()->handle($request, fn (): ResponseFactory | \Illuminate\Http\Response => response('unexpected')))
        ->toThrow(HttpException::class, 'Acesso não autorizado.');
})->with([null, TypeUsers::Admin, TypeUsers::User, TypeUsers::SupportRemSoft]);
