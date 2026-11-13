<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use App\Models\BaseModel;
use App\Models\User;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseSearchController extends Controller
{
    private const int MAX_SELECTED_OPTIONS = 100;

    /**
     * @param Builder<covariant BaseModel|User> $query
     * @param null|Closure(Builder<covariant BaseModel|User>, string): mixed $searchCallback Restringe a busca em um grupo AND; o retorno é ignorado.
     * @return LengthAwarePaginator<int, BaseModel|User>
     */
    protected function getOptions(
        Builder $query,
        SearchRequest $request,
        string $searchColumn = 'name',
        ?Closure $searchCallback = null,
    ): LengthAwarePaginator {
        /** @var list<int|string> $selected */
        $selected = $request->validated('selected', []);
        /** @var string $selectedColumn */
        $selectedColumn = $request->validated('selectedColumn', 'id');
        $search         = $request->validated('search');

        if (is_string($search) && $search !== '') {
            if ($searchCallback instanceof Closure) {
                $query->where(function (Builder $searchQuery) use ($searchCallback, $search): void {
                    $searchCallback($searchQuery, $search);
                });
            } else {
                $query->whereInsensitive($searchColumn, $search);
            }
        }

        $query->orderBy($searchColumn)->orderBy('id');
        $options = (clone $query)->whereNotIn($selectedColumn, $selected)->paginate(10)->withQueryString();

        if ($selected !== [] && !$request->has('page')) {
            $selectedOptions = $this->selectedOptions($query, $selectedColumn, $selected);
            $options->setCollection($selectedOptions->toBase()->concat($options->getCollection()));
        }

        return $options;
    }

    /**
     * @param Builder<covariant BaseModel|User> $query
     * @param list<int|string> $selected
     * @return Collection<int, BaseModel|User>
     */
    private function selectedOptions(Builder $query, string $selectedColumn, array $selected): Collection
    {
        $model = $query->getModel();
        $key   = $model->getQualifiedKeyName();

        if ($selectedColumn === $model->getKeyName()) {
            return (clone $query)->whereIn($key, $selected)->limit(self::MAX_SELECTED_OPTIONS)->get();
        }

        $column  = $model->qualifyColumn($selectedColumn);
        $grammar = $query->getQuery()->getGrammar();
        /** @var literal-string&non-falsy-string $aggregate The key identifier is quoted by the query grammar. */
        $aggregate   = 'MIN(' . $grammar->wrap($key) . ')';
        $selectedIds = (clone $query)
            ->reorder()
            ->select([])
            ->selectRaw($aggregate)
            ->whereIn($column, $selected)
            ->groupBy($column)
            ->limit(self::MAX_SELECTED_OPTIONS);

        return (clone $query)->whereIn($key, $selectedIds)->limit(self::MAX_SELECTED_OPTIONS)->get();
    }
}
