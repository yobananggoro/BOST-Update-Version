<?php

namespace Modules\User\Http\Controllers;

use Modules\User\Entities\User;
use Modules\User\Http\Requests\ProfileRequest;

class ProfileController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke()
    {
        $data = auth()->user();

        return view('user::profile', compact('data'));
    }
}