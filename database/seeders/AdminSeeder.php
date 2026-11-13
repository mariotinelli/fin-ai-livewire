<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Enums\TypeUsers;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        if (applicationEnvironment()->isDeployed()) {
            return;
        }

        User::query()->firstOrCreate(['email' => 'team@remsoft.com'], [
            'name'              => 'Remsoft',
            'type'              => TypeUsers::Admin,
            'password'          => '12345678',
            'email_verified_at' => now(),
        ]);

        User::query()->firstOrCreate(['email' => 'suporte@remsoft.com'], [
            'name'              => 'Inova AI',
            'type'              => TypeUsers::SupportRemSoft,
            'password'          => '12345678',
            'email_verified_at' => now(),
        ]);
    }
}
