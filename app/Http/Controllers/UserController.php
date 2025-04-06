<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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
            if ($notification->type == 'test') {
                return view('pelamar.check-mail-test', ['pelamar' => $pelamar]);
            } else if ($notification->type == 'interview') {
                return view('pelamar.check-mail-interview', ['pelamar' => $pelamar]);
            } else {
                return view('pelamar.check-mail-results', ['pelamar' => $pelamar]);
            }
        } catch (DecryptException $e) {
            return abort(404);
        }
    }
    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => 'string|required',
            'password' => 'string|confirmed|required',
            'password_confirmation' => 'string|required'
        ]);

        $user = Auth::user();
        $user->name = $data['name'];
        $user->password = bcrypt($data['password']);
        $user->save();
        return redirect('/users');
    }
}
