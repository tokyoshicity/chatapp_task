<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $latestMessage = $this->latestMessage();

        return [
            'chatId' => $this->id,
            'name' => $this->name,
            'users' => UserResource::collection($this->users),
            'timestamp' => $latestMessage ? $latestMessage->created_at : null,
        ];
    }
}
