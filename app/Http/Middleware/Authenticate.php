<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    use ApiResponseHelpers;
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('login');
        }
    }

    protected function unauthenticated($request, array $guards): JsonResponse
    {
        abort($this->respondUnAuthenticated("Unauthenticated, please login first"));
    }
}
