<?php

namespace App\Contracts;

use App\DTO\UserData;
use App\Models\User;

interface UserContract
{
    public function create(UserData $data): User;
}
