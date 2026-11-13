<?php

declare(strict_types = 1);

use App\Models\Address as AddressModel;
use App\Models\City;
use App\Services\Cnpj\Entities\Address;

it('creates cnpj address from api and formats postal code', function (): void {
    $city = City::factory()->create(['name' => 'Sao Paulo']);

    $address = Address::createFromApi([
        'estabelecimento' => [
            'cidade'      => ['nome' => 'Sao Paulo'],
            'estado'      => ['nome' => 'SP'],
            'logradouro'  => 'Rua A',
            'numero'      => '100',
            'bairro'      => 'Centro',
            'complemento' => 'Sala 1',
            'cep'         => '12345678',
        ],
    ]);

    expect($address->cityId)->toBe($city->id)
        ->and($address->postalCode)->toBe('12345-678')
        ->and($address->street)->toBe('Rua A');
});

it('maps cnpj entity data to address model', function (): void {
    $entity = new Address(
        cityName: 'City',
        stateName: 'ST',
        cityId: 10,
        street: 'Street',
        number: '20',
        district: 'District',
        complement: 'Sala 2',
        postalCode: '99999-999',
    );

    $model = $entity->toModel(new AddressModel());

    expect($model->complement)->toBe('Sala 2')
        ->and($model->street)->toBe('Street')
        ->and($model->number)->toBe('20')
        ->and($model->district)->toBe('District')
        ->and($model->postal_code)->toBe('99999-999')
        ->and($model->city_id)->toBe(10);
});

it('handles null optional address fields and creates an unsaved address', function (): void {
    $entity = Address::createFromApi(['estabelecimento' => [
        'cidade' => null, 'estado' => null, 'logradouro' => null, 'numero' => null,
        'bairro' => null, 'complemento' => null, 'cep' => null,
    ]]);

    $model = $entity->toModel(null);

    expect($entity->cityName)->toBeEmpty()->and($entity->stateName)->toBeEmpty()
        ->and($entity->cityId)->toBe(0)->and($entity->postalCode)->toBeEmpty()
        ->and($model->street)->toBe('')->and($model->number)->toBe('')
        ->and($model->district)->toBe('')->and($model->complement)->toBe('')
        ->and($model->exists)->toBeFalse();
    $this->assertDatabaseCount('addresses', 0);
});
