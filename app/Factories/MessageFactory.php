<?php

namespace App\Factories;

use App\DTO\MessageData;
use App\Models\Message;

class MessageFactory
{
    public static function create(MessageData $data): Message
    {
        return Message::create([
            'user_id' => $data->userId,
            'chat_id' => $data->chatId,
            'body' => $data->body,
        ]);
    }
}
