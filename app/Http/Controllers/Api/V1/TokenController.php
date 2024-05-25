<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Header;
use Knuckles\Scribe\Attributes\Response as ApiResponse;
use Symfony\Component\HttpFoundation\Response;

class TokenController extends Controller
{
    #[Header('Authorization', 'Basic ')]
    #[Endpoint('Receive access token', authenticated: true)]
    #[ApiResponse([
        'token' => 'token',
    ], Response::HTTP_CREATED)]
    #[ApiResponse([
        'message' => 'Invalid credentials.',
    ], Response::HTTP_UNAUTHORIZED)]
    public function store(Request $request): JsonResponse
    {
        $user = auth()->user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json(['token' => $token], Response::HTTP_CREATED);
    }
}
