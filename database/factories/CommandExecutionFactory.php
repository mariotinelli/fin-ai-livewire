<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Enums\CommandExecutionStatuses;
use App\Enums\TypeUsers;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\CommandExecution>
 */
class CommandExecutionFactory extends Factory
{
    public function definition(): array
    {
        $commands = [
            'php artisan about',
            'php artisan queue:work --once',
            'php artisan cache:clear',
            'php artisan route:list --path=admin',
            'php artisan config:show app.name',
        ];

        /** @var string $command */
        $command = fake()->randomElement($commands);
        /** @var CommandExecutionStatuses $status */
        $status = fake()->randomElement(CommandExecutionStatuses::cases());

        return [
            'user_id'           => User::factory()->state(['type' => TypeUsers::Admin]),
            'user_name'         => fake()->name(),
            'ip_address'        => fake()->ipv4(),
            'command'           => $command,
            'command_name'      => str($command)->after('php artisan ')->before(' ')->value(),
            'command_arguments' => [],
            'status'            => $status->value,
            'exit_code'         => in_array($status, [CommandExecutionStatuses::Queued, CommandExecutionStatuses::InProgress], true)
                ? null
                : fake()->numberBetween(0, 2),
            'output'      => $status === CommandExecutionStatuses::Queued ? null : fake()->paragraphs(2, true),
            'duration_ms' => in_array($status, [CommandExecutionStatuses::Queued, CommandExecutionStatuses::InProgress], true)
                ? 0
                : fake()->numberBetween(30, 4000),
            'executed_at' => fake()->dateTimeBetween('-7 days'),
        ];
    }
}
