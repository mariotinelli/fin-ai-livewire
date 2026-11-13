<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Role> */
class RoleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'        => $this->faker->unique()->word(),
            'description' => $this->faker->text(),
        ];
    }

    /** @param array<\BackedEnum> $permissions */
    public function withPermissions(array $permissions = []): self
    {
        return $this->afterCreating(function (Role $role) use ($permissions): void {
            $role->givePermissionTo($permissions);
        });
    }
}
