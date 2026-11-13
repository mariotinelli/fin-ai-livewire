<?php

declare(strict_types = 1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

/** @extends Factory<\App\Models\Media> */
class MediaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'          => fake()->word(),
            'original_name' => fake()->word(),
            'collection'    => fake()->word(),
            'type'          => fake()->randomElement(['png', 'jpeg', 'jpg']),
            'disk'          => fake()->randomElement(['local', 's3']),
            'size'          => fake()->numberBetween(100, 1000),
        ];
    }

    public function entity(Model $model): self
    {
        return $this->state(fn (): array => [
            'entity_id'   => $model->getKey(),
            'entity_type' => $model->getMorphClass(),
        ]);
    }

    public function documents(): self
    {
        return $this->state(fn (): array => [
            'name'       => uniqid() . '.' . 'png',
            'collection' => 'documents',
            'disk'       => config('filesystems.default'),
            'type'       => 'png',
        ]);
    }
}
