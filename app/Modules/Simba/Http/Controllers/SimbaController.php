<?php

namespace Modules\Simba\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Modules\Simba\Entities\Simba;
use Modules\Simba\Http\Requests\SimbaRequest;
use App\Http\Helper\BostHelper;
use Illuminate\Support\Facades\Input;

class SimbaController extends \App\Http\Controllers\Controller
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
        $BackEndHelper = new BostHelper(); 
        $branchCode = auth()->user()->profile->unit_kerja_kode;
        
        if($request->has('label')){
            $id_atm = $request->label; 
        }else{
            $id_atm = '';
        }

        $response = $BackEndHelper->ListAtm($request, $branchCode, $pg, $id_atm);
        if ($response->status() == 200) {
            $json_string    =   json_decode($response, true);
            // dd($json_string);
            $data = $json_string;
            // dd($data);
            return view('simba::default', compact('data'));
        }elseif ($response->status() == 400) {
            $requestToken = $BackEndHelper->auth($request);
            if($requestToken->status() == 200){
                $this->store($request);
                $data['errorMessage'] = "Token Habis Ulangi Kembali";
                return view('simba::default', compact('data'));
            } else {
                $status     = 'error';
                $response   = 'Gagal Request Token!';
                
                if ($request->ajax())
                return response()->json(['message' => $response, 'status' => $status]);
                
                return redirect('simba')->with($status,$response);
            }
            
        }
        else{
            $data = null;
            return view('simba::default', compact('data'));
        }
        
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {

    }

    /**
     * @param SimbaRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(SimbaRequest $request)
    {

    }

    public function edit($id)
    {

    }

    /**
     * @param SimbaRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Request $request, $id)
    {
        
    }
}