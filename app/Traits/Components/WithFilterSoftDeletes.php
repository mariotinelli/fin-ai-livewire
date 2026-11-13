<?php

declare(strict_types = 1);

namespace App\Traits\Components;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;

/** @template TModel of \Illuminate\Database\Eloquent\Model */
trait WithFilterSoftDeletes
{
    /** @param Builder<TModel> $query */
    #[Scope]
    protected function filterBySoftDeletes(Builder $query, ?bool $withoutTrashed): void
    {
        $query->when($withoutTrashed !== null, function (Builder $query) use ($withoutTrashed) {
            if ($withoutTrashed) {
                return $query->withoutTrashed();
            }

            return $query->onlyTrashed();
        });
    }
}
