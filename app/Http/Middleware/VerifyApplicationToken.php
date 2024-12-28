<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyApplicationToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = env('API_TOKEN');
        if ($request->header('token') != $token) {
            return \response()->json([
                'message' => 'Incorrect or empty token provided'
            ], 400);
        }
        return $next($request);
    }
}
