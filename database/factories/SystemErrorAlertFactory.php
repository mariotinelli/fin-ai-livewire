<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Enums\SystemErrorAlertSeverities;
use App\Enums\SystemErrorAlertStatuses;
use App\Models\SystemErrorAlert;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SystemErrorAlert>
 */
class SystemErrorAlertFactory extends Factory
{
    public function definition(): array
    {
        return [
            'fingerprint'      => hash('sha256', fake()->uuid()),
            'status'           => SystemErrorAlertStatuses::Open,
            'severity'         => fake()->randomElement(SystemErrorAlertSeverities::cases()),
            'environment'      => fake()->randomElement(['production', 'staging', 'qa']),
            'exception_class'  => 'RuntimeException',
            'message'          => fake()->sentence(),
            'file'             => 'app/Services/PaymentService.php',
            'line'             => fake()->numberBetween(10, 300),
            'route_name'       => 'admin.support.system-error-alerts.index',
            'request_method'   => fake()->randomElement(['GET', 'POST']),
            'request_url'      => fake()->url(),
            'request_id'       => fake()->uuid(),
            'user_id'          => null,
            'context'          => ['sample' => 'value'],
            'trace'            => fake()->text(300),
            'occurrences'      => fake()->numberBetween(1, 5),
            'first_seen_at'    => now()->subHour(),
            'last_seen_at'     => now(),
            'last_notified_at' => now()->subMinutes(10),
        ];
    }
}
