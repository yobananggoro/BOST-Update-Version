<?php

namespace App\Concerns;

use Illuminate\Foundation\Auth\AuthenticatesUsers as BaseAuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Auth\LoginController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

trait AuthenticatesUsers
{
    use BaseAuthenticatesUsers, AuthenticatesFrom;

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $credentials = $this->credentials($request);
        // dd($request->header(), $credentials['username']);

        if (config('auth.force_local') === false && $credentials['username'] != 'BOST') {
            $authenticated = $this->uimNG($credentials, $request);
        } else {
            $authenticated = $this->local($credentials);
        }

        // dd($authenticated);
        if ($authenticated) {
            $user = \Modules\User\Entities\User::findByUsername($credentials[$this->username()]);
            $now = now();
            $idle = $now->diffInMinutes($user->last_activity);
            // dd(auth()->user()->profile->rolename);
            // dd($user->profile->rolename);

            if (!$user->hasAnyRole((\Modules\HakAkses\Entities\Role::all())->pluck('name')->toArray())) {
                // dd('kesini');
                $this->guard()->logout();
                $this->sendNotAllowedLoginResponse($request);

                return false;
            } else if ($user->status == 9) {
                $this->guard()->logout();
                $this->sendBlockedCredentialsResponse($request);

                return false;
            } else if ($user->status == 0) {
                $this->guard()->logout();
                $this->sendUnreleaseResponse($request);

                return false;
            } else if ($user->profile->rolename != 'SUPER ADMIN') {
                if ($user->isLogin == true && $idle <= config('session.lifetime')) {
                    $this->failAuth($request);
                    $this->sendMultipleLoggedInNotAllowedResponse($request);

                    return false;
                }

                return true;
            }

            return true;
        } else {

            return false;
        }
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        // dd('kesini', $user);
        if (empty($user)) {
            $user = \Modules\User\Entities\User::findByUsername($request->username);
        }

        $user->session_id = Session::getId();
        $user->isLogin = true;
        $user->last_activity = now();
        $user->save();

        $this->guard()->login($user);
    }

    /**
     * Get the login username to be used by the controller. 
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }

    /**
     * @param Request $request
     */
    protected function sendNotAllowedLoginResponse(Request $request)
    {
        throw \Illuminate\Validation\ValidationException::withMessages([
            $this->username() => [trans('auth.not_allowed')],
        ]);
    }

    /**
     * @param Request $request
     */
    protected function sendBlockedCredentialsResponse(Request $request)
    {
        throw \Illuminate\Validation\ValidationException::withMessages([
            $this->username() => ['Identitas Anda diblokir.'],
        ]);
    }

    /**
     * @param Request $request
     */
    protected function sendMultipleLoggedInNotAllowedResponse(Request $request)
    {
        throw \Illuminate\Validation\ValidationException::withMessages([
            $this->username() => ['Identitas Anda sedang digunakan pada perangkat lain.'],
        ]);
    }

    /**
     * @param Request $request
     */
    protected function sendUnreleaseResponse(Request $request)
    {
        throw \Illuminate\Validation\ValidationException::withMessages([
            $this->username() => ['Identitas Anda tidak dapat digunakan! Silahkan hubungi SPV unit kerja terkait.'],
        ]);
    }

    /**
     *
     */
    protected function clearSessionId()
    {
        if (auth()->check()) {
            $user = auth()->user();
            $user->session_id = null;
            $user->isLogin = false;
            $user->update();
        }
    }

    protected function failAuth(Request $request)
    {
        Auth::logout();
        return $this->loggedOut($request) ?: redirect('/');
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        // dd($request);exit;
        $this->clearSessionId();
        $this->guard()->logout();
        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/');
    }
}
