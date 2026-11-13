<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Search;

use App\Http\Requests\SearchRequest;
use App\Http\Resources\Search\StateResource;
use App\Models\State;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class StatesController extends BaseSearchController
{
    public function __invoke(SearchRequest $request): AnonymousResourceCollection
    {
        return StateResource::collection($this->getOptions(State::query(), $request));
    }
}
