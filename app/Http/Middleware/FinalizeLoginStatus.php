<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class FinalizeLoginStatus
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
        if (!Auth::check()) {
            return $next($request);
        }

        if (!$request->session()->get('login_pending')) {
            return $next($request);
        }

        $user = Auth::user();

        if (empty($user)) {
            return $next($request);
        }

        if ($user->isLogin) {
            $request->session()->forget('login_pending');

            return $next($request);
        }

        $user->session_id = Session::getId();
        $user->isLogin = true;
        $user->last_activity = now();

        try {
            $user->save();
        } catch (\Throwable $e) {
            $user->session_id = null;
            $user->isLogin = false;
            $user->save();

            throw $e;
        }

        $request->session()->forget('login_pending');

        return $next($request);
    }
}
