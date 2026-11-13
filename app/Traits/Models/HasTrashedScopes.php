<?php

declare(strict_types = 1);

namespace App\Traits\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

trait HasTrashedScopes
{
    /**
     * @template TModel of \Illuminate\Database\Eloquent\Model
     * @param Builder<TModel> $query
     * @return Builder<TModel>
     */
    #[Scope]
    protected function filterByTrashed(Builder $query, ?Status $status): Builder
    {
        $model           = $query->getModel();
        $deletedAtColumn = method_exists($model, 'getQualifiedDeletedAtColumn')
            ? $model->getQualifiedDeletedAtColumn()
            : $model->qualifyColumn('deleted_at');

        if (!is_string($deletedAtColumn)) {
            throw new \InvalidArgumentException('Coluna de exclusão inválida.');
        }

        return match ($status) {
            Status::All         => $query->withoutGlobalScope(SoftDeletingScope::class),
            Status::Active      => $query->whereNull($deletedAtColumn),
            Status::Deactivated => $query
                ->withoutGlobalScope(SoftDeletingScope::class)
                ->whereNotNull($deletedAtColumn),
            default => $query,
        };
    }
}
