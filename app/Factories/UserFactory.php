<?php

namespace App\Factories;

use App\DTO\UserData;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserFactory
{
    public static function create(UserData $data): User
    {
        return User::create([
            'first_name' => $data->firstName,
            'last_name' => $data->lastName,
            'email' => $data->email,
            'password' => Hash::make($data->password),
        ]);
    }
}
