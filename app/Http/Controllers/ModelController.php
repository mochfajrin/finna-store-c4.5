<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModelController extends Controller
{
    public function __invoke()
    {
        $models = DB::table('pelamars as p')
            ->leftJoin('tes as t', 'p.id', '=', 't.pelamar_id')
            ->leftJoin('evaluasis as e', 'p.id', '=', 'e.pelamar_id')
            ->leftJoin('kriterias as k', 'e.kriteria_id', '=', 'k.id')
            ->leftJoin('wawancaras as w', 'p.id', '=', 'w.pelamar_id')
            ->select(
                'p.id as pelamar_id',
                'p.nama as nama',
                DB::raw("MAX(CASE WHEN k.judul = 'riwayat' THEN e.nilai END) as riwayat"),
                DB::raw("MAX(CASE WHEN k.judul = 'ktp' THEN e.nilai END) as ktp"),
                DB::raw("MAX(CASE WHEN k.judul = 'skck' THEN e.nilai END) as skck"),
                DB::raw("MAX(CASE WHEN k.judul = 'ijazah' THEN e.nilai END) as ijazah"),
                DB::raw("MAX(CASE WHEN t.jenis = 'buta_warna' THEN t.nilai END) as buta_warna"),
                DB::raw("MAX(CASE WHEN t.jenis = 'kemampuan' THEN t.nilai END) as kemampuan"),
                'w.nilai as wawancara',
                DB::raw("
            COALESCE(MAX(CASE WHEN k.judul = 'riwayat' THEN e.nilai END), 0) +
            COALESCE(MAX(CASE WHEN k.judul = 'ktp' THEN e.nilai END), 0) +
            COALESCE(MAX(CASE WHEN k.judul = 'skck' THEN e.nilai END), 0) +
            COALESCE(MAX(CASE WHEN k.judul = 'ijazah' THEN e.nilai END), 0) +
            COALESCE(MAX(CASE WHEN t.jenis = 'buta_warna' THEN t.nilai END), 0) +
            COALESCE(MAX(CASE WHEN t.jenis = 'kemampuan' THEN t.nilai END), 0) +
            COALESCE(w.nilai, 0)
        AS total")
            )
            ->groupBy('p.id', 'p.nama', 'w.nilai')
            ->get();



        return view('model.model', ['models' => $models]);
    }
}
