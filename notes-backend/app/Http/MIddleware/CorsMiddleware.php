<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CorsMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $frontendUrl = env('FRONTEND_URL', 'http://localhost:5173');
        $defaultFrontendUrls = $frontendUrl . ',http://127.0.0.1:5173,http://localhost';
        $allowed = array_filter(array_map('trim', explode(',', env('FRONTEND_URLS', $defaultFrontendUrls))));
        $origin = $request->headers->get('Origin');
        $allowOrigin = $origin && in_array($origin, $allowed, true) ? $origin : ($allowed[0] ?? $frontendUrl);

        if ($request->getMethod() === 'OPTIONS') {
            $response = response()->json([], 204);
        } else {
            $response = $next($request);
        }

        $response->headers->set('Access-Control-Allow-Origin', $allowOrigin);
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
        $response->headers->set('Vary', 'Origin');

        return $response;
    }
}
