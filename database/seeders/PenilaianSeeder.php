<?php

namespace Database\Seeders;

use App\Models\Penilaian;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenilaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Penilaian::query()->delete();
        $penilaians = DB::table('pelamars as p')
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

        $status_array = [
            //   1
            true,
            //   2
            false,
            // 3,
            false,
            // 4
            true,
            // 5
            false,
            // 6
            false,
            // 7
            false,
            // 8
            true,
            // 9
            false,
            // 10
            false,
            // 11
            true,
            // 12
            false,
            // 13
            false,
            // 14
            false,
            // 15
            false,
            // 16
            false,
            // 17
            false,
            // 18
            false,
            // 19
            false,
            // 20
            false,
            // 21
            false,
            // 22
            false,
            // 23
            false,
            // 24
            false,
            // 25
            false,
            // 26
            false,
            // 27
            false,
            // 28
            false,
            // 29
            true,
            // 30
            true,
            // 31
            false,
            // 32
            false,
            // 33
            false,
            // 34
            false,
            // 35
            true,
            // 36
            false,
            // 37
            false,
            // 38
            false,
            // 39
            false,
            // 40
            true,
            // 41
            false,
            // 42
            false,
            // 43
            true,
            // 44
            false,
            // 45
            true,
            // 46
            false,
            // 47
            true,
            // 48
            false,
        ];
        foreach ($penilaians as $idx => $penilaian) {
            Penilaian::create([
                'pelamar_id' => $penilaian->pelamar_id,
                'status' => $status_array[$idx]
            ]);
        }
    }
}
