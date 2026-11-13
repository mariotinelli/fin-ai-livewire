<?php

declare(strict_types = 1);

use App\Models\User;
use App\Traits\Components\WithFilterSoftDeletes;
use Illuminate\Database\Eloquent\Builder;

it('filters active or deleted records and leaves null filters unchanged', function (): void {
    $active  = User::factory()->create();
    $deleted = User::factory()->create();
    $deleted->delete();

    $filter = new class () {
        /** @use WithFilterSoftDeletes<User> */
        use WithFilterSoftDeletes;

        /** @param Builder<User> $query */
        public function apply(Builder $query, ?bool $withoutTrashed): void
        {
            $this->filterBySoftDeletes($query, $withoutTrashed);
        }
    };

    $activeQuery = User::query();
    $filter->apply($activeQuery, true);
    $deletedQuery = User::query();
    $filter->apply($deletedQuery, false);
    $allQuery = User::withTrashed();
    $filter->apply($allQuery, null);

    expect($activeQuery->pluck('id')->all())->toBe([$active->id])
        ->and($deletedQuery->pluck('id')->all())->toBe([$deleted->id])
        ->and($allQuery->pluck('id')->all())->toContain($active->id, $deleted->id);
});
