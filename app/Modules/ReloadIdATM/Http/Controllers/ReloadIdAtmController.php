<?php

namespace Modules\ReloadIdATM\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Helper\BostHelper;
use Modules\EmailSimba\Http\Requests\ReloadIdAtm;

class ReloadIdAtmController extends \App\Http\Controllers\Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if($request->has('page')){
            $pg = $request->page;
        }else{
            $pg = '0';
        }

        if($request->has('label')){
            $id_atm = $request->label;
        }else{
            $id_atm = '';
        }

        $BackEndHelper = new BostHelper(); 
        $branchCode = auth()->user()->profile->unit_kerja_kode;
        
        $response = $BackEndHelper->ListAtm($request, $branchCode, $pg, $id_atm);
        if ($response->status() == 200) {
            $json_string    =   json_decode($response, true);
            // dd($json_string);
            $data = $json_string;
            // dd($data);
            return view('ReloadIdAtm::default', compact('data'));
        }elseif ($response->status() == 400) {
            $requestToken = $BackEndHelper->auth($request);
            if($requestToken->status() == 200){
                $this->store($request);
                $data['errorMessage'] = "Token Habis Ulangi Kembali";
                return view('ReloadIdAtm::default', compact('data'));
            } else {
                $status     = 'error';
                $response   = 'Gagal Request Token!';
                
                if ($request->ajax())
                return response()->json(['message' => $response, 'status' => $status]);
                
                return redirect('ReloadIdAtm')->with($status,$response);
            }
            
        }elseif($response->status() == 404){
            $data=null;
            return view('ReloadIdAtm::default', compact('data'));
        }
        else{
            $data = null;
            return view('ReloadIdAtm::default', compact('data'));
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $BackEndHelper = new BostHelper();
        $response = $BackEndHelper->reloadIdAtm();
        if ($response->status() == 200) {
            $message = ['key' => 'Reload', 'value' => 'success'];
            $status = 'success';
            $response = trans('message.create_success', $message);
            return redirect('reload-id-atm')->with($status, $response);
        }else{
            $message = ['key' => 'Reload', 'value' => 'failed'];
            $status = 'error';
            $response = trans('message.create_success', $message);
            return redirect('reload-id-atm')->with($status, $response);
        }
    }

    /**
     * @param MenuRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(ReloadIdAtm $request)
    {
        
    }

    public function edit($id)
    {
       
    }

    /**
     * @param MenuRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(ReloadIdAtm $request, $id)
    {
        
    }

    /**
     * @param Request $request
     * @param OptionGroup $opsi
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Request $request, $id)
    {
       
    }
}