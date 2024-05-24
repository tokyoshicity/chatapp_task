<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\MessageContract;
use App\DTO\MessageData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Message\StoreRequest;
use App\Http\Requests\IndexRequest;
use App\Http\Resources\Api\V1\MessageResource;
use App\Models\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(int $chatId, IndexRequest $request): AnonymousResourceCollection
    {
        $messages = Message::query()
            ->where('chat_id', $chatId)
            ->latest()
            ->simplePaginate(20);

        return MessageResource::collection($messages);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(int $chatId, StoreRequest $request): JsonResponse
    {
        $data = MessageData::from([
            'chatId' => $chatId,
            'userId' => auth()->user()->id,
            'body' => $request->validated('body'),
        ]);
        $messageService = app(MessageContract::class);
        $message = $messageService->create($data);

        return response()
            ->json(['id' => $message->id], Response::HTTP_CREATED);
    }
}
