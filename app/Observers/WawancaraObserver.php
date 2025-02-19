<?php

namespace App\Observers;

use App\Http\Controllers\ModelController;
use App\Models\Penilaian;
use App\Models\Wawancara;
use Illuminate\Support\Facades\Log;

class WawancaraObserver
{
    public function updated(Wawancara $wawancara): void
    {
        if ($wawancara->getOriginal('nilai') !== $wawancara->nilai) {
            Log::info('Nilai Wawancara: ' . $wawancara->nilai);

            $penilaian = Penilaian::firstOrNew([
                'pelamar_id' => $wawancara->pelamar_id,
            ]);

            $modelController = new ModelController();

            $response = $modelController->calculateC45($penilaian);
            $predictedStatus = $response->getData(true);

            Log::info('Predicted Status: ' . $predictedStatus['status']);

            $penilaian->status = $predictedStatus['status'];
            $penilaian->save();
        }
    }
}
