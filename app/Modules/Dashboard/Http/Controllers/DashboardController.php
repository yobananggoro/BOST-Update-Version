<?php

namespace Modules\Dashboard\Http\Controllers;

use Modules\Dashboard\Entities\Dashboard;
use Modules\Dashboard\Entities\Notification;
use Modules\Dashboard\Entities\Chart;
use DB;

class DashboardController extends \App\Http\Controllers\Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke()
    {

        \Assets::addJs('custom/dashboard.js');

        return view('dashboard::default');
    }
}
