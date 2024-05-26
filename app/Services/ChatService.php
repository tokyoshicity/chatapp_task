<?php

namespace App\Services;

use App\Contracts\ChatContract;
use App\DTO\ChatData;
use App\Exceptions\UserNotFoundException;
use App\Factories\ChatFactory;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ChatService implements ChatContract
{
    /**
     * @throws UserNotFoundException
     */
    public function create(ChatData $data): Chat
    {
        try {
            $newChatUser = User::query()->findOrFail($data->userId);
        } catch (ModelNotFoundException $e) {
            throw new UserNotFoundException();
        }

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
