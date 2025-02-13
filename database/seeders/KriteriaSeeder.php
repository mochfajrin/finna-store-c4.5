<?php

namespace Database\Seeders;

use App\Models\Kriteria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kriteria::insert([
            [
                'id' => 1,
                'lowongan_id' => 1,
                'judul' => 'ijazah'
            ],
            [
                'id' => 2,
                'lowongan_id' => 1,
                'judul' => 'skck'
            ],
            [
                'id' => 3,
                'lowongan_id' => 1,
                'judul' => 'ktp'
            ],
            [
                'id' => 4,
                'lowongan_id' => 1,
                'judul' => 'riwayat'
            ],
            [
                'id' => 5,
                'lowongan_id' => 2,
                'judul' => 'ijazah'
            ],
            [
                'id' => 6,
                'lowongan_id' => 2,
                'judul' => 'skck'
            ],
            [
                'id' => 7,
                'lowongan_id' => 2,
                'judul' => 'ktp'
            ],
            [
                'id' => 8,
                'lowongan_id' => 2,
                'judul' => 'riwayat'
            ],
            [
                'id' => 9,
                'lowongan_id' => 3,
                'judul' => 'ijazah'
            ],
            [
                'id' => 10,
                'lowongan_id' => 3,
                'judul' => 'skck'
            ],
            [
                'id' => 11,
                'lowongan_id' => 3,
                'judul' => 'ktp'
            ],
            [
                'id' => 12,
                'lowongan_id' => 3,
                'judul' => 'riwayat'
            ],
        ]);
    }
}
