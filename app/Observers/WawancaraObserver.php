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
            'name' => $penilaian->pelamar->nama,
            'year' => Carbon::now()->year,
            'status' => $penilaian->status
        ];
        // Mail::to($penilaian->pelamar->email)->send(new SendResultEmail($data));
        Notification::create([
            'title' => "Pemberitahuan penerimaan kerja lowongan {$penilaian->pelamar->lowongan->judul}",
            'type' => 'result',
            'pelamar_id' => $wawancara->pelamar_id,
            'content' => '
            <div class="container">
        <div class="header">
        ' . ($data['status'] ? ' <h1>Selamat! Anda Diterima</h1>' : '<h1>Terima Kasih Atas Lamaran Anda</h1>') . '
        </div>
        ' . ($data['status'] ? ' <div class="content">
                <p>Kepada Yth. <strong>' . $data['name'] . '</strong>,</p>
                <p>Kami dengan senang hati menginformasikan bahwa Anda telah diterima untuk bergabung dengan tim kami di
                    <strong>' . config('app.name') . '</strong> sebagai <strong>' . $data['role'] . '</strong>.
                </p>
                <p>Selanjutnya, kami akan menghubungi Anda untuk proses orientasi dan kelengkapan administrasi. Silakan
                    menghubungi tim HRD kami jika ada pertanyaan lebih lanjut.</p>
                <p>Selamat bergabung! Kami sangat antusias untuk bekerja sama dengan Anda.</p>
                <p>Salam hangat,<br>
                    Tim Recruitment<br>
                    ' . config('app.name') . '
                </p>
            </div>' : '<div class="content">
                <p>Kepada Yth. <strong>' . $data['name'] . '</strong>,</p>
                <p>Terima kasih telah meluangkan waktu untuk melamar posisi <strong>' . $data['role'] . '</strong> di
                    <strong>' . config('app.name') . '</strong>. Kami sangat menghargai minat dan usaha Anda.
                </p>
                <p>Setelah mempertimbangkan dengan saksama, kami memutuskan untuk melanjutkan proses rekrutmen dengan
                    kandidat lain. Namun, kami akan menyimpan data Anda dan tidak menutup kemungkinan untuk bekerja sama
                    di masa mendatang.</p>
                <p>Kami mengucapkan semoga sukses dalam perjalanan karier Anda ke depannya.</p>
                <p>Salam hangat,<br>
                    Tim Recruitment<br>
                    ' . config('app.name') . '
                </p>
            </div>') . '
    </div>
            '
        ]);
    }
}
