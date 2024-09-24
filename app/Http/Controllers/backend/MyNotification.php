<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyNotification extends Controller
{
    public function getNotification(Request $request)
    {
        $loginUser = Auth::user();
        if(!empty($request->markallread) && $request->markallread ==1) {
            Notification::where('notifiable_id', auth()->id())
            ->update(['read_at' => now()]);
        }
        $notifications = Notification::where(['notifiable_id' => $loginUser->id, 'notifiable_type' => "App\Models\User"])->whereNull('read_at')->orderByDesc('created_at')->get();
        $notificationList = [];
        foreach ($notifications as $notification) {
            $data = $notification->data;
            $notificationList[] = [
                'title' => $data['title'],
                'body' => html_entity_decode($data['message']),
                'url' => $data['url'],
                // 'icon' => $data['type'] == 'appointment' ? 'bx bx-calendar' : 'bx bx-cart',
                'time' => str_ireplace(
                    [' seconds', ' second', ' minutes', ' minute', ' hours', ' hour', ' days', ' day', ' weeks', ' week'],
                    [' sec', ' sec', ' mins', ' min', ' hrs', ' hr', ' days', ' day', ' weeks', ' week'],
                    $notification->created_at->diffForHumans()
                )
            ];
        }
        return response()->json(['status' => '200', 'data' => $notificationList], 200);
    }

    public function index(Request $request)
    {
        if (!auth()->user()->can('order-view')) {
            return redirect()->back()->with('error', 'You have not permission to access this page.');
        }
        $getAllNotification = Notification::where('notifiable_id', Auth::id())->select('id','data','created_at');
        if ($request->ajax()) {

            return datatables()->of($getAllNotification)
                ->editColumn('data', function ($data) {
                    if (auth()->user()->can('order-view')) {
                        $data = $data->data;
                        $html = '<a class="text-decoration-none" href="'.$data['url'].'">
                                    '.$data['message'].'</a>';
                        return $html;
                    }
                })
                ->editColumn('created_at', function ($data) {
                    return $data->created_at->format('d M Y h:i A');
                })
                ->rawColumns(['data'])
                ->make(true);
        }
        return view('backend.notification.index');
    }
}
