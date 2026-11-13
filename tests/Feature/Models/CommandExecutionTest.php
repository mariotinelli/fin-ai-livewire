<?php

declare(strict_types = 1);

use App\Models\CommandExecution;
use Illuminate\Support\Facades\DB;

it('redacts command arguments and output before persistence', function (): void {
    $execution = CommandExecution::factory()->create([
        'command'           => 'example --password=canary',
        'command_arguments' => ['--password', 'canary'],
        'output'            => "OK\npassword=canary",
    ]);

    $stored = (array) DB::table('command_executions')->find($execution->id);

    expect($stored['command'])->not->toContain('canary');
    expect($stored['command_arguments'])->not->toContain('canary');
    expect($stored['output'])->toBe("OK\n[REDACTED]");
    expect($execution->refresh()->command_arguments)->toBe(['[REDACTED]']);
});

it('protects legacy records when read or serialized', function (): void {
    $execution = CommandExecution::factory()->create();
    DB::table('command_executions')->where('id', $execution->id)->update([
        'command'           => 'example --token canary',
        'command_arguments' => '["--token","canary"]',
        'output'            => 'Authorization: Bearer canary',
    ]);

    expect(json_encode($execution->fresh()->toArray(), JSON_THROW_ON_ERROR))->not->toContain('canary');
});

it('preserves safe arguments nullable output and the initiating user', function (): void {
    $execution = CommandExecution::factory()->create([
        'command'           => 'php artisan about --only=environment',
        'command_arguments' => ['--only=environment'], 'output' => null,
    ])->refresh();

    expect($execution->command_arguments)->toBe(['--only=environment'])
        ->and($execution->output)->toBeNull()
        ->and($execution->user?->id)->toBe($execution->user_id);
});

it('preserves absent legacy command arguments', function (): void {
    $execution = CommandExecution::factory()->create(['command_arguments' => null]);

    expect($execution->refresh()->command_arguments)->toBeNull();
});
