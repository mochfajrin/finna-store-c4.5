<?php

namespace App\Filament\Resources\EvaluasiResource\Pages;

use App\Filament\Resources\EvaluasiResource;
use App\Models\Evaluasi;
use App\Models\Lowongan;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateEvaluasi extends CreateRecord
{
    protected static string $resource = EvaluasiResource::class;
    protected function handleRecordCreation(array $data): Model
    {
        $pelamarId = $data['pelamar_id'];
        $lowongan = Lowongan::find($data['lowongan_id']);
        if ($data['ijazah']) {
            $nilai = 0;
            if ($data['ijazah'] == 'sd') {
                $nilai = 25;
            }
            if ($data['ijazah'] == 'smp') {
                $nilai = 50;
            }
            if ($data['ijazah'] == 'sma') {
                $nilai = 75;
            }
            if ($data['ijazah'] == 'perguruan_tinggi') {
                $nilai = 100;
            }
            Evaluasi::create([
                'pelamar_id' => $pelamarId,
                'kriteria_id' => $lowongan->kriterias()->where('judul', 'ijazah')->first()->id,
                'nilai' => $nilai
            ]);
        }
        if ($data['riwayat']) {
            Evaluasi::create([
                'pelamar_id' => $pelamarId,
                'kriteria_id' => $lowongan->kriterias()->where('judul', 'ijazah')->first()->id,
                'nilai' => $data['riwayat']
            ]);
        }
        if (isset($data['skck'])) {
            $nilai = $data['skck'] ? 10 : 0;
            Evaluasi::create([
                'pelamar_id' => $pelamarId,
                'kriteria_id' => $lowongan->kriterias()->where('judul', 'skck')->first()->id,
                'nilai' => $data['skck']
            ]);
        }
        if (isset($data['ktp'])) {
            $nilai = $data['ktp'] ? 10 : 0;
            Evaluasi::create([
                'pelamar_id' => $pelamarId,
                'kriteria_id' => $lowongan->kriterias()->where('judul', 'ktp')->first()->id,
                'nilai' => $data['ktp']
            ]);
        }
        return Evaluasi::create(['pelamar_id' => 1, 'kriteria_id' => 1, 'nilai' => 120]);
    }
}
