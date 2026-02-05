<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class DelayMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $delay = rand(5, 10);
        Log::info("[LAPTOP 2] Delay {$delay}s");
        sleep($delay);
        return $next($request);
    }
}
