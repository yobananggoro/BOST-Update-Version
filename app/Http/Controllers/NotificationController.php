<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data = auth()->user()->notifications;

        return view('notifikasi', compact('data'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetch(Request $request)
    {
        $data = [];
        $unreadNotif = auth()->user()->unreadNotifications;
        $n = $unreadNotif->count();

        for ($i = 0; $i < $n; $i++) {
            $data[$i] = [
                'link' => $unreadNotif[$i]->data['url'],
                'message' => $unreadNotif[$i]->data['message'],
                'time' => format_date($unreadNotif[$i]->data['time']),
            ];

            if (isset($unreadNotif[$i]->id)) {
                $data[$i]['id'] = $unreadNotif[$i]->id;
            }

            if (isset($unreadNotif[$i]->data['request_by'])) {
                $data[$i]['request_by'] = $unreadNotif[$i]->data['request_by'];
            }
        }

        return response()->json([
            'count' => $n,
            'label' => ($n ? 'Anda memiliki ' . $n . ' notifikasi' : 'Tidak ada notifikasi'),
            'notify' => $n . ' notifikasi baru untuk Anda',
            'notifications' => $data,
            'hasNotifications' => ($n > 0),
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsRead(Request $request)
    {
        $id = $request->only('id')['id'];
        auth()->user()->unreadNotifications->where('id', $id)->markAsRead();

        return response()->json(auth()->user()->unreadNotifications);
    }
}
