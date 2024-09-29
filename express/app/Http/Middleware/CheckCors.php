<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckCors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Daftar asal yang diizinkan
        $allowedOrigins = ['http://127.0.0.1:8000/'];

        if ($request->header('origin') !== $allowedOrigins) {
            return response()->json([
                'message' => 'Unauthorized',
                'header'=>$request->ip()
        ], 403);
        }

        return $next($request);
    }
}
