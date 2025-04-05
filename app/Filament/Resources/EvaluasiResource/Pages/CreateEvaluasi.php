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
        $evaluasi = null; // Variabel untuk menyimpan instance Evaluasi yang dibuat

        if ($data['ijazah']) {
            $nilai = match ($data['ijazah']) {
                'tidak_ada' => 0,
                'sd' => 25,
                'smp' => 50,
                'sma' => 75,
                'perguruan_tinggi' => 100,
                default => 0,
            };

            $kriteriaId = $lowongan->kriterias()->where('judul', 'ijazah')->first()->id;
            if (!Evaluasi::where('kriteria_id', $kriteriaId)->where('pelamar_id', $pelamarId)->exists()) {
                $evaluasi = Evaluasi::create([
                    'pelamar_id' => $pelamarId,
                    'kriteria_id' => $kriteriaId,
                    'nilai' => $nilai
                ]);
            }
        }

        if (isset($data['riwayat'])) {
            $kriteriaId = $lowongan->kriterias()->where('judul', 'riwayat')->first()->id;
            if (!Evaluasi::where('kriteria_id', $kriteriaId)->where('pelamar_id', $pelamarId)->exists()) {
                $evaluasi = Evaluasi::create([
                    'pelamar_id' => $pelamarId,
                    'kriteria_id' => $kriteriaId,
                    'nilai' => $data['riwayat'] || 0
                ]);
            }
        }
        if (isset($data['skck'])) {
            $nilai = $data['skck'] ? 100 : 0;
            $kriteriaId = $lowongan->kriterias()->where('judul', 'skck')->first()->id;
            if (!Evaluasi::where('kriteria_id', $kriteriaId)->where('pelamar_id', $pelamarId)->exists()) {
                $evaluasi = Evaluasi::create([
                    'pelamar_id' => $pelamarId,
                    'kriteria_id' => $kriteriaId,
                    'nilai' => $nilai
                ]);
            }
        }
        if (isset($data['ktp'])) {
            $nilai = $data['ktp'] ? 100 : 0;
            $kriteriaId = $lowongan->kriterias()->where('judul', 'ktp')->first()->id;
            if (!Evaluasi::where('kriteria_id', $kriteriaId)->where('pelamar_id', $pelamarId)->exists()) {
                $evaluasi = Evaluasi::create([
                    'pelamar_id' => $pelamarId,
                    'kriteria_id' => $kriteriaId,
                    'nilai' => $nilai
                ]);
            }
        }
        return $evaluasi ?? new Evaluasi();
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
