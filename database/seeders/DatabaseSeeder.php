<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Evaluasi;
use App\Models\Kriteria;
use App\Models\Lowongan;
use App\Models\Notification;
use App\Models\Pelamar;
use App\Models\Penilaian;
use App\Models\Tes;
use App\Models\User;
use App\Models\Wawancara;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Evaluasi::query()->delete();
        Penilaian::query()->delete();
        Wawancara::query()->delete();
        Tes::query()->delete();
        Pelamar::query()->delete();
        Kriteria::query()->delete();
        Notification::query()->delete();
        Lowongan::query()->delete();
        User::query()->delete();
        User::insert([
            [
                'id' => 1,
                'name' => 'Lutfi',
                'role' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make("admin"),
            ],
            [
                'id' => 2,
                'name' => "Jhon Doe",
                'role' => 'member',
                "email" => "jhondoe@mail.com",
                'password' => Hash::make('member'),
            ]
        ]);
        $this->call(LowonganSeeder::class);
        $this->call(KriteriaSeeder::class);
        $this->call(PelamarSeeder::class);
        $this->call(TesSeeder::class);
        $this->call(WawancaraSeeder::class);
        $this->call(EvaluasiRiwayat::class);
        $this->call(EvaluasiIjazah::class);
        $this->call(EvaluasiKtp::class);
        $this->call(EvaluasiSkck::class);
        $this->call(PenilaianSeeder::class);
    }

}
