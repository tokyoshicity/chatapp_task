<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\ChatContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Chat\StoreRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
}
