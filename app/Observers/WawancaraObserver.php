<?php

namespace App\Observers;

use App\Http\Controllers\ModelController;
use App\Mail\SendResultEmail;
use App\Models\Notification;
use App\Models\Penilaian;
use App\Models\Wawancara;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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

            Log::info('Instance Data: ' . json_encode($predictedStatus['instance']));
            Log::info('Predicted Status: ' . $predictedStatus['status']);

            $penilaian->status = $predictedStatus['status'];
            $penilaian->save();
        }
        $data = [
            'subject' => 'Pemberitahuan Penerimaan Kerja di ' . config('app.name'),
            'role' => $penilaian->pelamar->lowongan->judul,
            'name' => $penilaian->pelamar->name,
            'year' => Carbon::now()->year,
            'status' => $penilaian->status
        ];
        Mail::to($penilaian->pelamar->email)->send(new SendResultEmail($data));
        Notification::create([
            'title' => "Pemberitahuan penerimaan kerja lowongan {$penilaian->pelamar->lowongan->judul}",
            'type' => 'result',
            'pelamar_id' => $wawancara->pelamar_id
        ]);
    }
}
