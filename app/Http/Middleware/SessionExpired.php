<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Concerns\AuthenticatesUsers;

class SessionExpired
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = \Modules\User\Entities\User::findByUsername(auth()->user()->username);
            $lastActivity = session('last_activity', time());
            $sessionTimeout = config('session.lifetime') * 60; // waktu timeout dalam detik

            
            if (time() - $lastActivity >= $sessionTimeout) {
                $request->session()->flush();
            } else {
                session(['last_activity' => time()]);
            }
        }

        return $next($request);
    }
}