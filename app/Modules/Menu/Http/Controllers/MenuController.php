<?php

namespace Modules\Menu\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Modules\Menu\Entities\Menu;
use Modules\Menu\Http\Requests\MenuRequest;

class MenuController extends \App\Http\Controllers\Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = Menu::fetch($request);

        return view('menu::default', compact('data'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $data = new Menu;
        $prnt = to_dropdown(Menu::where('uri','#')->get(), 'id', 'label');

        return view('menu::form', compact('data','prnt'));
    }

    /**
     * @param MenuRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(MenuRequest $request)
    {
        // dd($request);exit;
        $data = new Menu;
        $values = $request->except('_token', 'save');

        foreach ($values as $key => $value)
            $data->$key = $value;

        $message = ['key' => 'Menu', 'value' => $values['label']];
        $status = 'error';
        $response = trans('message.create_failed', $message);

        if ($data->save()) {
            $status = 'success';
            $response = trans('message.create_success', $message);
        }

        if ($request->ajax())
            return response()->json(['message' => $response, 'status' => $status]);

        if ($request->only('save'))
            return redirect()->route('menu.create')->with($status, $response);

        return redirect('menu')->with($status, $response);
    }

    public function edit($id)
    {
        $data = Menu::findOrFail($id);
        $prnt = to_dropdown(Menu::where('uri','#')->get(), 'id', 'label');

        return view('menu::form', compact('data','prnt'));
    }

    /**
     * @param MenuRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $data = Menu::findOrFail($id);
        $values = $request->except('_method','_token', 'save');

        foreach ($values as $key => $value)
            $data->$key = $value;

        $message = ['key' => 'Menu', 'value' => $values['label']];
        $status = 'error';
        $response = trans('message.create_failed', $message);

        if ($data->save()) {
            $status = 'success';
            $response = trans('message.create_success', $message);
        }

        if ($request->ajax())
            return response()->json(['message' => $response, 'status' => $status]);

        return redirect('menu')->with($status, $response);
    }

    /**
     * @param Request $request
     * @param OptionGroup $opsi
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Request $request, $id)
    {
        $data = Menu::findOrFail($id); 

        $message = ['key' => 'Menu', 'value' => $data->label];
        $status = 'error';
        $response = trans('message.delete_failed', $message);

        if ($data->delete()) {
            $status = 'success';
            $response = trans('message.delete_success', $message);
        }

        if ($request->ajax())
            return response()->json(['message' => $response, 'status' => $status]);

        return redirect('menu')->with($status, $response);
    }
}