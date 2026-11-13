<?php

declare(strict_types = 1);

use App\Models\City;
use App\Services\Cnpj\Entities\Customer;
use App\Services\Cnpj\Exceptions\CnpjOutOfServiceException;

it('creates customer entity from api payload', function (): void {
    City::factory()->create(['name' => 'Sao Paulo']);

    $customer = Customer::createFromApi([
        'razao_social' => 'Empresa LTDA',
        'socios'       => [
            ['nome' => 'Socio 1', 'cpf_cnpj_socio' => '1'],
        ],
        'estabelecimento' => [
            'ddd1'          => '11',
            'telefone1'     => '99998888',
            'email'         => 'empresa@example.com',
            'nome_fantasia' => 'Empresa',
            'cidade'        => ['nome' => 'Sao Paulo'],
            'estado'        => ['nome' => 'SP'],
            'logradouro'    => 'Rua B',
            'numero'        => '10',
            'bairro'        => 'Centro',
            'complemento'   => '',
            'cep'           => '01001000',
        ],
    ]);

    expect($customer->name)->toBe('Empresa LTDA')
        ->and($customer->phone)->toBe('(11) 9999-8888')
        ->and($customer->partners)->toBe([
            ['name' => 'Socio 1', 'document' => '1'],
        ])
        ->and($customer->address->cityName)->toBe('Sao Paulo');
});

it('accepts missing and null optional values without producing placeholder punctuation', function (array $establishment): void {
    $customer = Customer::createFromApi(['razao_social' => 'Empresa LTDA', 'socios' => null, 'estabelecimento' => $establishment]);

    expect($customer->phone)->toBeEmpty()->and($customer->email)->toBeEmpty()->and($customer->nickname)->toBeEmpty()
        ->and($customer->partners)->toBeEmpty()->and($customer->address->postalCode)->toBeEmpty();
})->with([
    'missing'           => [['cnpj' => '12345678000190']],
    'null'              => [['ddd1' => null, 'telefone1' => null, 'email' => null, 'nome_fantasia' => null, 'cep' => null]],
    'missing phone'     => [['ddd1' => '11']],
    'missing area code' => [['telefone1' => '99998888']],
]);

it('rejects incomplete and malformed customer payloads', function (array $data): void {
    expect(fn (): Customer => Customer::createFromApi($data))->toThrow(CnpjOutOfServiceException::class);
})->with([
    'empty'                 => [[]],
    'missing establishment' => [['razao_social' => 'Empresa']],
    'missing name'          => [['estabelecimento' => ['cnpj' => '12345678000190']]],
    'null name'             => [['razao_social' => null, 'estabelecimento' => ['cnpj' => '12345678000190']]],
    'empty establishment'   => [['razao_social' => 'Empresa', 'estabelecimento' => []]],
    'invalid establishment' => [['razao_social' => 'Empresa', 'estabelecimento' => 'invalid']],
    'invalid phone'         => [['razao_social' => 'Empresa', 'estabelecimento' => ['telefone1' => []]]],
    'invalid city'          => [['razao_social' => 'Empresa', 'estabelecimento' => ['cidade' => 'invalid']]],
    'invalid partners'      => [['razao_social' => 'Empresa', 'estabelecimento' => ['cnpj' => '12345678000190'], 'socios' => ['invalid']]],
    'invalid partner name'  => [['razao_social' => 'Empresa', 'estabelecimento' => ['cnpj' => '12345678000190'], 'socios' => [['nome' => []]]]],
]);

it('formats mobile phone numbers', function (): void {
    $customer = Customer::createFromApi(['razao_social' => 'Empresa', 'estabelecimento' => ['ddd1' => '11', 'telefone1' => '987654321']]);

    expect($customer->phone)->toBe('(11) 98765-4321');
});
