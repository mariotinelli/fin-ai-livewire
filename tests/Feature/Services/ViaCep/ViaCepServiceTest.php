<?php

declare(strict_types = 1);

use App\Models\City;
use App\Models\State;
use App\Services\ViaCep\Entities\Address;
use App\Services\ViaCep\Exceptions\BadRequestException;
use App\Services\ViaCep\Exceptions\CepNotFoundException;
use App\Services\ViaCep\ViaCepService;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;

beforeEach(function (): void {
    Http::preventStrayRequests();
});

it('throws bad request for status 400', function (): void {
    Http::fake(['https://viacep.com.br/ws/13000000/json/' => Http::response([], 400)]);

    expect(fn (): Address => new ViaCepService()->getAddress('13000-000'))->toThrow(BadRequestException::class);
});

it('throws cep not found when api returns erro true', function (bool | string $error): void {
    Http::fake(['https://viacep.com.br/ws/13000000/json/' => Http::response(['erro' => $error], 200)]);

    expect(fn (): Address => new ViaCepService()->getAddress('13000-000'))->toThrow(CepNotFoundException::class);
})->with([true, 'true']);

it('returns address entity when api payload is valid', function (): void {
    $city = City::factory()->for(State::factory()->state(['initials' => 'SP']))->create(['name' => 'Campinas']);

    Http::fake(['https://viacep.com.br/ws/13000000/json/' => Http::response([
        'localidade'  => 'Campinas',
        'uf'          => 'SP',
        'logradouro'  => 'Rua E',
        'unidade'     => '15',
        'bairro'      => 'Centro',
        'complemento' => '',
        'cep'         => '13000-000',
    ], 200)]);

    $address = new ViaCepService()->getAddress(' 13.000-000 ');

    expect($address->cityId)->toBe($city->id)
        ->and($address->street)->toBe('Rua E');

    Http::assertSentCount(1);
});

it('rejects invalid postal codes before requesting the api', function (string $cep): void {
    Http::fake();

    expect(fn (): Address => new ViaCepService()->getAddress($cep))->toThrow(BadRequestException::class);

    Http::assertNothingSent();
})->with(['', '123', '123456789', 'abcdefgh']);

it('rejects invalid responses', function (string $body, int $status): void {
    Http::fake(['https://viacep.com.br/ws/13000000/json/' => Http::response($body, $status)]);

    expect(fn (): Address => new ViaCepService()->getAddress('13000000'))->toThrow(UnexpectedValueException::class);
})->with([
    'server failure' => ['{}', 500],
    'redirect'       => ['{}', 302],
    'invalid json'   => ['{', 200],
    'null'           => ['null', 200],
    'scalar'         => ['true', 200],
    'empty object'   => ['{}', 200],
    'list'           => ['[]', 200],
]);

it('propagates connection failures for component feedback', function (): void {
    Http::fake(['https://viacep.com.br/ws/13000000/json/' => Http::failedConnection()]);

    expect(fn (): Address => new ViaCepService()->getAddress('13000000'))->toThrow(ConnectionException::class);
});

it('limits connection and response time while handling a timeout', function (): void {
    Http::fake(['https://viacep.com.br/ws/13000000/json/' => function (Request $request, array $options): PromiseInterface {
        expect($options['connect_timeout'])->toBe(3)->and($options['timeout'])->toBe(10);

        return Http::failedConnection('cURL error 28: Operation timed out')($request);
    }]);

    expect(fn (): Address => new ViaCepService()->getAddress('13000000'))->toThrow(ConnectionException::class);
});
