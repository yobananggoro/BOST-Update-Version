<?php

namespace Tests\Unit;

use App\Http\Middleware\FinalizeLoginStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class FinalizeLoginStatusMiddlewareTest extends TestCase
{
    public function test_pending_login_marks_user_online_on_first_authenticated_request()
    {
        $user = new class {
            public $username = 'tester';
            public $isLogin = false;
            public $session_id = null;
            public $last_activity = null;

            public function save(): bool
            {
                return true;
            }
        };

        $request = Request::create('/home', 'GET');
        $request->setLaravelSession(Session::driver('array'));
        $request->session()->put('login_pending', true);
        $request->session()->put('login_pending_user_id', 1);

        Auth::shouldReceive('check')->andReturn(true);
        Auth::shouldReceive('user')->andReturn($user);

        $middleware = new FinalizeLoginStatus();
        $response = $middleware->handle($request, function ($req) {
            return new Response('ok');
        });

        $this->assertTrue($user->isLogin);
        $this->assertSame($request->session()->getId(), $user->session_id);
        $this->assertFalse($request->session()->has('login_pending'));
        $this->assertSame('ok', $response->getContent());
    }
}
