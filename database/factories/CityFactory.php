<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\State;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<\App\Models\City> */
class CityFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'      => $this->faker->city,
            'state_id'  => State::factory(),
            'ibge_code' => $this->faker->word,
        ];
    }
}
