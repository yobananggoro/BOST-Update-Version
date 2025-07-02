<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Spatie\Activitylog\Contracts\Activity;

class LogSuccessfulLogin
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
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $user = \Modules\User\Entities\User::where('username', $event->user->username)->first();

        activity()
            ->performedOn($user)
            ->causedBy($event->user->id)
            ->tap(function (Activity $activity) {
                $activity->ip_address = request()->getClientIp();
                $activity->user_agent = request()->userAgent();
                $activity->uri = request()->fullUrl();
            })
            ->log($event->user->username . ' logged in successfully.');
    }
}
