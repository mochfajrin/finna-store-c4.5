<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        return view("login");
    }
    public function actionLogin(Request $request)
    {
        $data = $request->validate([
            'email' => 'email|required',
            'password' => 'string|required'
        ]);
        $user = User::where('email', $data['email'])->first();
        if (!$user) {
            return redirect()->back()->with('error', 'Username atau password tidak ada');
        }
        $isPasswordValid = Hash::check($data['password'], $user->password);
        if (!$isPasswordValid) {
            return redirect()->back()->with('error', 'Username atau password tidak ada');
        }

        Auth::attempt($data);
        if ($user->role == 'admin') {
            return redirect("/admin");
        }
        return redirect('/');
    }
    public function register(Request $request)
    {
        return view("register");
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            "name" => "string|required",
            "email" => "email|required",
            "password" => "string|required"
        ]);
        if (User::where('email', $data['email'])->first()) {
            return redirect()->back()->with('error', 'Email telah terdaftar');
        }
        User::create($data);
        return redirect("/login")->with('success', "Akun berhasil dibuat");
    }
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }
}
