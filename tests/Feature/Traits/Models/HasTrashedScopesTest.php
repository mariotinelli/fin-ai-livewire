<?php

declare(strict_types = 1);

use App\Enums\Status;
use App\Models\User;
use App\Traits\Models\HasTrashedScopes;
use Illuminate\Database\Eloquent\Model;

it('qualifies the deleted timestamp for models without soft delete helpers', function (): void {
    $model = new class () extends Model {
        use HasTrashedScopes;

        protected $table = 'users';
    };

    $query = $model->newQuery()->filterByTrashed(Status::Active);

    expect($query->toSql())->toContain('users', 'deleted_at', 'is null');
});

it('keeps the default active scope when the trash status is absent', function (): void {
    $expectedQuery = User::query()->toSql();

    $filteredQuery = User::query()->filterByTrashed(null)->toSql();

    expect($filteredQuery)->toBe($expectedQuery);
});
