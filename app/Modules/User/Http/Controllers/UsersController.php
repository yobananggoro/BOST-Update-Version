<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Modules\User\Entities\User;
use Modules\User\Entities\Profile;
use Modules\User\Http\Requests\ReleaseRequest;

class UsersController extends \App\Http\Controllers\Controller
{
    /**
    * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    */
    public function index(Request $request)
    {   
        // dd(Session::all(), Session::token());
        $data = User::GetAll();

        \Assets::addJs('dataTables.js');
        \Assets::addJs('custom/user/user.js');
        return view('user::users', compact('data')); 
    }
    
    public function edit($id)
    {
        $data = User::findOrfail($id);
        // dd($data);
        
        return view('user::edit', compact('data'));
    }
    
    public function update(Request $request, $id)
    {
        // dd($request);
        $data = Profile::where('user_id', $id)->first();
        $request['limit_debet'] = str_replace(',', '', $request->limit_debet);
        $request['limit_kredit'] = str_replace(',', '', $request->limit_kredit);
        $values = $request->except('_method','_token', 'save','username');
        
        foreach ($values as $key => $value){
            $data->$key = $value;
        }
        
        $message = ['key' => 'Username', 'value' => $request->username];
        $status = 'error';
        $response = trans('message.create_failed', $message);

        if ($data->save()) {
            $status = 'success';
            $response = trans('message.create_success', $message);
        }
        
        \Assets::addJs('dataTables.js');
        \Assets::addJs('custom/user/user.js');
        return redirect('users')->with($status, $response);
    }
    
    public function isAction(ReleaseRequest $request)
    {
        if($request->submit == "Open"){
            $this->release($request);
        } else {
            $this->unrelease($request);
        }
        
        $status = 'success';
        $response = "Berhasil mengubah status user";
        
        \Assets::addJs('dataTables.js');
        \Assets::addJs('custom/user/user.js');
        return redirect('users')->with($status, $response);;
    }
    
    protected function release($request)
    {
        foreach ($request->id as $id) 
        {
            User::where('id', $id)->update(['status' => 1, 'session_id' => null]);
        }
    }
    
    protected function unrelease($request)
    {
        foreach ($request->id as $id) 
        {
            User::where('id', $id)->update(['status' => 0, 'session_id' => null, 'isLogin' => false]);
        }
    }
}