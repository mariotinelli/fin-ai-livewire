<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<\App\Models\Notification> */
class NotificationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'data'    => [
                'title'    => $this->faker->sentence,
                'body'     => $this->faker->paragraph,
                'icon'     => $this->faker->randomElement(['user', 'bell']),
                'redirect' => $this->faker->url,
            ],
            'read_at'   => null,
            'viewed_at' => null,
        ];
    }

    public function read(): self
    {
        return $this->state(fn (): array => ['read_at' => now()]);
    }

    public function viewed(): self
    {
        return $this->state(fn (): array => ['viewed_at' => now()]);
    }
}
