<?php

declare(strict_types = 1);

use App\Enums\TypeUsers;
use App\Models\SystemErrorAlert;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

it('allows only rem soft support to inspect and update system error alerts', function (TypeUsers $type, bool $expected): void {
    $actor = User::factory()->create(['type' => $type]);
    $alert = SystemErrorAlert::factory()->create();

    expect(Gate::forUser($actor)->allows('viewAny', SystemErrorAlert::class))->toBe($expected)
        ->and(Gate::forUser($actor)->allows('view', $alert))->toBe($expected)
        ->and(Gate::forUser($actor)->allows('update', $alert))->toBe($expected);
})->with([
    'administrator' => [TypeUsers::Admin, false],
    'common user'   => [TypeUsers::User, false],
    'customer'      => [TypeUsers::Customer, false],
    'support'       => [TypeUsers::SupportRemSoft, true],
]);
