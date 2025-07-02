<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Concerns\AuthenticatesUsers;

class LastActivityTime
{
    use AuthenticatesUsers;
    
    public function handle($request, Closure $next)
    {
        $waktu_idle = 30;   //waktu maksimal idle dalam menit
        $now = now();
        
        if(Auth::check()){
            $user = \Modules\User\Entities\User::findByUsername(auth()->user()->username);
            $idle = $now->diffInMinutes($user->last_activity);
            
            if($idle >= $waktu_idle){
                // dd('kesini');
                $this->clearSessionId();
                $this->guard()->logout();
                $request->session()->flush();

                return $this->loggedOut($request) ?: redirect('/');
            } else if($user->isLogin == false){
                $this->clearSessionId();
                $this->guard()->logout();
                $request->session()->flush();

                return $this->loggedOut($request) ?: redirect('/');
            } else {
                $user->last_activity = now();
                $user->update();
            }
        }
        
        return $next($request);
    }
}