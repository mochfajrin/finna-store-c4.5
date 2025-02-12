<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use Illuminate\Http\Request;

class LowonganController extends Controller
{
    public function __invoke()
    {
        $lowongans = Lowongan::latest('created_at')->get();
        return view('lowongan.index', [
            'lowongans' => $lowongans
        ]);
    }
    public function show(int $lowonganId)
    {
        $lowongan = Lowongan::where('id', $lowonganId)->first();

        if (!$lowongan) {
            return abort(404);
        }
        return view("lowongan.show", [
            'lowongan' => $lowongan,
        ]);
    }
}
