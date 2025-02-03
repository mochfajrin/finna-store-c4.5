<?php

namespace App\Http\Controllers;

use App\Enums\PelamarGender;
use App\Mail\SendInterviewMail;
use App\Mail\SendTestMail;
use App\Models\Lowongan;
use App\Models\Pelamar;
use App\Models\Tes;
use App\Models\User;
use App\Models\Wawancara;
use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class PelamarController extends Controller
{
    public function registerForm(Lowongan $lowongan)
    {
        return view('pelamar.register-form', ['lowongan' => $lowongan]);
    }
    public function register(Request $request, int $lowonganId)
    {
        $request->validate([
            'nama' => 'string|required|min:1|max:255',
            'jenis_kelamin' => [Rule::enum(PelamarGender::class), 'required'],
            'no_telepon' => 'string|required|min:8',
            'email' => 'email|required',
            'alamat' => 'string|required|min:1|max:255',
            'tanggal_lahir' => 'date|required',
            'url_foto' => 'required|mimes:jpg,png,jpeg,pdf',
            'url_ijazah' => 'required|mimes:jpg,png,jpeg,pdf',
            'url_ktp' => 'required|mimes:jpg,png,jpeg,pdf',
            'url_skck' => 'required|mimes:jpg,png,jpeg,pdf',
            'url_riwayat' => 'required|mimes:jpg,png,jpeg,pdf',
        ]);
        $urlFoto = $this->storeFile($request->file('url_foto'), 'lamaran/foto');
        $urlIjazah = $this->storeFile($request->file('url_ijazah'), 'lamaran/ijazah');
        $urlKtp = $this->storeFile($request->file('url_ktp'), 'lamaran/ktp');
        $urlSkck = $this->storeFile($request->file('url_skck'), 'lamaran/skck');
        $urlRiwayat = $this->storeFile($request->file('url_riwayat'), 'lamaran/riwayat');

        $pelamar = Pelamar::create([
            'lowongan_id' => $lowonganId,
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_telepon' => $request->no_telepon,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'tanggal_lahir' => $request->tanggal_lahir,
            'url_foto' => $urlFoto,
            'url_ijazah' => $urlIjazah,
            'url_ktp' => $urlKtp,
            'url_skck' => $urlSkck,
            'url_riwayat' => $urlRiwayat,
        ]);
        $encryptedPayload = Crypt::encryptString($pelamar->id);

        $data = [
            'subject' => "Pengerjaan Tes Rekruitmen - " . config('app.name'),
            'buta_warna' => config('app.url') . "/test/buta-warna/$encryptedPayload",
            'kemampuan' => config('app.url') . "/test/kemampuan/$encryptedPayload",
            'nama' => $pelamar->nama
        ];
        Mail::to($pelamar->email)->send(new SendTestMail($data));
        return redirect("lamaran/mail/$encryptedPayload");

    }
    public function colorBlindTest($encryptedPayload)
    {
        try {
            $id = Crypt::decryptString($encryptedPayload);
            $tes = Tes::where('pelamar_id', $id)->where('jenis', 'buta_warna')->first();
            $current = round(microtime(true) * 1000);
            if (!$tes) {
                $endAt = $current + 1800000;
                $tes = Tes::create([
                    'pelamar_id' => $id,
                    'jenis' => "buta_warna",
                    'nilai' => 0,
                    'start_at' => $current,
                    'end_at' => $endAt
                ]);
            }
            if ($tes && $tes->end_at <= $current) {
                return abort(419);
            }
            if ($tes && $tes->is_finished) {
                return abort(419);
            }
            $encryptedTestPayload = Crypt::encryptString($tes->id);
            return view("pelamar.color-blind-test", ['tes' => $tes, 'encryptedTestPayload' => $encryptedTestPayload]);
        } catch (DecryptException $e) {

        }
    }
    public function colorBlindTestSubmit(Request $request, $encryptedTestPayload)
    {
        $testId = (int) Crypt::decryptString($encryptedTestPayload);
        $tes = Tes::where('id', $testId)->first();
        $current = round(microtime(true) * 1000);
        if ($tes && $tes->end_at <= $current) {
            return abort(419);
        }
        if ($tes && $tes->is_finished) {
            return abort(419);
        }
        if (!$tes) {
            return abort(404);
        }
        $tes->is_finished = true;

        $correctAnswers = [
            '7',
            '6',
            '26',
            '15',
            '6',
            '73',
            '5',
            '16',
            '46',
            '12'
        ];
        $total = 0;
        if ($request->input("jawaban-1") === $correctAnswers[0]) {
            $total += 10;
        }
        if ($request->input("jawaban-2") === $correctAnswers[1]) {
            $total += 10;
        }
        if ($request->input("jawaban-3") === $correctAnswers[2]) {
            $total += 10;
        }
        if ($request->input("jawaban-4") === $correctAnswers[3]) {
            $total += 10;
        }
        if ($request->input("jawaban-5") === $correctAnswers[4]) {
            $total += 10;
        }
        if ($request->input("jawaban-6") === $correctAnswers[5]) {
            $total += 10;
        }
        if ($request->input("jawaban-7") === $correctAnswers[6]) {
            $total += 10;
        }
        if ($request->input("jawaban-8") === $correctAnswers[7]) {
            $total += 10;
        }
        if ($request->input("jawaban-9") === $correctAnswers[8]) {
            $total += 10;
        }
        if ($request->input("jawaban-10") === $correctAnswers[9]) {
            $total += 10;
        }
        $tes->nilai = $total;
        $tes->save();
        $this->sendInterviewEmail($tes->pelamar()->first()->id);
        return redirect('thanks');
    }
    public function abilityTest(Request $request, $encryptedPayload)
    {
        try {
            $id = Crypt::decryptString($encryptedPayload);
            $tes = Tes::where('pelamar_id', $id)->where('jenis', 'kemampuan')->first();
            $current = round(microtime(true) * 1000);
            if (!$tes) {
                $endAt = $current + 1800000;
                $tes = Tes::create([
                    'pelamar_id' => $id,
                    'jenis' => "kemampuan",
                    'nilai' => 0,
                    'start_at' => $current,
                    'end_at' => $endAt
                ]);
            }
            if ($tes && $tes->end_at <= $current) {
                return abort(419);
            }
            if ($tes && $tes->is_finished) {
                return abort(419);
            }
            $encryptedTestPayload = Crypt::encryptString($tes->id);
            $questions = [
                [
                    "question" => "Apa yang harus Anda sertakan dalam CV untuk menarik perhatian perekrut?",
                    "options" => [
                        "A" => "Hobi dan warna favorit",
                        "B" => "Pengalaman kerja yang relevan",
                        "C" => "Nama semua anggota keluarga",
                        "D" => "Daftar lengkap mata pelajaran di sekolah"
                    ],
                    "answer" => "B"
                ],
                [
                    "question" => "Saat menghadiri wawancara kerja, apa yang paling penting untuk dilakukan?",
                    "options" => [
                        "A" => "Datang tepat waktu dan berpakaian profesional",
                        "B" => "Mengabaikan pertanyaan yang tidak disukai",
                        "C" => "Berbicara dengan santai tanpa persiapan",
                        "D" => "Meminta gaji sebelum ditanya oleh pewawancara"
                    ],
                    "answer" => "A"
                ],
                [
                    "question" => "Bagaimana cara menjawab pertanyaan 'Apa kelebihan Anda?' dalam wawancara kerja?",
                    "options" => [
                        "A" => "Menyebutkan kelebihan yang sesuai dengan pekerjaan yang dilamar",
                        "B" => "Mengatakan bahwa tidak memiliki kelebihan",
                        "C" => "Menyebutkan sebanyak mungkin kelebihan tanpa bukti",
                        "D" => "Menghindari pertanyaan dan membahas hal lain"
                    ],
                    "answer" => "A"
                ],
                [
                    "question" => "Apa tujuan utama dari surat lamaran kerja?",
                    "options" => [
                        "A" => "Untuk menjelaskan alasan mengapa Anda ingin bekerja di perusahaan tersebut",
                        "B" => "Untuk menceritakan seluruh riwayat hidup secara detail",
                        "C" => "Untuk mengkritik perusahaan sebelumnya",
                        "D" => "Untuk meminta pekerjaan tanpa alasan yang jelas"
                    ],
                    "answer" => "A"
                ],
                [
                    "question" => "Apa yang harus dilakukan setelah mengirimkan lamaran kerja?",
                    "options" => [
                        "A" => "Menunggu tanpa melakukan apa pun",
                        "B" => "Menghubungi perusahaan secara berlebihan setiap hari",
                        "C" => "Mengirim email tindak lanjut setelah beberapa hari jika tidak ada respons",
                        "D" => "Langsung melamar ke perusahaan lain tanpa menunggu respons"
                    ],
                    "answer" => "C"
                ],
                [
                    "question" => "Bagaimana cara menunjukkan kemampuan kerja tim dalam wawancara?",
                    "options" => [
                        "A" => "Menceritakan pengalaman bekerja sama dalam tim dan kontribusi yang diberikan",
                        "B" => "Mengatakan bahwa lebih suka bekerja sendiri",
                        "C" => "Menghindari pertanyaan ini karena tidak suka bekerja dalam tim",
                        "D" => "Mengatakan bahwa tidak pernah bekerja dalam tim sebelumnya"
                    ],
                    "answer" => "A"
                ],
                [
                    "question" => "Dalam email lamaran kerja, apa yang harus ada dalam subjek email?",
                    "options" => [
                        "A" => "Hanya nama lengkap",
                        "B" => "Judul pekerjaan yang dilamar dan nama pelamar",
                        "C" => "Kalimat panjang yang menjelaskan isi email",
                        "D" => "Subjek dibiarkan kosong"
                    ],
                    "answer" => "B"
                ],
                [
                    "question" => "Apa yang harus Anda lakukan jika ditanya tentang gaji yang diharapkan?",
                    "options" => [
                        "A" => "Memberikan kisaran gaji berdasarkan riset dan pengalaman",
                        "B" => "Mengatakan tidak tahu dan menyerahkannya ke perusahaan",
                        "C" => "Meminta gaji setinggi mungkin tanpa alasan",
                        "D" => "Menolak menjawab pertanyaan"
                    ],
                    "answer" => "A"
                ],
                [
                    "question" => "Mengapa penting untuk menyesuaikan CV dengan pekerjaan yang dilamar?",
                    "options" => [
                        "A" => "Agar terlihat lebih profesional dan relevan",
                        "B" => "Agar bisa memasukkan informasi sebanyak mungkin",
                        "C" => "Agar semua perusahaan menerima CV yang sama",
                        "D" => "Agar bisa menghindari wawancara kerja"
                    ],
                    "answer" => "A"
                ],
                [
                    "question" => "Apa yang harus dilakukan jika tidak diterima dalam suatu pekerjaan?",
                    "options" => [
                        "A" => "Belajar dari pengalaman dan meningkatkan keterampilan",
                        "B" => "Menyerah dan tidak melamar pekerjaan lain",
                        "C" => "Mengirim email marah ke perusahaan",
                        "D" => "Berhenti mencari pekerjaan sama sekali"
                    ],
                    "answer" => "A"
                ]
            ];

            return view(
                "pelamar.ability-test",
                [
                    'questions' => $questions,
                    'tes' => $tes,
                    'encryptedTestPayload' => $encryptedTestPayload
                ]
            );
        } catch (DecryptException $e) {
            return abort(404);
        }
    }
    public function abilityTestSubmit(Request $request, $encryptedTestPayload)
    {
        try {
            $testId = (int) Crypt::decryptString($encryptedTestPayload);
            $tes = Tes::where('id', $testId)->first();
            $current = round(microtime(true) * 1000);

            if (!$tes) {
                return abort(404);
            }
            if ($tes && $tes->end_at <= $current) {
                return abort(419);
            }
            if ($tes && $tes->is_finished) {
                return abort(419);
            }
            if (!$tes) {
                return abort(404);
            }

            $total = 0;

            if ($request->input("jawaban-1") === 'B') {
                $total += 10;
            }
            if ($request->input("jawaban-2") === 'A') {
                $total += 10;
            }
            if ($request->input("jawaban-3") === 'A') {
                $total += 10;
            }
            if ($request->input("jawaban-4") === 'A') {
                $total += 10;
            }
            if ($request->input("jawaban-5") === 'C') {
                $total += 10;
            }
            if ($request->input("jawaban-6") === 'A') {
                $total += 10;
            }
            if ($request->input("jawaban-7") === 'B') {
                $total += 10;
            }
            if ($request->input("jawaban-8") === 'A') {
                $total += 10;
            }
            if ($request->input("jawaban-9") === 'A') {
                $total += 10;
            }
            if ($request->input("jawaban-10") === 'A') {
                $total += 10;
            }
            $tes->nilai = $total;
            $tes->is_finished = true;
            $tes->save();
            $this->sendInterviewEmail($tes->pelamar()->first()->id);
            return redirect('thanks');
        } catch (DecryptException $e) {
            return abort(404);
        }
    }
    public function sendInterviewEmail($pelamarId)
    {
        $pelamar = Pelamar::where('id', $pelamarId)->first();
        $date = Carbon::parse(Carbon::now());
        $count = 0;

        while ($count < 3) {
            $date->addDay();
            if (!$date->isWeekend()) {
                $count++;
            }
        }

        $colorBlindTest = Tes::where('pelamar_id', $pelamarId)->where('jenis', 'buta_warna')->first();
        $abilityTest = Tes::where('pelamar_id', $pelamarId)->where('jenis', 'kemampuan')->first();
        if ($abilityTest && $colorBlindTest) {
            if ($abilityTest->is_finished && $colorBlindTest->is_finished) {
                $interview = Wawancara::where('pelamar_id', $pelamarId)->first();
                if (!$interview) {
                    Wawancara::create([
                        'user_id' => User::first()->id,
                        'pelamar_id' => $pelamarId,
                        'nilai' => 0
                    ]);
                    $data = [
                        'subject' => "Undangan Interview Kerja - " . config('app.name'),
                        'nama' => $pelamar->nama,
                        'posisi' => $pelamar->lowongan()->first()->judul,
                        'date' => $date->format("Y-m-d")
                    ];
                    Mail::to($pelamar->email)->send(new SendInterviewMail($data));
                }
            }
        }
    }
    public function checkMailPage(string $encryptedPayload)
    {
        try {
            $id = (int) Crypt::decryptString($encryptedPayload);
            $pelamar = Pelamar::where('id', $id)->first();
            if (!$pelamar) {
                return abort(404);
            }
            return view('pelamar.check-mail', ['pelamar' => $pelamar]);
        } catch (DecryptException $e) {
            return abort(404);
        }
    }

    public function storeFile(UploadedFile $file, $path)
    {
        $extension = $file->getExtension();
        $uniqueName = uniqid() . '-' . time() . '.' . $extension;
        $path = $file->storeAs($path, $uniqueName, 'public');
        return $path;
    }
}
