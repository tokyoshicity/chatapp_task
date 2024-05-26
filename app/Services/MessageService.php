<?php

namespace App\Services;

use App\Contracts\MessageContract;
use App\DTO\MessageData;
use App\Exceptions\ChatNotFoundException;
use App\Factories\MessageFactory;
use App\Models\Chat;
use App\Models\Message;

class MessageService implements MessageContract
{
    /**
     * @throws ChatNotFoundException
     */
    public function create(MessageData $data): Message
    {
        if (! Chat::query()->find($data->chatId)) {
            throw new ChatNotFoundException();
        }

        return MessageFactory::create($data);
    }
}
