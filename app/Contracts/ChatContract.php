<?php

namespace App\Contracts;

use App\DTO\ChatData;
use App\Models\Chat;

interface ChatContract
{
    public function create(ChatData $data): Chat;
}
