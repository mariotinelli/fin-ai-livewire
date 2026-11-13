<?php

declare(strict_types = 1);

use App\Enums\TypeUsers;
use App\Models\CommandExecution;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

it('allows only support to inspect and create command executions', function (TypeUsers $type, bool $expected): void {
    $actor     = User::factory()->create(['type' => $type]);
    $execution = CommandExecution::factory()->create();

    expect(Gate::forUser($actor)->allows('viewAny', CommandExecution::class))->toBe($expected)
        ->and(Gate::forUser($actor)->allows('view', $execution))->toBe($expected)
        ->and(Gate::forUser($actor)->allows('create', CommandExecution::class))->toBe($expected);
})->with([
    'administrator' => [TypeUsers::Admin, false],
    'common user'   => [TypeUsers::User, false],
    'customer'      => [TypeUsers::Customer, false],
    'support'       => [TypeUsers::SupportRemSoft, true],
]);
