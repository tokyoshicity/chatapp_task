<?php

namespace App\Contracts;

use App\Http\Requests\Api\V1\Chat\StoreRequest;
use App\Models\Chat;

interface ChatContract
{
    public function create(StoreRequest $request): Chat;
}
