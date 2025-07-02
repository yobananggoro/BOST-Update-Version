<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Spatie\Activitylog\Contracts\Activity;

class LogSuccessfulLogout
{
    /**
    * Create the event listener.
    *
    * @return void
    */
    public function __construct()
    {
        //
    }
    
    /**
    * Handle the event.
    *
    * @param  Logout  $event
    * @return void
    */
    public function handle(Logout $event)
    {
        // dd(isset($event->user->username));
        if(isset($event->user->username)){
            $user = \Modules\User\Entities\User::where('username', $event->user->username)->first();
            
            activity()
            ->performedOn($user)
            ->causedBy($event->user->id)
            ->tap(function (Activity $activity) {
                $activity->ip_address = request()->getClientIp();
                $activity->user_agent = request()->userAgent();
                $activity->uri = request()->fullUrl();
            })
            ->log($event->user->username . ' logged out successfully.');
        }
        
    }
}
