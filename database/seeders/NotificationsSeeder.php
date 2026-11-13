<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NotificationsSeeder extends Seeder
{
    public function run(): void
    {
        if (applicationEnvironment()->isDeployed()) {
            return;
        }

        $user = User::query()->firstOrFail();

        $data = [
            [
                'data' => [
                    'title'    => 'Brand Export Completed',
                    'body'     => 'Your brand export has completed and 400 rows exported.',
                    'icon'     => 'document-plus',
                    'redirect' => '#',
                ],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'data' => [
                    'title'    => 'New User Registered',
                    'body'     => 'A new user has been registered.',
                    'icon'     => 'user-group',
                    'redirect' => null,
                ],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'data' => [
                    'title'    => 'New User Registered',
                    'body'     => 'A new user has been registered.',
                    'icon'     => 'user-group',
                    'redirect' => null,
                ],
                'created_at' => now(),
                'updated_at' => now(),
            ]];

        $rows = [];

        foreach ($data as $attributes) {
            $notification = new Notification([
                ...$attributes,
                'id'              => (string) Str::uuid(),
                'type'            => 'demo',
                'notifiable_type' => $user->getMorphClass(),
                'notifiable_id'   => $user->id,
            ]);
            $rows[] = $notification->getAttributes();
        }

        Notification::query()->insert($rows);
    }
}
