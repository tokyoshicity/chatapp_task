<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\ChatContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Chat\StoreRequest;
use App\Http\Requests\IndexRequest;
use App\Http\Resources\Api\V1\ChatResource;
use App\Models\Chat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request): AnonymousResourceCollection
    {
        $chats = Chat::with('messages')
            ->get()
            ->sortByDesc(function ($chat) {
                return $chat->latestMessage() ? $chat->latestMessage()->created_at : null;
            })
            ->values()
            ->forPage($request->validated('page') ?: 1, 20);

        return ChatResource::collection($chats);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $chatService = app(ChatContract::class);
        $chat = $chatService->create($request);

        return response()
            ->json(['id' => $chat->id], Response::HTTP_CREATED);
    }
}
