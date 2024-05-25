<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait Paginates
{
    public function paginate(Builder $query, Request $request): Builder
    {
        $page = $request->query('page', 1);

        return $query->forPage($page, 20);
    }
}
