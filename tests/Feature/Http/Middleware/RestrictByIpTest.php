<?php

declare(strict_types = 1);

use App\Http\Middleware\RestrictByIp;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

it('allows local requests without an authorized IP', function (mixed $ips): void {
    app()->detectEnvironment(fn (): string => 'local');
    config()->set('artisan-executor.allowed_ips', $ips);
    $request = Request::create('/', server: ['REMOTE_ADDR' => '192.0.2.50']);

    expect(app(RestrictByIp::class)->handle($request, fn (): ResponseFactory | \Illuminate\Http\Response => response('allowed'))->getContent())->toBe('allowed');
})->with([[null], [[]], [''], [['192.0.2.1']]]);

it('rejects absent empty malformed and nonmatching IP policies outside local', function (mixed $ips, string $environment): void {
    app()->detectEnvironment(fn (): string => $environment);
    config()->set('artisan-executor.allowed_ips', $ips);
    $request = Request::create('/', server: ['REMOTE_ADDR' => '127.0.0.1']);

    expect(fn () => app(RestrictByIp::class)->handle($request, fn (): ResponseFactory | \Illuminate\Http\Response => response('allowed')))
        ->toThrow(HttpException::class, 'Seu IP não está autorizado');
})->with([[null], [[]], [''], [['192.0.2.1']], [['*']]])->with(['testing', 'homolog', 'production']);

it('accepts explicitly authorized IPv4 and IPv6 clients', function (string $ip): void {
    config()->set('artisan-executor.allowed_ips', [$ip]);
    $request = Request::create('/', server: ['REMOTE_ADDR' => $ip]);

    expect(app(RestrictByIp::class)->handle($request, fn (): ResponseFactory | \Illuminate\Http\Response => response('allowed'))->getContent())->toBe('allowed');
})->with(['127.0.0.1', '::1']);

it('denies a request with no client IP', function (): void {
    config()->set('artisan-executor.allowed_ips', [null]);
    $request = Request::create('/');
    $request->server->remove('REMOTE_ADDR');

    expect(fn () => app(RestrictByIp::class)->handle($request, fn (): ResponseFactory | \Illuminate\Http\Response => response('allowed')))->toThrow(HttpException::class);
});
