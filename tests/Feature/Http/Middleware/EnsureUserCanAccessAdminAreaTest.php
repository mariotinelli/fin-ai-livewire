<?php

declare(strict_types = 1);

use App\Enums\TypeUsers;
use App\Http\Middleware\EnsureUserCanAccessAdminArea;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

it('allows user types with admin area access', function (TypeUsers $type): void {
    $user    = User::factory()->create(['type' => $type]);
    $request = Request::create('/admin', 'GET');
    $request->setUserResolver(fn (): User => $user);

    $response = new EnsureUserCanAccessAdminArea()->handle(
        $request,
        fn (): Response => response('ok'),
    );

    expect($response->getContent())->toBe('ok');
})->with([
    'admin' => TypeUsers::Admin,
    'user'  => TypeUsers::User,
]);

it('forbids customers', function (): void {
    $customer = User::factory()->customer()->create();
    $request  = Request::create('/admin', 'GET');
    $request->setUserResolver(fn (): User => $customer);

    expect(fn (): Response => new EnsureUserCanAccessAdminArea()->handle($request, fn (): Response => response('ok')))
        ->toThrow(HttpException::class, 'Acesso não autorizado.');
});
