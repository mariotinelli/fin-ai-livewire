<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Enums\TypeUsers;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class ProductionAdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function (): void {
            $accounts = [
                'admin'   => ['email' => 'team@remsoft.com', 'name' => 'Remsoft', 'type' => TypeUsers::Admin],
                'support' => ['email' => 'suporte@remsoft.com', 'name' => 'Suporte', 'type' => TypeUsers::SupportRemSoft],
            ];

            foreach ($accounts as $key => $account) {
                if (User::withTrashed()->where('email', $account['email'])->exists()) {
                    continue;
                }

                $password = config("provisioning.{$key}_password");

                if (!is_string($password) || strlen(trim($password)) < 16 || strlen($password) > 72 || str_contains($password, "\0")) {
                    throw new RuntimeException("Configure provisioning.{$key}_password com um segredo externo de 16 a 72 bytes, sem bytes nulos, antes de criar a conta de produção.");
                }

                User::withTrashed()->firstOrCreate(['email' => $account['email']], [
                    'name'              => $account['name'],
                    'type'              => $account['type'],
                    'password'          => $password,
                    'email_verified_at' => now(),
                ]);
            }
        });
    }
}
