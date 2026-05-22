<?php

namespace Modules\Rekening\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use App\Entities\Token;
use App\Http\Helper\BostHelper;
use Modules\Rekening\Entities\Rekening;
use Modules\Rekening\Entities\Currency;
use Modules\Rekening\Http\Requests\RekeningRequest;


class RekeningController extends \App\Http\Controllers\Controller
{
    public function index(Request $request)
    {

        $data = Rekening::fetch($request);
        \Assets::addJs('custom/rekening.js');

        return view('rekening::default', compact('data'));
    }

    public function create()
    {
        $data = new Rekening;
        $curr = to_dropdown(Currency::get(), 'curr_code', 'curr_desc');
        \Assets::addJs('custom/rekening/rekening.js');

        return view('rekening::form', compact('data', 'curr'));
    }

    public function store(RekeningRequest $request)
    {
        // dd($request);exit;
        $data = new Rekening;
        $values = $request->except('_token', 'save');

        foreach ($values as $key => $value)
            $data->$key = $value;

        $message = ['key' => 'Rekening', 'value' => $values['nama']];
        $status = 'error';
        $response = trans('message.create_failed', $message);

        if ($data->save()) {
            $status = 'success';
            $response = trans('message.create_success', $message);
        }

        if ($request->ajax())
            return response()->json(['message' => $response, 'status' => $status]);

        if ($request->only('save'))
            return redirect()->route('rekening.create')->with($status, $response);

        return redirect('rekening')->with($status, $response);
    }

    public function edit($id)
    {
        $data = Rekening::findOrFail($id);
        \Assets::addJs('custom/rekening.js');

        return view('rekening::form', compact('data'));
    }

    public function update(Request $request, $id)
    {
        // dd($request);exit;
        $data = Rekening::findOrFail($id);
        $values = $request->except('_method', '_token', 'save');

        foreach ($values as $key => $value)
            $data->$key = $value;

        $message = ['key' => 'Rekening', 'value' => $values['nama']];
        $status = 'error';
        $response = trans('message.create_failed', $message);

        if ($data->save()) {
            $status = 'success';
            $response = trans('message.create_success', $message);
        }

        if ($request->ajax())
            return response()->json(['message' => $response, 'status' => $status]);

        return redirect('rekening')->with($status, $response);
    }

    public function destroy(Request $request, $id)
    {
        $data = Rekening::findOrFail($id);

        $message = ['key' => 'Rekening', 'value' => $data->nama];
        $status = 'error';
        $response = trans('message.delete_failed', $message);

        if ($data->delete()) {
            $status = 'success';
            $response = trans('message.delete_success', $message);
        }

        if ($request->ajax())
            return response()->json(['message' => $response, 'status' => $status]);

        return redirect('rekening')->with($status, $response);
    }

    public function listRekening(Request $request)
    {
        $cacheKey = 'rekening_list_' . md5(json_encode($request->all()));

        try {
            $data = Cache::remember($cacheKey, 3600, function () use ($request) {
                return Rekening::List($request);
            });

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Throwable $e) {

            \Log::error('Rekening::List gagal: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data rekening',
                'data' => []
            ], 500);
        }

        // $data = Rekening::List($request); 
        // return response()->json($data);
    }
}
