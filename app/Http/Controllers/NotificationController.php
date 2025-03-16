<?php

namespace App\Http\Controllers;
use App\Models\Notification;
use App\Models\User_Notification;
use App\Models\User;
use App\Models\UserUser;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function Store(Request $request)
    {

        $validated = $request->validate([
            'notification' => 'required',
        ]);
        $user = auth()->user();
        $user_id = $user->id;
       $emergency_users = UserUser::where('user_id', $user_id)->get();
        $notification = Notification::create([
            'notification' => $validated['notification'],
        ]);
        foreach($emergency_users as $emergency_user){
            User_Notification::create([
                'user_id' => $user->id,
                'notification_id' => $notification->id,
                'emergency_contact_id'=> $emergency_user->emergency_contact_id,
            ]);
        }
        return response()->json([
            'message' => 'Notification created',
            'data' => $notification,
        ]);
    }

}
