<?php

namespace App\Http\Controllers\Api\V1;

use App\DTO\MessageData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Message\StoreRequest;
use App\Http\Resources\Api\V1\MessageResource;
use App\Models\Message;
use App\Services\MessageService;
use App\Traits\Paginates;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Header;
use Knuckles\Scribe\Attributes\QueryParam;
use Knuckles\Scribe\Attributes\Response as ApiResponse;
use Symfony\Component\HttpFoundation\Response;

class MessageController extends Controller
{
    use Paginates;

    #[Header('Authorization', 'Bearer ')]
    #[Endpoint('Get a list of messages for chat', authenticated: true)]
    #[QueryParam('page', 'integer', required: false)]
    #[ApiResponse([
        [
            'messageId' => 1,
            'timestamp' => '24.05.2024 12:00:00',
            'text' => 'foo bar',
        ],
    ], Response::HTTP_OK, 'Success')]
    #[ApiResponse([
        'message' => 'Unauthenticated.',
    ], Response::HTTP_UNAUTHORIZED, 'No access token provided')]
    #[Group('Messages')]
    public function index(int $chatId, Request $request): AnonymousResourceCollection
    {
        $messages = Message::query()
            ->where('chat_id', $chatId)
            ->latest();

        $messages = $this->paginate($messages, $request)
            ->get();

        return MessageResource::collection($messages);
    }

    #[Header('Authorization', 'Bearer ')]
    #[Endpoint('Create a message for chat', authenticated: true)]
    #[BodyParam('text', 'string', required: true)]
    #[ApiResponse([
        'id' => 1,
    ], Response::HTTP_OK, 'Success')]
    #[ApiResponse([
        'message' => 'Unauthenticated.',
    ], Response::HTTP_UNAUTHORIZED, 'No access token provided')]
    #[Group('Messages')]
    public function store(int $chatId, MessageService $messageService, StoreRequest $request): JsonResponse
    {
        $data = MessageData::from([
            'chatId' => $chatId,
            'userId' => auth()->user()->id,
            'text' => $request->validated('text'),
        ]);
        $message = $messageService->create($data);

        return response()
            ->json(['id' => $message->id], Response::HTTP_CREATED);
    }
}
