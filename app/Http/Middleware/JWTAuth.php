<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class JWTAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            \Tymon\JWTAuth\Facades\JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            if ($e instanceof TokenInvalidException) {
                return response()->json([
                    'message' => 'Innvaild Token'
                ]);
            } elseif ($e instanceof TokenExpiredException) {
                return response()->json([
                    'message' => 'Token is Expired'
                ]);
            } else {
                return response()->json([
                    'message' => 'Unauthorized'
                ]);
            }
        }
        return $next($request);
    }
}
