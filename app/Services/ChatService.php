<?php

namespace App\Services;

use App\Contracts\ChatContract;
use App\DTO\ChatData;
use App\Factories\ChatFactory;
use App\Http\Requests\Api\V1\Chat\StoreRequest;
use App\Models\Chat;
use App\Models\User;

class ChatService implements ChatContract
{
    public function create(StoreRequest $request): Chat
    {
        $owner = auth()->user();
        $data = ChatData::from($request);

        $newChatUser = User::query()->findOrFail($data->userId);

        $data->userId = $owner->id;
        $data->name = $newChatUser->fullname;

        $chat = ChatFactory::create($data);

        $this->addUserToChat($chat, $newChatUser);

        return $chat;
    }

    private function addUserToChat(Chat $chat, User $user): void
    {
        $chat->users()->attach($user);
    }
}
