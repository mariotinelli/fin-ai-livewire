<?php

declare(strict_types = 1);

use App\Services\Cnpj\CnpjService;
use App\Services\Cnpj\Entities\Customer;
use App\Services\Cnpj\Exceptions\CnpjLimitException;
use App\Services\Cnpj\Exceptions\CnpjNotFoundException;
use App\Services\Cnpj\Exceptions\CnpjOutOfServiceException;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;

beforeEach(function (): void {
    Http::preventStrayRequests();
});

it('throws not found exception for 404 or 400 statuses', function (int $status): void {
    Http::fake(['https://publica.cnpj.ws/cnpj/12345678000190' => Http::response([], $status)]);
    expect(fn (): Customer => new CnpjService()->getCustomer('12345678000190'))->toThrow(CnpjNotFoundException::class);
})->with([400, 404]);

it('throws limit exception for status 429', function (): void {
    Http::fake(['https://publica.cnpj.ws/cnpj/12345678000190' => Http::response([], 429)]);

    expect(fn (): Customer => new CnpjService()->getCustomer('12345678000190'))->toThrow(CnpjLimitException::class);
});

it('throws out of service exception for status 504', function (): void {
    Http::fake(['https://publica.cnpj.ws/cnpj/12345678000190' => Http::response([], 504)]);

    expect(fn (): Customer => new CnpjService()->getCustomer('12345678000190'))->toThrow(CnpjOutOfServiceException::class);
});

it('rejects an incomplete successful response as unavailable', function (): void {
    Http::fake(['https://publica.cnpj.ws/cnpj/12345678000190' => Http::response([], 200)]);

    expect(fn (): Customer => new CnpjService()->getCustomer('12345678000190'))->toThrow(CnpjOutOfServiceException::class);
});

it('returns the complete customer for a realistic 200 response', function (): void {
    Http::fake(['https://publica.cnpj.ws/cnpj/12345678000190' => Http::response([
        'razao_social'    => 'Empresa Exemplo LTDA',
        'socios'          => [['nome' => 'Maria', 'cpf_cnpj_socio' => '***123456**']],
        'estabelecimento' => [
            'cnpj'        => '12345678000190', 'nome_fantasia' => 'Exemplo',
            'ddd1'        => '11', 'telefone1' => '987654321', 'email' => 'contato@example.com',
            'cidade'      => ['nome' => 'São Paulo'], 'estado' => ['nome' => 'São Paulo'],
            'logradouro'  => 'Praça da Sé', 'numero' => '10', 'bairro' => 'Sé',
            'complemento' => 'Sala 2', 'cep' => '01001000',
        ],
    ])]);

    $customer = new CnpjService()->getCustomer('12.345.678/0001-90');

    expect($customer->name)->toBe('Empresa Exemplo LTDA')
        ->and($customer->nickname)->toBe('Exemplo')
        ->and($customer->phone)->toBe('(11) 98765-4321')
        ->and($customer->email)->toBe('contato@example.com')
        ->and($customer->partners)->toBe([['name' => 'Maria', 'document' => '***123456**']])
        ->and($customer->address->cityName)->toBe('São Paulo')
        ->and($customer->address->stateName)->toBe('São Paulo')
        ->and($customer->address->street)->toBe('Praça da Sé')
        ->and($customer->address->number)->toBe('10')
        ->and($customer->address->district)->toBe('Sé')
        ->and($customer->address->complement)->toBe('Sala 2')
        ->and($customer->address->postalCode)->toBe('01001-000');
    Http::assertSent(fn (Request $request): bool => $request->url() === 'https://publica.cnpj.ws/cnpj/12345678000190' && $request->method() === 'GET');
    Http::assertSentCount(1);
    $this->assertDatabaseCount('addresses', 0);
});

it('normalizes alphanumeric CNPJ before requesting customer data', function (): void {
    Http::fake(['https://publica.cnpj.ws/cnpj/00000000E08G12' => Http::response([
        'razao_social'    => 'Empresa Alfanumérica',
        'socios'          => [],
        'estabelecimento' => ['cnpj' => '00000000E08G12'],
    ])]);

    new CnpjService()->getCustomer('00.000.000/e08g-12');

    Http::assertSent(fn (Request $request): bool => $request->url() === 'https://publica.cnpj.ws/cnpj/00000000E08G12');
});

it('treats unexpected statuses as unavailable', function (int $status): void {
    Http::fake(['https://publica.cnpj.ws/cnpj/12345678000190' => Http::response([], $status)]);

    expect(fn (): Customer => new CnpjService()->getCustomer('12345678000190'))->toThrow(CnpjOutOfServiceException::class);
})->with([201, 204, 301, 401, 403, 500, 502, 503]);

it('treats invalid json and non-object json as unavailable', function (string $body): void {
    Http::fake(['https://publica.cnpj.ws/cnpj/12345678000190' => Http::response($body)]);

    expect(fn (): Customer => new CnpjService()->getCustomer('12345678000190'))->toThrow(CnpjOutOfServiceException::class);
})->with(['{', 'null', 'true', '123', '"company"', '["company"]']);

it('translates network errors and timeouts while preserving their cause', function (string $message): void {
    Http::fake(['https://publica.cnpj.ws/cnpj/12345678000190' => Http::failedConnection($message)]);

    try {
        new CnpjService()->getCustomer('12345678000190');
        $this->fail('Expected an unavailable service exception.');
    } catch (CnpjOutOfServiceException $cnpjOutOfServiceException) {
        expect($cnpjOutOfServiceException->getPrevious())->toBeInstanceOf(ConnectionException::class)
            ->and($cnpjOutOfServiceException->getPrevious()->getMessage())->toContain($message);
    }
})->with(['Could not resolve host', 'cURL error 28: Operation timed out']);

it('bounds connection and response time for the external request', function (): void {
    Http::fake(['https://publica.cnpj.ws/cnpj/12345678000190' => function (Request $request, array $options): PromiseInterface {
        expect($options['connect_timeout'])->toBe(5)
            ->and($options['timeout'])->toBe(15);

        return Http::failedConnection('cURL error 28: Operation timed out')($request);
    }]);

    expect(fn (): Customer => new CnpjService()->getCustomer('12345678000190'))
        ->toThrow(CnpjOutOfServiceException::class);
});
