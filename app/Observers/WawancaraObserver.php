<?php

namespace App\Observers;

use App\Http\Controllers\ModelController;
use App\Mail\SendResultEmail;
use App\Models\Notification;
use App\Models\Penilaian;
use App\Models\Pertanyaan;
use App\Models\Wawancara;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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

        $dataPelamar = DB::table('pelamars as p')
            ->leftJoin('tes as t', 'p.id', '=', 't.pelamar_id')
            ->leftJoin('evaluasis as e', 'p.id', '=', 'e.pelamar_id')
            ->leftJoin('kriterias as k', 'e.kriteria_id', '=', 'k.id')
            ->leftJoin('wawancaras as w', 'p.id', '=', 'w.pelamar_id')
            ->leftJoin('penilaians as n', 'p.id', '=', 'n.pelamar_id')
            ->select([
                'p.id as pelamar_id',
                'p.nama as nama',
                DB::raw("MAX(CASE WHEN k.judul = 'riwayat' THEN e.nilai END) as riwayat"),
                DB::raw("MAX(CASE WHEN k.judul = 'ktp' THEN e.nilai END) as ktp"),
                DB::raw("MAX(CASE WHEN k.judul = 'skck' THEN e.nilai END) as skck"),
                DB::raw("MAX(CASE WHEN k.judul = 'ijazah' THEN e.nilai END) as ijazah"),
                DB::raw("MAX(CASE WHEN t.jenis = 'buta_warna' THEN t.nilai END) as buta_warna"),
                DB::raw("MAX(CASE WHEN t.jenis = 'kemampuan' THEN t.nilai END) as kemampuan"),
                'w.nilai as wawancara',
                'n.status as status',
                DB::raw("
                    COALESCE(MAX(CASE WHEN k.judul = 'riwayat' THEN e.nilai END), 0) +
                    COALESCE(MAX(CASE WHEN k.judul = 'ktp' THEN e.nilai END), 0) +
                    COALESCE(MAX(CASE WHEN k.judul = 'skck' THEN e.nilai END), 0) +
                    COALESCE(MAX(CASE WHEN k.judul = 'ijazah' THEN e.nilai END), 0) +
                    COALESCE(MAX(CASE WHEN t.jenis = 'buta_warna' THEN t.nilai END), 0) +
                    COALESCE(MAX(CASE WHEN t.jenis = 'kemampuan' THEN t.nilai END), 0) +
                    COALESCE(w.nilai, 0) +
                    COALESCE(n.status, 0) AS total")
            ])
            ->where('p.id', $penilaian->pelamar_id)
            ->groupBy('p.id', 'p.nama', 'w.nilai', 'n.status')
            ->first();

        $pertanyaans = Pertanyaan::where('pelamar_id', $penilaian->pelamar_id)
            ->where('wawancara_id', $wawancara->id)->get();
        $pertanyaansRow = '';

        foreach ($pertanyaans as $pertanyaan) {
            $pertanyaansRow .= '
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            ' . $pertanyaan->pertanyaan . '
                        </th>
                        <td class="px-6 py-4 font-medium text-center text-gray-900 whitespace-nowrap dark:text-white">
                            ' . ($pertanyaan->nilai == 20 ? '<svg width="12px" height="12px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M173.9 439.4l-166.4-166.4c-10-10-10-26.2 0-36.2l36.2-36.2c10-10 26.2-10 36.2 0L192 312.7 432.1 72.6c10-10 26.2-10 36.2 0l36.2 36.2c10 10 10 26.2 0 36.2l-294.4 294.4c-10 10-26.2 10-36.2 0z"/></svg>' : '') . '
                        </td>
                        <td class="px-6 py-4 font-medium text-center text-gray-900 whitespace-nowrap dark:text-white">
                            ' . ($pertanyaan->nilai == 10 ? '<svg width="12px" height="12px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M173.9 439.4l-166.4-166.4c-10-10-10-26.2 0-36.2l36.2-36.2c10-10 26.2-10 36.2 0L192 312.7 432.1 72.6c10-10 26.2-10 36.2 0l36.2 36.2c10 10 10 26.2 0 36.2l-294.4 294.4c-10 10-26.2 10-36.2 0z"/></svg>' : '') . '
                        </td>
                        <td class="px-6 py-4 font-medium text-center text-gray-900 whitespace-nowrap dark:text-white">
                            ' . ($pertanyaan->nilai == 0 ? '<svg width="12px" height="12px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M173.9 439.4l-166.4-166.4c-10-10-10-26.2 0-36.2l36.2-36.2c10-10 26.2-10 36.2 0L192 312.7 432.1 72.6c10-10 26.2-10 36.2 0l36.2 36.2c10 10 10 26.2 0 36.2l-294.4 294.4c-10 10-26.2 10-36.2 0z"/></svg>' : '') . '
                        </td>
                    </tr>
            ';
        }

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
        <div class="relative overflow-x-auto">
            <div class="text-center">
                <h1><strong>Hasil Penilaian</strong></h1>
            </div>
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Riwayat
                        </th>
                        <th scope="col" class="px-6 py-3">
                            KTP
                        </th>
                        <th scope="col" class="px-6 py-3">
                            SKCK
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Ijazah
                        </th>
                        <th scope="col" class="px-6 py-3">
                            buta Warna
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Kemampuan
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Wawancara
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Total
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                        <th scope="row" class="px-6 py-4 font-medium text-center text-gray-900 whitespace-nowrap dark:text-white">
                            ' . $dataPelamar->riwayat . '
                        </th>
                        <td class="px-6 py-4 font-medium text-center text-gray-900 whitespace-nowrap dark:text-white">
                            ' . $dataPelamar->ktp . '
                        </td>
                        <td class="px-6 py-4 font-medium text-center text-gray-900 whitespace-nowrap dark:text-white">
                            ' . $dataPelamar->skck . '
                        </td>
                        <td class="px-6 py-4 font-medium text-center text-gray-900 whitespace-nowrap dark:text-white">
                            ' . $dataPelamar->ijazah . '
                        </td>
                        <td class="px-6 py-4 font-medium text-center text-gray-900 whitespace-nowrap dark:text-white">
                            ' . $dataPelamar->buta_warna . '
                        </td>
                        <td class="px-6 py-4 font-medium text-center text-gray-900 whitespace-nowrap dark:text-white">
                            ' . $dataPelamar->kemampuan . '
                        </td>
                        <td class="px-6 py-4 font-medium text-center text-gray-900 whitespace-nowrap dark:text-white">
                            ' . $dataPelamar->wawancara . '
                        </td>
                        <td class="px-6 py-4 font-medium text-center text-gray-900 whitespace-nowrap dark:text-white">
                            ' . $dataPelamar->total . '
                        </td>
                    </tr>
                </tbody>
            </table>
            </div>
            <div class="relative overflow-x-auto mt-10">
            <div class="text-center">
                <h1><strong>Hasil Wawancara</strong></h1>
            </div>
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Pertanyaan
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Sangat Baik
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Baik
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Kurang
                        </th>
                    </tr>
                </thead>
                <tbody>
                   ' . $pertanyaansRow . '
                </tbody>
                <tfoot>
                    <tr class="font-semibold text-gray-900 dark:text-white">
                        <th colspan="3" scope="row" class="px-6 py-3 text-base">
                            Total
                        </th>
                        <td>' . $wawancara->nilai . '</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        </div>
    </div>
            '
        ]);
    }
}
