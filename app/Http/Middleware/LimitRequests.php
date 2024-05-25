<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class LimitRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $maxAttempts = 10, $decaySeconds = 1): Response
    {
        $key = $request->ip();

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            return response()->json([
                'message' => 'Too many requests. Please try again later.',
            ], Response::HTTP_TOO_MANY_REQUESTS);
        }

        RateLimiter::hit($key, $decaySeconds);

        $response = $next($request);

        $response->header('X-RateLimit-Limit', $maxAttempts);
        $response->header('X-RateLimit-Remaining', RateLimiter::retriesLeft($key, $maxAttempts));

        return $response;
    }
}
