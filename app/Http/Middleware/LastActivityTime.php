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
        // dd(config('app.auto_logout'));
        $waktu_idle = (int) config('app.auto_logout');   //ambil dari mst_configuration
        $now = now();
        
        if(Auth::check()){
            $user = \Modules\User\Entities\User::findByUsername(auth()->user()->username);
            $idle = $now->diffInMinutes($user->last_activity);
            // dd($idle, $waktu_idle, $idle >= $waktu_idle, Auth::check(), 'lastActivity');
            if($idle >= $waktu_idle){
                // dd('a','lastActivity');
                $this->clearSessionId();
                $this->guard()->logout();
                $request->session()->flush();

                return $this->loggedOut($request) ?: redirect('/');
            } else if($user->isLogin == false){
                // dd('b', 'lastActivity');
                $this->clearSessionId();
                $this->guard()->logout();
                $request->session()->flush();

                return $this->loggedOut($request) ?: redirect('/');
            } else {
                // dd('c', 'lastActivity');
                $user->last_activity = now();
                $user->update();
            }
        }
        
        return $next($request);
    }
}