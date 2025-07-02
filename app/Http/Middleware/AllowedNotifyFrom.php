<?php

namespace App\Http\Middleware;

use Closure;

class AllowedNotifyFrom
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $ipClient = $request->ip();
        $allowedNotify = \App\Entities\Configuration::select('value')->where('key', 'allowed_notify')->first();

        if (!in_array($ipClient, explode('|', $allowedNotify->value))) {
            return response()->json(['message' => $ipClient . ' is not allowed to send notification.'], 403);
        }

        return $response;
    }
}
