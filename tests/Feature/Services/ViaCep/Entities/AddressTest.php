<?php

declare(strict_types = 1);

use App\Models\Address as AddressModel;
use App\Models\City;
use App\Models\State;
use App\Services\ViaCep\Entities\Address;

it('creates viacep address entity from api payload', function (): void {
    City::factory()->for(State::factory()->state(['initials' => 'MG']))->create(['name' => 'Campinas']);
    $city = City::factory()->for(State::factory()->state(['initials' => 'SP']))->create(['name' => 'Campinas']);

    $address = Address::createFromApi([
        'localidade'  => 'Campinas',
        'uf'          => 'SP',
        'logradouro'  => 'Rua C',
        'unidade'     => '20',
        'bairro'      => 'Centro',
        'complemento' => 'Apto 2',
        'cep'         => '13000-000',
    ]);

    expect($address->cityId)->toBe($city->id)
        ->and($address->street)->toBe('Rua C')
        ->and($address->postalCode)->toBe('13000-000');
});

it('prefers the IBGE code over the city name within the state', function (): void {
    $state = State::factory()->create(['initials' => 'SP']);
    City::factory()->for($state)->create(['name' => 'Nome informado']);
    $city = City::factory()->for($state)->create(['ibge_code' => '3509502']);

    $address = Address::createFromApi(['localidade' => 'Nome informado', 'uf' => 'SP', 'cep' => '13000-000', 'ibge' => '3509502']);

    expect($address->cityId)->toBe($city->id);
});

it('falls back to name and state when IBGE cannot resolve the city', function (): void {
    City::factory()->for(State::factory()->state(['initials' => 'MG']))->create(['ibge_code' => '3509502']);
    $city = City::factory()->for(State::factory()->state(['initials' => 'SP']))->create(['name' => 'Campinas']);

    $address = Address::createFromApi(['localidade' => 'Campinas', 'uf' => 'SP', 'cep' => '13000000', 'ibge' => '3509502']);

    expect($address->cityId)->toBe($city->id);
});

it('leaves the model city unset when the city is missing', function (): void {
    City::factory()->for(State::factory()->state(['initials' => 'MG']))->create(['name' => 'Campinas']);

    $entity = Address::createFromApi(['localidade' => 'Campinas', 'uf' => 'SP', 'cep' => '13000-000']);
    $model  = $entity->toModel();

    expect([$entity->cityId, $model->city_id])->toBe([null, null]);
    expect($model->street)->toBe('')
        ->and($model->number)->toBe('')
        ->and($model->district)->toBe('')
        ->and($model->complement)->toBe('');
});

it('rejects malformed address fields', function (string $field, mixed $value): void {
    $payload         = ['localidade' => 'Campinas', 'uf' => 'SP', 'cep' => '13000-000'];
    $payload[$field] = $value;

    expect(fn (): Address => Address::createFromApi($payload))->toThrow(UnexpectedValueException::class);
})->with([
    ['localidade', null], ['localidade', ' '], ['localidade', []],
    ['uf', 'São Paulo'], ['uf', ''], ['cep', '123'], ['cep', null],
    ['logradouro', []], ['unidade', 42], ['bairro', false], ['complemento', []], ['ibge', []],
]);

it('maps viacep address entity data to address model', function (): void {
    $entity = new Address(
        cityName: 'Campinas',
        stateName: 'SP',
        cityId: 33,
        street: 'Rua D',
        number: '40',
        district: 'Centro',
        complement: 'Casa',
        postalCode: '13000-001',
    );

    $model = $entity->toModel(new AddressModel());

    expect($model->city_id)->toBe(33)
        ->and($model->street)->toBe('Rua D')
        ->and($model->number)->toBe('40')
        ->and($model->district)->toBe('Centro')
        ->and($model->complement)->toBe('Casa')
        ->and($model->postal_code)->toBe('13000-001');
});
