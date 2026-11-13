<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\City;
use App\Services\ViaCep\Entities;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<\App\Models\Address> */
class AddressFactory extends Factory
{
    public function definition(): array
    {
        return [
            'city_id'     => City::factory(),
            'street'      => fake()->streetName,
            'number'      => fake()->buildingNumber,
            'district'    => fake()->streetName,
            'postal_code' => fake()->postcode,
            'complement'  => fake()->randomElement(['Apto. 101', 'Casa 2', null]),
        ];
    }

    public function fromEntity(Entities\Address $address): self
    {
        return $this->state([
            'city_id'     => $address->cityId,
            'street'      => $address->street,
            'number'      => $address->number,
            'district'    => $address->district,
            'postal_code' => $address->postalCode,
            'complement'  => $address->complement,
        ]);
    }
}
