<?php

namespace Modules\EmailSimba\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Helper\BostHelper;
use Modules\EmailSimba\Http\Requests\EmailSimbaRequest;

class EmailSimbaController extends \App\Http\Controllers\Controller
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
        
        // dd($email);
        $BackEndHelper = new BostHelper(); 
        $branchCode = auth()->user()->profile->unit_kerja_kode;
        
        if($request->has('label')){
            $email = $request->label;
            $response = $BackEndHelper->ListEmailFilter($request, $branchCode, $pg, $email);
        }else{
            $email = '';
            $response = $BackEndHelper->ListEmail($request, $branchCode, $pg);
        }

        if ($response->status() == 200) {
            $json_string    =   json_decode($response, true);
            // dd($json_string);
            $data = $json_string;
            // dd($data);
            return view('EmailSimba::default', compact('data'));
        }elseif($response->status() == 404){
            $data=null;
            return view('EmailSimba::default', compact('data'));
        }
        else{
            $data=null;
            return view('EmailSimba::default', compact('data'));
        }

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        
        $branchCode = auth()->user()->profile->unit_kerja_kode;
        $data = new \stdClass();
        $data->branch = $branchCode;
        return view('EmailSimba::form', compact('data'));
    }

    /**
     * @param MenuRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(EmailSimbaRequest $request)
    {
        $email=$request->email;
        $branchCode= $request->branch;
        $username = auth()->user()->username;
        $BackEndHelper = new BostHelper(); 
        $response = $BackEndHelper->AddEmail($request, $email, $username, $branchCode);
        $message = ['key' => 'Email', 'value' => $email];
        if ($response->status() == 200) {
            $status = 'success';
            $response = trans('message.create_success', $message);
            return redirect('email-simba')->with($status, $response);
            // return view('EmailSimba::default', compact('data'));
        }
        else{
            $message = ['key' => 'ResposeCode', 'value' => $response->status()];
            $status = 'error';
            $response = trans('message.create_failed', $message);
            return redirect('email-simba')->with($status, $response);
        }
        
    }

    public function edit($id)
    {
        $BackEndHelper = new BostHelper(); 
        $response = $BackEndHelper->getEmail($id);
        if ($response->status() == 200) {
            $json_string    =   json_decode($response, true);
            $dataresp = $json_string;
            $data = new \stdClass();
            $data->branch = $dataresp['branchCode'];
            $data->id = $dataresp['uuid'];
            $data->email = $dataresp['email'];
            return view('EmailSimba::form', compact('data'));
        }
        
    }

    /**
     * @param MenuRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(EmailSimbaRequest $request, $id)
    {
        $email=$request->email;
        $branchCode= $request->branch;
        $username = auth()->user()->username;
        
        $BackEndHelper = new BostHelper(); 
        $response = $BackEndHelper-> putEmail($request, $email, $username, $branchCode, $id);
        $message = ['key' => 'Email', 'value' => $email];
        if ($response->status() == 200) {
            $status = 'success';
            $response = trans('message.create_success', $message);
            return redirect('email-simba')->with($status, $response);
            // return view('EmailSimba::default', compact('data'));
        }
        else{
            $message = ['key' => 'ResposeCode', 'value' => $response->status()];
            $status = 'error';
            $response = trans('message.create_failed', $message);
            return redirect('email-simba')->with($status, $response);
        }
    }

    /**
     * @param Request $request
     * @param OptionGroup $opsi
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Request $request, $id)
    {
        $BackEndHelper = new BostHelper(); 
        $response = $BackEndHelper-> deleteEmail($request, $id);
        $message = ['key' => 'Email', 'value' => $id];
        if ($response->status() == 200) {
            $status = 'success';
            $response = trans('message.delete_success', $message);
            return redirect('email-simba')->with($status, $response);
            // return view('EmailSimba::default', compact('data'));
        }
        else{
            $message = ['key' => 'ResposeCode', 'value' => $response->status()];
            $status = 'error';
            $response = trans('message.delete_failed', $message);
            return redirect('email-simba')->with($status, $response);
        }
    }
}