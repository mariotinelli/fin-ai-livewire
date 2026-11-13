<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Enums\TypeUsers;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/** @extends Factory<\App\Models\User> */
class UserFactory extends Factory
{
    protected static ?string $password = null;

    public function definition(): array
    {
        return [
            'role_id'           => Role::factory(),
            'name'              => fake()->firstName() . ' ' . fake()->lastName(),
            'type'              => fake()->randomElement(TypeUsers::cases()),
            'email'             => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password'          => static::$password ??= '12345678',
            'remember_token'    => Str::random(10),
        ];
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes): array => [
            'role_id' => null,
            'type'    => TypeUsers::Admin,
        ]);
    }

    public function user(): static
    {
        return $this->state(fn (array $attributes): array => [
            'type' => TypeUsers::User,
        ]);
    }

    public function customer(): static
    {
        return $this->state(fn (array $attributes): array => [
            'type' => TypeUsers::Customer,
        ]);
    }
}
