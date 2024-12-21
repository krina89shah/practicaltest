<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Log;

class LogRequestTime
{
    
    public function handle($request, Closure $next) {
        $start = microtime(true);
        $response = $next($request);
        $end = microtime(true);
        Log::info('Request time: ' . ($end - $start) . ' seconds');
        return $response;
    }
    
}
