<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $scope): Response
    {
        if (!$request->user() || !in_array($request->user('sanctum')->role, explode('|', $scope))) {
            return response()->json(['error' => 'Unauthorized', 'redirect' => '/'], 403);
        }
        return $next($request);
    }
}
