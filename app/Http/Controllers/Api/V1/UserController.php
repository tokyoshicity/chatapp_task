<?php

namespace App\Http\Controllers\Api\V1;

use App\DTO\UserData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\User\StoreRequest;
use App\Http\Resources\Api\V1\UserResource;
use App\Models\User;
use App\Services\UserService;
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

class UserController extends Controller
{
    use Paginates;

    #[Header('Authorization', 'Bearer ')]
    #[Endpoint('Get a list of users', authenticated: true)]
    #[QueryParam('page', 'integer', required: false)]
    #[ApiResponse([
        [
            'userId' => 1,
            'email' => 'test@gmail.com',
            'firstName' => 'Foo',
            'lastName' => 'Bar',
        ],
    ], Response::HTTP_OK, 'Success')]
    #[ApiResponse([
        'message' => 'Unauthenticated.',
    ], Response::HTTP_UNAUTHORIZED, 'No access token provided')]
    #[Group('Users')]
    public function index(Request $request): AnonymousResourceCollection
    {
        $users = $this->paginate(User::query(), $request)
            ->get();

        return UserResource::collection($users);
    }

    #[Endpoint('Create a user')]
    #[BodyParam('firstName', 'string', example: 'Foo')]
    #[BodyParam('lastName', 'string', example: 'Bar')]
    #[BodyParam('email', 'string', example: 'test@gmail.com')]
    #[BodyParam('password', 'string', example: 'password')]
    #[ApiResponse([
        'id' => 1,
    ], Response::HTTP_CREATED, 'Success')]
    #[ApiResponse([
        'message' => 'Unauthenticated.',
    ], Response::HTTP_UNPROCESSABLE_ENTITY, 'User with given email already exists')]
    #[Group('Users')]
    public function store(UserService $userService, StoreRequest $request): JsonResponse
    {
        $data = UserData::from($request);
        $user = $userService->create($data);

        return response()
            ->json(['id' => $user->id], Response::HTTP_CREATED);
    }
}
