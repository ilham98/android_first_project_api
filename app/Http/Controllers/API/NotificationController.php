<?php

namespace App\Http\Controllers\API;

use App\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function index(Request $request) {
        $user_id = $request->user_id;
        $notification = Notification::where('user_id', $user_id)->orderBy('created_on', 'desc')->paginate(10);
        return $notification;
    }

    public function count(Request $request) {
        $user_id = $request->user_id;
        $notification = Notification::where('user_id', $user_id)->where('is_read', 0)->count();
        return $notification;

    }

    public function read(Request $request) {
        $notification = Notification::whereIn('id', $request->ids);
        $notification->update([
            'is_read' => 1
        ]);

        return response(['message' => 'true'], 200);
    }
 }
