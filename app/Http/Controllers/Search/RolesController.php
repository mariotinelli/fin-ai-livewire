<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Search;

use App\Http\Requests\SearchRequest;
use App\Http\Resources\Search\RoleResource;
use App\Models\Role;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RolesController extends BaseSearchController
{
    public function __invoke(SearchRequest $request): AnonymousResourceCollection
    {
        return RoleResource::collection($this->getOptions(Role::query(), $request));
    }
}
