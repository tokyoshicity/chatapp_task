<?php

namespace App\Http\Controllers\Api\V1;

use App\DTO\ChatData;
use App\Exceptions\UserNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Chat\StoreRequest;
use App\Http\Resources\Api\V1\ChatResource;
use App\Models\Chat;
use App\Models\Message;
use App\Services\ChatService;
use App\Traits\Paginates;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Header;
use Knuckles\Scribe\Attributes\QueryParam;
use Knuckles\Scribe\Attributes\Response as ApiResponse;
use Symfony\Component\HttpFoundation\Response;

class ChatController extends Controller
{
    use Paginates;

    #[Header('Authorization', 'Bearer ')]
    #[Endpoint('Get a list of chats', authenticated: true)]
    #[QueryParam('page', 'integer', required: false)]
    #[ApiResponse([
        [
            'chatId' => 1,
            'name' => 'Foo Bar',
            'users' => [
                'userId' => 1,
                'email' => 'test@gmail.com',
                'firstName' => 'Foo',
                'lastName' => 'Bar',
            ],
            'timestamp' => '24.05.2024 12:00:00',
        ],
    ], Response::HTTP_OK, 'Success')]
    #[ApiResponse([
        'message' => 'Unauthenticated.',
    ], Response::HTTP_UNAUTHORIZED, 'No access token provided')]
    #[Group('Chats')]
    public function index(Request $request): AnonymousResourceCollection
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
     * @throws UserNotFoundException
     */
    #[Header('Authorization', 'Bearer ')]
    #[Endpoint('Create a new chat with user', authenticated: true)]
    #[BodyParam('userId', 'integer', required: true)]
    #[ApiResponse([
        'id' => 1,
    ], Response::HTTP_OK, 'Success')]
    #[ApiResponse([
        'message' => 'Unauthenticated.',
    ], Response::HTTP_UNAUTHORIZED, 'No access token provided')]
    #[Group('Chats')]
    public function store(ChatService $chatService, StoreRequest $request): JsonResponse
    {
        $data = ChatData::from([
            'ownerId' => auth()->user()->id,
            'userId' => $request->validated('userId'),
        ]);
        $chat = $chatService->create($data);

        return response()
            ->json(['id' => $chat->id], Response::HTTP_CREATED);
    }
}
