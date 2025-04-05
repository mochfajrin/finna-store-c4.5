<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Pelamar;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function __invoke()
    {
        return view('users.index', ['user' => Auth::user()]);
    }
    public function notifications()
    {
        $notifications = Notification::select(['notifications.*'])->join(
            "pelamars",
            "pelamars.id",
            "=",
            "notifications.pelamar_id"
        )->where('pelamars.user_id', auth()->user()->id)->latest('notifications.created_at')->get();
        return view('users.notifications.index', ['notifications' => $notifications]);
    }
    public function showNotification(Notification $notification)
    {
        try {
            $pelamar = $notification->pelamar()->first();
            if (!$pelamar || $pelamar->user_id != Auth::user()->id) {
                return abort(404);
            }

            $notification->is_read = true;
            $notification->save();
            return view('pelamar.check-mail', ['pelamar' => $pelamar]);
        } catch (DecryptException $e) {
            return abort(404);
        }
    }
    public function update()
    {
    }

    public function notification(Request $request)
    {
    }
}
