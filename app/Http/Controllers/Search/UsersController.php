<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Search;

use App\Enums\TypeUsers;
use App\Http\Requests\SearchRequest;
use App\Http\Resources\Search\UserResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UsersController extends BaseSearchController
{
    public function __invoke(SearchRequest $request): AnonymousResourceCollection
    {
        return UserResource::collection($this->getOptions(User::query()->where('type', TypeUsers::User), $request));
    }
}
