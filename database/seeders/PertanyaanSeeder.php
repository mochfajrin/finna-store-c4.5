<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pertanyaan;

class PertanyaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // 1.penampilan
        // 2.kemampuan
        // 3.sopan santun (etika)
        // 4.pemecahan masalah
        // 5.pengalaman organisasi

        // nilai 0,10,20

        $pertanyaan = (object) [
            1 => (object) ['pertanyaan' => 'penampilan'],
            2 => (object) ['pertanyaan' => 'kemampuan'],
            3 => (object) ['pertanyaan' => 'sopan santun (etika)'],
            4 => (object) ['pertanyaan' => 'pemecahan masalah'],
            5 => (object) ['pertanyaan' => 'pengalaman organisasi'],
        ];

        Pertanyaan::insert([
            ['pelamar_id' => 1, 'wawancara_id' => 1, 'pertanyaan' => $pertanyaan->{1}->pertanyaan, 'nilai' => 0],
            ['pelamar_id' => 1, 'wawancara_id' => 1, 'pertanyaan' => $pertanyaan->{2}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 1, 'wawancara_id' => 1, 'pertanyaan' => $pertanyaan->{3}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 1, 'wawancara_id' => 1, 'pertanyaan' => $pertanyaan->{4}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 1, 'wawancara_id' => 1, 'pertanyaan' => $pertanyaan->{5}->pertanyaan, 'nilai' => 0],
        ]);
    }
}
