<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\IpLog;
class LogIpMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $userId = $user ? $user->id : null;
        $ip = $request->ip();
        $route = $request->path();
        $userAgent = $request->userAgent();

        IpLog::create([
            'user_id' => $userId,
            'ip' => $ip,
            'route' => $route,
            'user_agent' => $userAgent,
        ]);

        return $next($request);
    }
}
