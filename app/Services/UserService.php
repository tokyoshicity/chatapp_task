<?php

namespace App\Services;

use App\Contracts\UserContract;
use App\DTO\UserData;
use App\Factories\UserFactory;
use App\Models\User;

class UserService implements UserContract
{
    public function create(UserData $data): User
    {
        return UserFactory::create($data);
    }
}
