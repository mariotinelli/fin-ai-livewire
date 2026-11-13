<?php

declare(strict_types = 1);

use App\Actions\Address\UpdateAddress;
use App\Models\Address;
use App\Models\City;

use function Pest\Laravel\assertDatabaseHas;

it('updates an address with all fields', function (): void {
    $originCity      = City::factory()->create();
    $destinationCity = City::factory()->create();

    $address = Address::query()->create([
        'city_id'     => $originCity->id,
        'street'      => 'Rua Antiga',
        'number'      => '10',
        'district'    => 'Centro',
        'postal_code' => '11111-111',
        'complement'  => 'Casa',
    ]);

    $updatedAddress = new UpdateAddress()->handle($address, [
        'city_id'     => $destinationCity->id,
        'street'      => 'Rua Nova',
        'number'      => '999',
        'district'    => 'Batel',
        'postal_code' => '22222-222',
        'complement'  => 'Apto 202',
    ]);

    expect($updatedAddress->id)->toBe($address->id)
        ->and($updatedAddress->city_id)->toBe($destinationCity->id)
        ->and($updatedAddress->street)->toBe('Rua Nova')
        ->and($updatedAddress->number)->toBe('999')
        ->and($updatedAddress->district)->toBe('Batel')
        ->and($updatedAddress->postal_code)->toBe('22222-222')
        ->and($updatedAddress->complement)->toBe('Apto 202');

    assertDatabaseHas('addresses', [
        'id'          => $address->id,
        'city_id'     => $destinationCity->id,
        'street'      => 'Rua Nova',
        'number'      => '999',
        'district'    => 'Batel',
        'postal_code' => '22222-222',
        'complement'  => 'Apto 202',
    ]);
});

it('updates an address with nullable complement', function (): void {
    $city = City::factory()->create();

    $address = Address::query()->create([
        'city_id'     => $city->id,
        'street'      => 'Rua 1',
        'number'      => '50',
        'district'    => 'Setor Sul',
        'postal_code' => '74000-000',
        'complement'  => 'Bloco A',
    ]);

    $updatedAddress = new UpdateAddress()->handle($address, [
        'city_id'     => $city->id,
        'street'      => 'Rua 2',
        'number'      => '60',
        'district'    => 'Setor Bueno',
        'postal_code' => '74100-000',
        'complement'  => null,
    ]);

    expect($updatedAddress->complement)->toBeNull();

    assertDatabaseHas('addresses', [
        'id'          => $address->id,
        'city_id'     => $city->id,
        'street'      => 'Rua 2',
        'number'      => '60',
        'district'    => 'Setor Bueno',
        'postal_code' => '74100-000',
        'complement'  => null,
    ]);
});
