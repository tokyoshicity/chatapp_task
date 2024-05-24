<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Chat\StoreRequest;
use App\Http\Requests\IndexRequest;
use App\Http\Resources\Api\V1\ChatResource;
use App\Models\Chat;
use App\Models\Message;
use App\Services\ChatService;
use App\Traits\Paginates;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ChatController extends Controller
{
    use Paginates;

    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request): AnonymousResourceCollection
    {
        $chats = Chat::query()
            ->select()
            ->addSelect([
                'latest_message' => Message::query()
                    ->select(DB::raw('MAX(created_at)'))
                    ->whereColumn('messages.chat_id', 'chats.id'),
            ])
            ->orderBy('latest_message', 'desc');

        $chats = $this->paginate($chats, $request)
            ->get();

        return ChatResource::collection($chats);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ChatService $chatService, StoreRequest $request): JsonResponse
    {
        $chat = $chatService->create($request);

        return response()
            ->json(['id' => $chat->id], Response::HTTP_CREATED);
    }
}
