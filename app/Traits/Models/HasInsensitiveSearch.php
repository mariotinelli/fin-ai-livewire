<?php

declare(strict_types = 1);

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;

trait HasInsensitiveSearch
{
    /** @param Builder<static> $query */
    #[Scope]
    protected function whereInsensitive(Builder $query, string $column, string $search): void
    {
        $this->applyInsensitiveSearch($query, $column, $search, 'and');
    }

    /** @param Builder<static> $query */
    #[Scope]
    protected function orWhereInsensitive(Builder $query, string $column, string $search): void
    {
        $this->applyInsensitiveSearch($query, $column, $search, 'or');
    }

    /** @param Builder<static> $query */
    private function applyInsensitiveSearch(Builder $query, string $column, string $search, string $boolean): void
    {
        $column  = $query->getGrammar()->wrap($query->qualifyColumn($column));
        $pattern = '%' . str_replace(['!', '%', '_'], ['!!', '!%', '!_'], $search) . '%';

        /**
         * Identifiers are quoted by the grammar; search values remain bound separately.
         * @var literal-string&non-falsy-string $sql
         */
        $sql = 'unaccent(CAST(' . $column . ' AS text) COLLATE "default") ILIKE unaccent(?) ESCAPE \'!\'';

        $query->whereRaw(
            $sql,
            [$pattern],
            $boolean,
        );
    }
}
