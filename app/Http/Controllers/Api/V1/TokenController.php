<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $user = auth()->user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json(['token' => $token], Response::HTTP_CREATED);
    }
}
