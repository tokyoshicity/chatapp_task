<?php

namespace App\Http\Controllers\Api\V1;

use App\DTO\UserData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\User\StoreRequest;
use App\Http\Requests\IndexRequest;
use App\Http\Resources\Api\V1\UserResource;
use App\Models\User;
use App\Services\UserService;
use App\Traits\Paginates;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    use Paginates;

    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request): AnonymousResourceCollection
    {
        $users = $this->paginate(User::query(), $request)
            ->get();

        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserService $userService, StoreRequest $request): JsonResponse
    {
        $data = UserData::from($request);
        $user = $userService->create($data);

        return response()
            ->json(['id' => $user->id], Response::HTTP_CREATED);
    }
}
