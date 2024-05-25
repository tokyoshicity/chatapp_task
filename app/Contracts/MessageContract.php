<?php

namespace App\Contracts;

use App\DTO\MessageData;
use App\Models\Message;

interface MessageContract
{
    public function create(MessageData $data): Message;
}
