<?php

declare(strict_types = 1);

use App\Actions\Address\CreateAddress;
use App\Models\City;

use function Pest\Laravel\assertDatabaseHas;

it('creates an address with all fields', function (): void {
    $city = City::factory()->create();

    $data = [
        'city_id'     => $city->id,
        'street'      => 'Rua das Flores',
        'number'      => '123',
        'district'    => 'Centro',
        'postal_code' => '12345-678',
        'complement'  => 'Apto 101',
    ];

    $address = new CreateAddress()->handle($data);

    expect($address->city_id)->toBe($city->id)
        ->and($address->street)->toBe('Rua das Flores')
        ->and($address->number)->toBe('123')
        ->and($address->district)->toBe('Centro')
        ->and($address->postal_code)->toBe('12345-678')
        ->and($address->complement)->toBe('Apto 101');

    assertDatabaseHas('addresses', [
        'id'          => $address->id,
        'city_id'     => $city->id,
        'street'      => 'Rua das Flores',
        'number'      => '123',
        'district'    => 'Centro',
        'postal_code' => '12345-678',
        'complement'  => 'Apto 101',
    ]);
});

it('creates an address with nullable complement', function (): void {
    $city = City::factory()->create();

    $address = new CreateAddress()->handle([
        'city_id'     => $city->id,
        'street'      => 'Avenida Brasil',
        'number'      => '456',
        'district'    => 'Jardins',
        'postal_code' => '87654-321',
        'complement'  => null,
    ]);

    expect($address->complement)->toBeNull();

    assertDatabaseHas('addresses', [
        'id'          => $address->id,
        'city_id'     => $city->id,
        'street'      => 'Avenida Brasil',
        'number'      => '456',
        'district'    => 'Jardins',
        'postal_code' => '87654-321',
        'complement'  => null,
    ]);
});
