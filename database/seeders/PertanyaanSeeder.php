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

            ['pelamar_id' => 2, 'wawancara_id' => 2, 'pertanyaan' => $pertanyaan->{1}->pertanyaan, 'nilai' => 0],
            ['pelamar_id' => 2, 'wawancara_id' => 2, 'pertanyaan' => $pertanyaan->{2}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 2, 'wawancara_id' => 2, 'pertanyaan' => $pertanyaan->{3}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 2, 'wawancara_id' => 2, 'pertanyaan' => $pertanyaan->{4}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 2, 'wawancara_id' => 2, 'pertanyaan' => $pertanyaan->{5}->pertanyaan, 'nilai' => 0],

            ['pelamar_id' => 3, 'wawancara_id' => 3, 'pertanyaan' => $pertanyaan->{1}->pertanyaan, 'nilai' => 0],
            ['pelamar_id' => 3, 'wawancara_id' => 3, 'pertanyaan' => $pertanyaan->{2}->pertanyaan, 'nilai' => 0],
            ['pelamar_id' => 3, 'wawancara_id' => 3, 'pertanyaan' => $pertanyaan->{3}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 3, 'wawancara_id' => 3, 'pertanyaan' => $pertanyaan->{4}->pertanyaan, 'nilai' => 0],
            ['pelamar_id' => 3, 'wawancara_id' => 3, 'pertanyaan' => $pertanyaan->{5}->pertanyaan, 'nilai' => 10],

            ['pelamar_id' => 4, 'wawancara_id' => 4, 'pertanyaan' => $pertanyaan->{1}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 4, 'wawancara_id' => 4, 'pertanyaan' => $pertanyaan->{2}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 4, 'wawancara_id' => 4, 'pertanyaan' => $pertanyaan->{3}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 4, 'wawancara_id' => 4, 'pertanyaan' => $pertanyaan->{4}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 4, 'wawancara_id' => 4, 'pertanyaan' => $pertanyaan->{5}->pertanyaan, 'nilai' => 0],

            ['pelamar_id' => 5, 'wawancara_id' => 5, 'pertanyaan' => $pertanyaan->{1}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 5, 'wawancara_id' => 5, 'pertanyaan' => $pertanyaan->{2}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 5, 'wawancara_id' => 5, 'pertanyaan' => $pertanyaan->{3}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 5, 'wawancara_id' => 5, 'pertanyaan' => $pertanyaan->{4}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 5, 'wawancara_id' => 5, 'pertanyaan' => $pertanyaan->{5}->pertanyaan, 'nilai' => 10],


            ['pelamar_id' => 6, 'wawancara_id' => 6, 'pertanyaan' => $pertanyaan->{1}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 6, 'wawancara_id' => 6, 'pertanyaan' => $pertanyaan->{2}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 6, 'wawancara_id' => 6, 'pertanyaan' => $pertanyaan->{3}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 6, 'wawancara_id' => 6, 'pertanyaan' => $pertanyaan->{4}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 6, 'wawancara_id' => 6, 'pertanyaan' => $pertanyaan->{5}->pertanyaan, 'nilai' => 10],


            ['pelamar_id' => 7, 'wawancara_id' => 7, 'pertanyaan' => $pertanyaan->{1}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 7, 'wawancara_id' => 7, 'pertanyaan' => $pertanyaan->{2}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 7, 'wawancara_id' => 7, 'pertanyaan' => $pertanyaan->{3}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 7, 'wawancara_id' => 7, 'pertanyaan' => $pertanyaan->{4}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 7, 'wawancara_id' => 7, 'pertanyaan' => $pertanyaan->{5}->pertanyaan, 'nilai' => 0],


            ['pelamar_id' => 8, 'wawancara_id' => 8, 'pertanyaan' => $pertanyaan->{1}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 8, 'wawancara_id' => 8, 'pertanyaan' => $pertanyaan->{2}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 8, 'wawancara_id' => 8, 'pertanyaan' => $pertanyaan->{3}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 8, 'wawancara_id' => 8, 'pertanyaan' => $pertanyaan->{4}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 8, 'wawancara_id' => 8, 'pertanyaan' => $pertanyaan->{5}->pertanyaan, 'nilai' => 10],


            ['pelamar_id' => 9, 'wawancara_id' => 9, 'pertanyaan' => $pertanyaan->{1}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 9, 'wawancara_id' => 9, 'pertanyaan' => $pertanyaan->{2}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 9, 'wawancara_id' => 9, 'pertanyaan' => $pertanyaan->{3}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 9, 'wawancara_id' => 9, 'pertanyaan' => $pertanyaan->{4}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 9, 'wawancara_id' => 9, 'pertanyaan' => $pertanyaan->{5}->pertanyaan, 'nilai' => 0],


            ['pelamar_id' => 10, 'wawancara_id' => 10, 'pertanyaan' => $pertanyaan->{1}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 10, 'wawancara_id' => 10, 'pertanyaan' => $pertanyaan->{2}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 10, 'wawancara_id' => 10, 'pertanyaan' => $pertanyaan->{3}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 10, 'wawancara_id' => 10, 'pertanyaan' => $pertanyaan->{4}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 10, 'wawancara_id' => 10, 'pertanyaan' => $pertanyaan->{5}->pertanyaan, 'nilai' => 10],


            ['pelamar_id' => 11, 'wawancara_id' => 11, 'pertanyaan' => $pertanyaan->{1}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 11, 'wawancara_id' => 11, 'pertanyaan' => $pertanyaan->{2}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 11, 'wawancara_id' => 11, 'pertanyaan' => $pertanyaan->{3}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 11, 'wawancara_id' => 11, 'pertanyaan' => $pertanyaan->{4}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 11, 'wawancara_id' => 11, 'pertanyaan' => $pertanyaan->{5}->pertanyaan, 'nilai' => 20],


            ['pelamar_id' => 12, 'wawancara_id' => 12, 'pertanyaan' => $pertanyaan->{1}->pertanyaan, 'nilai' => 0],
            ['pelamar_id' => 12, 'wawancara_id' => 12, 'pertanyaan' => $pertanyaan->{2}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 12, 'wawancara_id' => 12, 'pertanyaan' => $pertanyaan->{3}->pertanyaan, 'nilai' => 0],
            ['pelamar_id' => 12, 'wawancara_id' => 12, 'pertanyaan' => $pertanyaan->{4}->pertanyaan, 'nilai' => 0],
            ['pelamar_id' => 12, 'wawancara_id' => 12, 'pertanyaan' => $pertanyaan->{5}->pertanyaan, 'nilai' => 0],


            ['pelamar_id' => 13, 'wawancara_id' => 13, 'pertanyaan' => $pertanyaan->{1}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 13, 'wawancara_id' => 13, 'pertanyaan' => $pertanyaan->{2}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 13, 'wawancara_id' => 13, 'pertanyaan' => $pertanyaan->{3}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 13, 'wawancara_id' => 13, 'pertanyaan' => $pertanyaan->{4}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 13, 'wawancara_id' => 13, 'pertanyaan' => $pertanyaan->{5}->pertanyaan, 'nilai' => 10],


            ['pelamar_id' => 14, 'wawancara_id' => 14, 'pertanyaan' => $pertanyaan->{1}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 14, 'wawancara_id' => 14, 'pertanyaan' => $pertanyaan->{2}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 14, 'wawancara_id' => 14, 'pertanyaan' => $pertanyaan->{3}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 14, 'wawancara_id' => 14, 'pertanyaan' => $pertanyaan->{4}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 14, 'wawancara_id' => 14, 'pertanyaan' => $pertanyaan->{5}->pertanyaan, 'nilai' => 10],


            ['pelamar_id' => 15, 'wawancara_id' => 15, 'pertanyaan' => $pertanyaan->{1}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 15, 'wawancara_id' => 15, 'pertanyaan' => $pertanyaan->{2}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 15, 'wawancara_id' => 15, 'pertanyaan' => $pertanyaan->{3}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 15, 'wawancara_id' => 15, 'pertanyaan' => $pertanyaan->{4}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 15, 'wawancara_id' => 15, 'pertanyaan' => $pertanyaan->{5}->pertanyaan, 'nilai' => 10],


            ['pelamar_id' => 16, 'wawancara_id' => 16, 'pertanyaan' => $pertanyaan->{1}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 16, 'wawancara_id' => 16, 'pertanyaan' => $pertanyaan->{2}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 16, 'wawancara_id' => 16, 'pertanyaan' => $pertanyaan->{3}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 16, 'wawancara_id' => 16, 'pertanyaan' => $pertanyaan->{4}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 16, 'wawancara_id' => 16, 'pertanyaan' => $pertanyaan->{5}->pertanyaan, 'nilai' => 10],


            ['pelamar_id' => 17, 'wawancara_id' => 17, 'pertanyaan' => $pertanyaan->{1}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 17, 'wawancara_id' => 17, 'pertanyaan' => $pertanyaan->{2}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 17, 'wawancara_id' => 17, 'pertanyaan' => $pertanyaan->{3}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 17, 'wawancara_id' => 17, 'pertanyaan' => $pertanyaan->{4}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 17, 'wawancara_id' => 17, 'pertanyaan' => $pertanyaan->{5}->pertanyaan, 'nilai' => 10],


            ['pelamar_id' => 18, 'wawancara_id' => 18, 'pertanyaan' => $pertanyaan->{1}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 18, 'wawancara_id' => 18, 'pertanyaan' => $pertanyaan->{2}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 18, 'wawancara_id' => 18, 'pertanyaan' => $pertanyaan->{3}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 18, 'wawancara_id' => 18, 'pertanyaan' => $pertanyaan->{4}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 18, 'wawancara_id' => 18, 'pertanyaan' => $pertanyaan->{5}->pertanyaan, 'nilai' => 0],


            ['pelamar_id' => 19, 'wawancara_id' => 19, 'pertanyaan' => $pertanyaan->{1}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 19, 'wawancara_id' => 19, 'pertanyaan' => $pertanyaan->{2}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 19, 'wawancara_id' => 19, 'pertanyaan' => $pertanyaan->{3}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 19, 'wawancara_id' => 19, 'pertanyaan' => $pertanyaan->{4}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 19, 'wawancara_id' => 19, 'pertanyaan' => $pertanyaan->{5}->pertanyaan, 'nilai' => 0],


            ['pelamar_id' => 20, 'wawancara_id' => 20, 'pertanyaan' => $pertanyaan->{1}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 20, 'wawancara_id' => 20, 'pertanyaan' => $pertanyaan->{2}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 20, 'wawancara_id' => 20, 'pertanyaan' => $pertanyaan->{3}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 20, 'wawancara_id' => 20, 'pertanyaan' => $pertanyaan->{4}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 20, 'wawancara_id' => 20, 'pertanyaan' => $pertanyaan->{5}->pertanyaan, 'nilai' => 0],


            ['pelamar_id' => 21, 'wawancara_id' => 21, 'pertanyaan' => $pertanyaan->{1}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 21, 'wawancara_id' => 21, 'pertanyaan' => $pertanyaan->{2}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 21, 'wawancara_id' => 21, 'pertanyaan' => $pertanyaan->{3}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 21, 'wawancara_id' => 21, 'pertanyaan' => $pertanyaan->{4}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 21, 'wawancara_id' => 21, 'pertanyaan' => $pertanyaan->{5}->pertanyaan, 'nilai' => 10],


            ['pelamar_id' => 22, 'wawancara_id' => 22, 'pertanyaan' => $pertanyaan->{1}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 22, 'wawancara_id' => 22, 'pertanyaan' => $pertanyaan->{2}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 22, 'wawancara_id' => 22, 'pertanyaan' => $pertanyaan->{3}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 22, 'wawancara_id' => 22, 'pertanyaan' => $pertanyaan->{4}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 22, 'wawancara_id' => 22, 'pertanyaan' => $pertanyaan->{5}->pertanyaan, 'nilai' => 0],


            ['pelamar_id' => 23, 'wawancara_id' => 23, 'pertanyaan' => $pertanyaan->{1}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 23, 'wawancara_id' => 23, 'pertanyaan' => $pertanyaan->{2}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 23, 'wawancara_id' => 23, 'pertanyaan' => $pertanyaan->{3}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 23, 'wawancara_id' => 23, 'pertanyaan' => $pertanyaan->{4}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 23, 'wawancara_id' => 23, 'pertanyaan' => $pertanyaan->{5}->pertanyaan, 'nilai' => 0],


            ['pelamar_id' => 24, 'wawancara_id' => 24, 'pertanyaan' => $pertanyaan->{1}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 24, 'wawancara_id' => 24, 'pertanyaan' => $pertanyaan->{2}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 24, 'wawancara_id' => 24, 'pertanyaan' => $pertanyaan->{3}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 24, 'wawancara_id' => 24, 'pertanyaan' => $pertanyaan->{4}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 24, 'wawancara_id' => 24, 'pertanyaan' => $pertanyaan->{5}->pertanyaan, 'nilai' => 10],

            ['pelamar_id' => 25, 'wawancara_id' => 25, 'pertanyaan' => $pertanyaan->{1}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 25, 'wawancara_id' => 25, 'pertanyaan' => $pertanyaan->{2}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 25, 'wawancara_id' => 25, 'pertanyaan' => $pertanyaan->{3}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 25, 'wawancara_id' => 25, 'pertanyaan' => $pertanyaan->{4}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 25, 'wawancara_id' => 25, 'pertanyaan' => $pertanyaan->{5}->pertanyaan, 'nilai' => 10],

            ['pelamar_id' => 26, 'wawancara_id' => 26, 'pertanyaan' => $pertanyaan->{1}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 26, 'wawancara_id' => 26, 'pertanyaan' => $pertanyaan->{2}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 26, 'wawancara_id' => 26, 'pertanyaan' => $pertanyaan->{3}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 26, 'wawancara_id' => 26, 'pertanyaan' => $pertanyaan->{4}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 26, 'wawancara_id' => 26, 'pertanyaan' => $pertanyaan->{5}->pertanyaan, 'nilai' => 10],

            ['pelamar_id' => 27, 'wawancara_id' => 27, 'pertanyaan' => $pertanyaan->{1}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 27, 'wawancara_id' => 27, 'pertanyaan' => $pertanyaan->{2}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 27, 'wawancara_id' => 27, 'pertanyaan' => $pertanyaan->{3}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 27, 'wawancara_id' => 27, 'pertanyaan' => $pertanyaan->{4}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 27, 'wawancara_id' => 27, 'pertanyaan' => $pertanyaan->{5}->pertanyaan, 'nilai' => 10],

            ['pelamar_id' => 28, 'wawancara_id' => 28, 'pertanyaan' => $pertanyaan->{1}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 28, 'wawancara_id' => 28, 'pertanyaan' => $pertanyaan->{2}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 28, 'wawancara_id' => 28, 'pertanyaan' => $pertanyaan->{3}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 28, 'wawancara_id' => 28, 'pertanyaan' => $pertanyaan->{4}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 28, 'wawancara_id' => 28, 'pertanyaan' => $pertanyaan->{5}->pertanyaan, 'nilai' => 10],

            ['pelamar_id' => 29, 'wawancara_id' => 29, 'pertanyaan' => $pertanyaan->{1}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 29, 'wawancara_id' => 29, 'pertanyaan' => $pertanyaan->{2}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 29, 'wawancara_id' => 29, 'pertanyaan' => $pertanyaan->{3}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 29, 'wawancara_id' => 29, 'pertanyaan' => $pertanyaan->{4}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 29, 'wawancara_id' => 29, 'pertanyaan' => $pertanyaan->{5}->pertanyaan, 'nilai' => 10],

            ['pelamar_id' => 30, 'wawancara_id' => 30, 'pertanyaan' => $pertanyaan->{1}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 30, 'wawancara_id' => 30, 'pertanyaan' => $pertanyaan->{2}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 30, 'wawancara_id' => 30, 'pertanyaan' => $pertanyaan->{3}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 30, 'wawancara_id' => 30, 'pertanyaan' => $pertanyaan->{4}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 30, 'wawancara_id' => 30, 'pertanyaan' => $pertanyaan->{5}->pertanyaan, 'nilai' => 10],


            ['pelamar_id' => 31, 'wawancara_id' => 31, 'pertanyaan' => $pertanyaan->{1}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 31, 'wawancara_id' => 31, 'pertanyaan' => $pertanyaan->{2}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 31, 'wawancara_id' => 31, 'pertanyaan' => $pertanyaan->{3}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 31, 'wawancara_id' => 31, 'pertanyaan' => $pertanyaan->{4}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 31, 'wawancara_id' => 31, 'pertanyaan' => $pertanyaan->{5}->pertanyaan, 'nilai' => 10],


            ['pelamar_id' => 32, 'wawancara_id' => 32, 'pertanyaan' => $pertanyaan->{1}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 32, 'wawancara_id' => 32, 'pertanyaan' => $pertanyaan->{2}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 32, 'wawancara_id' => 32, 'pertanyaan' => $pertanyaan->{3}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 32, 'wawancara_id' => 32, 'pertanyaan' => $pertanyaan->{4}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 32, 'wawancara_id' => 32, 'pertanyaan' => $pertanyaan->{5}->pertanyaan, 'nilai' => 10],


            ['pelamar_id' => 33, 'wawancara_id' => 33, 'pertanyaan' => $pertanyaan->{1}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 33, 'wawancara_id' => 33, 'pertanyaan' => $pertanyaan->{2}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 33, 'wawancara_id' => 33, 'pertanyaan' => $pertanyaan->{3}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 33, 'wawancara_id' => 33, 'pertanyaan' => $pertanyaan->{4}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 33, 'wawancara_id' => 33, 'pertanyaan' => $pertanyaan->{5}->pertanyaan, 'nilai' => 10],


            ['pelamar_id' => 34, 'wawancara_id' => 34, 'pertanyaan' => $pertanyaan->{1}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 34, 'wawancara_id' => 34, 'pertanyaan' => $pertanyaan->{2}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 34, 'wawancara_id' => 34, 'pertanyaan' => $pertanyaan->{3}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 34, 'wawancara_id' => 34, 'pertanyaan' => $pertanyaan->{4}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 34, 'wawancara_id' => 34, 'pertanyaan' => $pertanyaan->{5}->pertanyaan, 'nilai' => 0],


            ['pelamar_id' => 35, 'wawancara_id' => 35, 'pertanyaan' => $pertanyaan->{1}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 35, 'wawancara_id' => 35, 'pertanyaan' => $pertanyaan->{2}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 35, 'wawancara_id' => 35, 'pertanyaan' => $pertanyaan->{3}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 35, 'wawancara_id' => 35, 'pertanyaan' => $pertanyaan->{4}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 35, 'wawancara_id' => 35, 'pertanyaan' => $pertanyaan->{5}->pertanyaan, 'nilai' => 10],


            ['pelamar_id' => 36, 'wawancara_id' => 36, 'pertanyaan' => $pertanyaan->{1}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 36, 'wawancara_id' => 36, 'pertanyaan' => $pertanyaan->{2}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 36, 'wawancara_id' => 36, 'pertanyaan' => $pertanyaan->{3}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 36, 'wawancara_id' => 36, 'pertanyaan' => $pertanyaan->{4}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 36, 'wawancara_id' => 36, 'pertanyaan' => $pertanyaan->{5}->pertanyaan, 'nilai' => 10],


            ['pelamar_id' => 37, 'wawancara_id' => 37, 'pertanyaan' => $pertanyaan->{1}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 37, 'wawancara_id' => 37, 'pertanyaan' => $pertanyaan->{2}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 37, 'wawancara_id' => 37, 'pertanyaan' => $pertanyaan->{3}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 37, 'wawancara_id' => 37, 'pertanyaan' => $pertanyaan->{4}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 37, 'wawancara_id' => 37, 'pertanyaan' => $pertanyaan->{5}->pertanyaan, 'nilai' => 10],


            ['pelamar_id' => 38, 'wawancara_id' => 38, 'pertanyaan' => $pertanyaan->{1}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 38, 'wawancara_id' => 38, 'pertanyaan' => $pertanyaan->{2}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 38, 'wawancara_id' => 38, 'pertanyaan' => $pertanyaan->{3}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 38, 'wawancara_id' => 38, 'pertanyaan' => $pertanyaan->{4}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 38, 'wawancara_id' => 38, 'pertanyaan' => $pertanyaan->{5}->pertanyaan, 'nilai' => 10],

            ['pelamar_id' => 39, 'wawancara_id' => 39, 'pertanyaan' => $pertanyaan->{1}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 39, 'wawancara_id' => 39, 'pertanyaan' => $pertanyaan->{2}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 39, 'wawancara_id' => 39, 'pertanyaan' => $pertanyaan->{3}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 39, 'wawancara_id' => 39, 'pertanyaan' => $pertanyaan->{4}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 39, 'wawancara_id' => 39, 'pertanyaan' => $pertanyaan->{5}->pertanyaan, 'nilai' => 10],


            ['pelamar_id' => 40, 'wawancara_id' => 40, 'pertanyaan' => $pertanyaan->{1}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 40, 'wawancara_id' => 40, 'pertanyaan' => $pertanyaan->{2}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 40, 'wawancara_id' => 40, 'pertanyaan' => $pertanyaan->{3}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 40, 'wawancara_id' => 40, 'pertanyaan' => $pertanyaan->{4}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 40, 'wawancara_id' => 40, 'pertanyaan' => $pertanyaan->{5}->pertanyaan, 'nilai' => 10],

            ['pelamar_id' => 41, 'wawancara_id' => 41, 'pertanyaan' => $pertanyaan->{1}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 41, 'wawancara_id' => 41, 'pertanyaan' => $pertanyaan->{2}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 41, 'wawancara_id' => 41, 'pertanyaan' => $pertanyaan->{3}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 41, 'wawancara_id' => 41, 'pertanyaan' => $pertanyaan->{4}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 41, 'wawancara_id' => 41, 'pertanyaan' => $pertanyaan->{5}->pertanyaan, 'nilai' => 10],

            ['pelamar_id' => 42, 'wawancara_id' => 42, 'pertanyaan' => $pertanyaan->{1}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 42, 'wawancara_id' => 42, 'pertanyaan' => $pertanyaan->{2}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 42, 'wawancara_id' => 42, 'pertanyaan' => $pertanyaan->{3}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 42, 'wawancara_id' => 42, 'pertanyaan' => $pertanyaan->{4}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 42, 'wawancara_id' => 42, 'pertanyaan' => $pertanyaan->{5}->pertanyaan, 'nilai' => 10],

            ['pelamar_id' => 43, 'wawancara_id' => 43, 'pertanyaan' => $pertanyaan->{1}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 43, 'wawancara_id' => 43, 'pertanyaan' => $pertanyaan->{2}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 43, 'wawancara_id' => 43, 'pertanyaan' => $pertanyaan->{3}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 43, 'wawancara_id' => 43, 'pertanyaan' => $pertanyaan->{4}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 43, 'wawancara_id' => 43, 'pertanyaan' => $pertanyaan->{5}->pertanyaan, 'nilai' => 10],

            ['pelamar_id' => 44, 'wawancara_id' => 44, 'pertanyaan' => $pertanyaan->{1}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 44, 'wawancara_id' => 44, 'pertanyaan' => $pertanyaan->{2}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 44, 'wawancara_id' => 44, 'pertanyaan' => $pertanyaan->{3}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 44, 'wawancara_id' => 44, 'pertanyaan' => $pertanyaan->{4}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 44, 'wawancara_id' => 44, 'pertanyaan' => $pertanyaan->{5}->pertanyaan, 'nilai' => 10],

            ['pelamar_id' => 45, 'wawancara_id' => 45, 'pertanyaan' => $pertanyaan->{1}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 45, 'wawancara_id' => 45, 'pertanyaan' => $pertanyaan->{2}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 45, 'wawancara_id' => 45, 'pertanyaan' => $pertanyaan->{3}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 45, 'wawancara_id' => 45, 'pertanyaan' => $pertanyaan->{4}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 45, 'wawancara_id' => 45, 'pertanyaan' => $pertanyaan->{5}->pertanyaan, 'nilai' => 10],

            ['pelamar_id' => 46, 'wawancara_id' => 46, 'pertanyaan' => $pertanyaan->{1}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 46, 'wawancara_id' => 46, 'pertanyaan' => $pertanyaan->{2}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 46, 'wawancara_id' => 46, 'pertanyaan' => $pertanyaan->{3}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 46, 'wawancara_id' => 46, 'pertanyaan' => $pertanyaan->{4}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 46, 'wawancara_id' => 46, 'pertanyaan' => $pertanyaan->{5}->pertanyaan, 'nilai' => 20],

            ['pelamar_id' => 47, 'wawancara_id' => 47, 'pertanyaan' => $pertanyaan->{1}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 47, 'wawancara_id' => 47, 'pertanyaan' => $pertanyaan->{2}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 47, 'wawancara_id' => 47, 'pertanyaan' => $pertanyaan->{3}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 47, 'wawancara_id' => 47, 'pertanyaan' => $pertanyaan->{4}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 47, 'wawancara_id' => 47, 'pertanyaan' => $pertanyaan->{5}->pertanyaan, 'nilai' => 10],


            ['pelamar_id' => 48, 'wawancara_id' => 48, 'pertanyaan' => $pertanyaan->{1}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 48, 'wawancara_id' => 48, 'pertanyaan' => $pertanyaan->{2}->pertanyaan, 'nilai' => 10],
            ['pelamar_id' => 48, 'wawancara_id' => 48, 'pertanyaan' => $pertanyaan->{3}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 48, 'wawancara_id' => 48, 'pertanyaan' => $pertanyaan->{4}->pertanyaan, 'nilai' => 20],
            ['pelamar_id' => 48, 'wawancara_id' => 48, 'pertanyaan' => $pertanyaan->{5}->pertanyaan, 'nilai' => 10],

        ]);
    }
}
