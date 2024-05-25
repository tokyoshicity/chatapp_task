<?php

namespace App\DTO;

use Spatie\LaravelData\Data;

class ChatData extends Data
{
    public int $ownerId;

    public int $userId;

    public ?string $name;
}
