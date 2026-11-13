<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\Region;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<\App\Models\State> */
class StateFactory extends Factory
{
    public function definition(): array
    {
        /** @var array{name: string, initials: string} $state */
        $state = fake()->randomElement([
            ['name' => 'Acre', 'initials' => 'AC'],
            ['name' => 'Rio de Janeiro', 'initials' => 'RJ'],
            ['name' => 'Amazonas', 'initials' => 'AM'],
        ]);

        return [
            'name'      => $state['name'],
            'initials'  => $state['initials'],
            'region_id' => Region::factory(),
        ];
    }
}
