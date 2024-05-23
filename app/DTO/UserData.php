<?php

namespace App\DTO;

use Spatie\LaravelData\Data;

class UserData extends Data
{
    public string $firstName;
    public string $lastName;
    public string $email;
    public string $password;
}
