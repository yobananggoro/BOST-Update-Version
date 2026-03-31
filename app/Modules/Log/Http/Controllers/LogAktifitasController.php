<?php

namespace Modules\Log\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Log\Entities\LogActivity;

class LogAktifitasController extends \App\Http\Controllers\Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(Request $request)
    {
        foreach (\Modules\User\Entities\User::all() as $d) {
            // dd($d->profile->nama);
            $causer[$d->id] = $d->profile->nama;
        }

        $data = LogActivity::filter($request->except(['per_page']))
        ->fetch($request->per_page);
        // dd($data);
        $causer = \Arr::prepend($causer, trans('label.choose_one'), '');

        return view('log::log-aktifitas.default', compact('data', 'causer'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clean()
    {
        LogActivity::truncate();

        return redirect('log-aktifitas')->with([
            'status' => 'info', 'message' => __('message.log_cleaned')
        ]);
    }
}