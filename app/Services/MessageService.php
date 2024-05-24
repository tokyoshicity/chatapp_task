<?php

namespace App\Services;

use App\Contracts\MessageContract;
use App\DTO\MessageData;
use App\Factories\MessageFactory;
use App\Models\Message;

class MessageService implements MessageContract
{
    public function create(MessageData $data): Message
    {
        return MessageFactory::create($data);
    }
}
