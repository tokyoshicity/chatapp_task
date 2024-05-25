<?php

namespace App\DTO;

use Spatie\LaravelData\Data;

class MessageData extends Data
{
    public int $chatId;

    public int $userId;

    public string $text;
}
