<?php

namespace App\Factories;

use App\DTO\ChatData;
use App\Models\Chat;

class ChatFactory
{
    public static function create(ChatData $data): Chat
    {
        return Chat::create([
            'user_id' => $data->userId,
            'name' => $data->name,
        ]);
    }
}
