<?php

namespace App\Traits;

use App\Http\Requests\IndexRequest;
use Illuminate\Database\Eloquent\Builder;

trait Paginates
{
    public function paginate(Builder $query, IndexRequest $request): Builder
    {
        $page = $request->validated('page') ?: 1;

        return $query->forPage($page, 20);
    }
}
