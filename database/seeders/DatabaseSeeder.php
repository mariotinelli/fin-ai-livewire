<?php

declare(strict_types = 1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (applicationEnvironment()->isDeployed()) {
            $this->call([ProductionSeeder::class]);

            return;
        }

        $this->call([
            PermissionSeeder::class,
            AdminSeeder::class,
            RegionSeeder::class,
            StateSeeder::class,
            CitySeeder::class,
            CommandExecutionSeeder::class,
        ]);
    }
}
