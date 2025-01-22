<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke()
    {
        $lowongans = Lowongan::latest('created_at')->take(3)->get();
        return view("home", ["lowongans" => $lowongans]);
    }
}
