<?php

declare(strict_types = 1);

use App\Models\User;
use App\Traits\Policies\CheckIsAdmin;

it('returns true when user is admin', function (): void {
    $policy = new class () {
        use CheckIsAdmin;
    };

    $admin = User::factory()->admin()->create();

    expect($policy->before($admin, 'viewAny'))->toBeTrue();
});

it('returns null when user is not admin', function (): void {
    $policy = new class () {
        use CheckIsAdmin;
    };

    $user = User::factory()->user()->create();

    expect($policy->before($user, 'viewAny'))->toBeNull();
});
