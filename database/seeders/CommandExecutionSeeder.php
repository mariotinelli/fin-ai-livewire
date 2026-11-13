<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Enums\TypeUsers;
use App\Models\CommandExecution;
use App\Models\User;
use Database\Factories\CommandExecutionFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CommandExecutionSeeder extends Seeder
{
    public function run(CommandExecutionFactory $factory): void
    {
        if (applicationEnvironment()->isDeployed()) {
            return;
        }

        DB::transaction(function () use ($factory): void {
            $userIds = User::query()->where('type', TypeUsers::Admin)->pluck('id');

            if ($userIds->isEmpty()) {
                $user = User::factory()->admin()->make(['password' => Str::random(64)]);
                User::query()->insert([$user->updateTimestamps()->getAttributes()]);
                $userIds->push(User::query()->where('email', $user->getAttribute('email'))->sole()->id);
            }

            /** @var Collection<int, CommandExecution> $executions */
            $executions = $factory->count(120)
                ->state(fn (): array => ['user_id' => $userIds->random()])
                ->make();

            $rows = [];

            foreach ($executions as $execution) {
                $rows[] = $execution->updateTimestamps()->getAttributes();
            }

            CommandExecution::query()->insert($rows);
        });
    }
}
