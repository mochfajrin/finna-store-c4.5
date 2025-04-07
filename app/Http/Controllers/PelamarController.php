<?php

namespace App\Http\Controllers;

use App\Enums\PelamarGender;
use App\Mail\SendInterviewMail;
use App\Mail\SendTestMail;
use App\Models\Lowongan;
use App\Models\Notification;
use App\Models\Pelamar;
use App\Models\Tes;
use App\Models\User;
use App\Models\Wawancara;
use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class PelamarController extends Controller
{
    public function registerForm(Lowongan $lowongan)
    {
        $isKtp = $lowongan->kriterias()->where('judul', 'ktp')->exists();
        $isIjazah = $lowongan->kriterias()->where('judul', 'ijazah')->exists();
        $isSkck = $lowongan->kriterias()->where('judul', 'skck')->exists();
        $isRiwayat = $lowongan->kriterias()->where('judul', 'riwayat')->exists();

        return view('pelamar.register-form', [
            'lowongan' => $lowongan,
            'isKtp' => $isKtp,
            'isIjazah' => $isIjazah,
            'isSkck' => $isSkck,
            'isRiwayat' => $isRiwayat,
        ]);
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
            'url_ijazah' => 'mimes:jpg,png,jpeg,pdf',
            'url_ktp' => 'mimes:jpg,png,jpeg,pdf',
            'url_skck' => 'mimes:jpg,png,jpeg,pdf',
            'url_riwayat' => 'mimes:jpg,png,jpeg,pdf',
        ]);

        $data = [
            'lowongan_id' => $lowonganId,
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_telepon' => $request->no_telepon,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'tanggal_lahir' => $request->tanggal_lahir,
            'user_id' => Auth::user()->id,
            'url_foto' => '',
            'url_ijazah' => '',
            'url_ktp' => '',
            'url_skck' => '',
            'url_riwayat' => '',
        ];
        $data['url_foto'] = $this->storeFile($request->file('url_foto'), 'lamaran/foto');
        if ($request->file('url_ijazah')) {
            $data['url_ijazah'] = $this->storeFile($request->file('url_ijazah'), 'lamaran/ijazah');
        }
        if ($request->file('url_ktp')) {
            $data['url_ktp'] = $this->storeFile($request->file('url_ktp'), 'lamaran/ktp');
        }
        if ($request->file('url_skck')) {
            $data['url_skck'] = $this->storeFile($request->file('url_skck'), 'lamaran/skck');
        }
        if ($request->file('url_riwayat')) {
            $data['url_riwayat'] = $this->storeFile($request->file('url_riwayat'), 'lamaran/riwayat');
        }

        $pelamar = Pelamar::create($data);
        $encryptedPayload = Crypt::encryptString($pelamar->id);
        $namaLowongan = Lowongan::find($lowonganId)->judul;

        $data = [
            'subject' => "Pengerjaan Tes Rekruitmen - " . config('app.name'),
            'test' => config('app.url') . "/test/$encryptedPayload",
            'nama' => $pelamar->nama,
            'nama_lowongan' => $namaLowongan
        ];
        // Mail::to($pelamar->email)->send(new SendTestMail($data));
        $namaLowongan = Lowongan::find($lowonganId)->judul;
        Notification::create([
            'title' => "Pengerjaan Tes Rekruitmen - $namaLowongan",
            'pelamar_id' => $pelamar->id,
            'content' => '
            <h2 class="text-gray-700 dark:text-gray-200">Hallo ,' . $data["nama"] . ',</h2>

            <p class="mt-2 leading-loose text-gray-600 dark:text-gray-300">
                Terima kasih atas minat Anda untuk bergabung dengan Finna Store. Kami mengundang Anda untuk mengikuti
                tes online kesehatan (buta warna) dan keterampilan sebagai bagian dari proses seleksi karyawan kami
                sebagai ' . $data["nama_lowongan"] . '.
            </p>
            <strong>Waktu masing-masing tes adalah 30 menit dan waktu akan langsung berjalan ketika mengklik link
                dibawah</strong>
            <br>
            <a href="' . $data["test"] . '"
                class="px-6 py-2 mt-4 text-sm font-medium tracking-wider text-white capitalize transition-colors duration-300 transform bg-blue-600 rounded-lg hover:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80 block"
                style="width: fit-content;">
                Tes Masuk
            </a>
            <br>

            <p class="mt-8 text-gray-600 dark:text-gray-300">
                Terima kasih, <br>
                ' . config("app.name") . '
            </p>
            ',
            'type' => 'test'
        ]);
        return redirect("/users/notifications");

    }
    public function testForm($encryptedPayload)
    {
        try {
            // color blind test
            $id = Crypt::decryptString($encryptedPayload);
            $color_blind = Tes::where('pelamar_id', $id)->where('jenis', 'buta_warna')->first();
            $current = round(microtime(true) * 1000);
            if (!$color_blind) {
                $endAt = $current + 1800000;
                $color_blind = Tes::create([
                    'pelamar_id' => $id,
                    'jenis' => "buta_warna",
                    'nilai' => 0,
                    'start_at' => $current,
                    'end_at' => $endAt
                ]);
            }
            if ($color_blind && $color_blind->end_at <= $current) {
                return abort(419);
            }
            if ($color_blind && $color_blind->is_finished) {
                return abort(419);
            }
            $encryptedColorBlindTestPayload = Crypt::encryptString($color_blind->id);
            // ability test
            $ability = Tes::where('pelamar_id', $id)->where('jenis', 'kemampuan')->first();
            if (!$ability) {
                $endAt = $current + 1800000;
                $ability = Tes::create([
                    'pelamar_id' => $id,
                    'jenis' => "kemampuan",
                    'nilai' => 0,
                    'start_at' => $current,
                    'end_at' => $endAt
                ]);
            }
            if ($ability && $ability->end_at <= $current) {
                return abort(419);
            }
            if ($ability && $ability->is_finished) {
                return abort(419);
            }
            $encryptedAbilityTestPayload = Crypt::encryptString($ability->id);
            $ability_questions = [
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

            return view("pelamar.test", [
                'color_blind' => $color_blind,
                'encryptedColorBlindTestPayload' => $encryptedColorBlindTestPayload,
                'ability_questions' => $ability_questions,
                'encryptedAbilityTestPayload' => $encryptedAbilityTestPayload,
                'tes' => $color_blind
            ]);
        } catch (DecryptException $e) {

        }
    }
    public function testSubmit(Request $request)
    {
        try {
            // color blind
            $colorBlindPayload = $request->input('colorBlindPayload');
            $testId = (int) Crypt::decryptString($colorBlindPayload);
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
            if ($request->input("jawaban-buta-warna-1") === $correctAnswers[0]) {
                $total += 10;
            }
            if ($request->input("jawaban-buta-warna-2") === $correctAnswers[1]) {
                $total += 10;
            }
            if ($request->input("jawaban-buta-warna-3") === $correctAnswers[2]) {
                $total += 10;
            }
            if ($request->input("jawaban-buta-warna-4") === $correctAnswers[3]) {
                $total += 10;
            }
            if ($request->input("jawaban-buta-warna-5") === $correctAnswers[4]) {
                $total += 10;
            }
            if ($request->input("jawaban-buta-warna-6") === $correctAnswers[5]) {
                $total += 10;
            }
            if ($request->input("jawaban-buta-warna-7") === $correctAnswers[6]) {
                $total += 10;
            }
            if ($request->input("jawaban-buta-warna-8") === $correctAnswers[7]) {
                $total += 10;
            }
            if ($request->input("jawaban-buta-warna-9") === $correctAnswers[8]) {
                $total += 10;
            }
            if ($request->input("jawaban-buta-warna-10") === $correctAnswers[9]) {
                $total += 10;
            }
            $tes->nilai = $total;
            $tes->save();

            // ability

            $abilityPayload = $request->input('abilityPayload');
            $testId = (int) Crypt::decryptString($abilityPayload);
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

            if ($request->input("jawaban-kemampuan-1") === 'B') {
                $total += 10;
            }
            if ($request->input("jawaban-kemampuan-2") === 'A') {
                $total += 10;
            }
            if ($request->input("jawaban-kemampuan-3") === 'A') {
                $total += 10;
            }
            if ($request->input("jawaban-kemampuan-4") === 'A') {
                $total += 10;
            }
            if ($request->input("jawaban-kemampuan-5") === 'C') {
                $total += 10;
            }
            if ($request->input("jawaban-kemampuan-6") === 'A') {
                $total += 10;
            }
            if ($request->input("jawaban-kemampuan-7") === 'B') {
                $total += 10;
            }
            if ($request->input("jawaban-kemampuan-8") === 'A') {
                $total += 10;
            }
            if ($request->input("jawaban-kemampuan-9") === 'A') {
                $total += 10;
            }
            if ($request->input("jawaban-kemampuan-10") === 'A') {
                $total += 10;
            }
            $tes->nilai = $total;
            $tes->is_finished = true;
            $tes->save();

            $this->sendInterviewEmail($tes->pelamar()->first()->id);
            return redirect('thanks');
        } catch (DecryptException $e) {
        }
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
                    // Mail::to($pelamar->email)->send(new SendInterviewMail($data));
                    Notification::create([
                        'title' => "Undangan Interview Kerja - " . config('app.name'),
                        'pelamar_id' => $pelamar->id,
                        'type' => 'interview',
                        'content' => '
                        <h2 class="text-gray-700 dark:text-gray-200">Halo ' . $data['nama'] . ',</h2>

                        <p class="mt-2 leading-loose text-gray-600 dark:text-gray-300">
                            Terima kasih telah melamar untuk posisi ' . $data['posisi'] . ' di ' . config("app.name") . '. Kami telah
                            meninjau lamaran
                            Anda dan tertarik untuk mengundang Anda ke sesi wawancara guna mengenal lebih lanjut keterampilan serta
                            pengalaman Anda.
                        </p>
                        <p>
                            <strong>
                                Detail Interview:
                            </strong>
                        </p>
                        <div>
                            🕒 <strong>Waktu:</strong> 09.00 - 15.00 WIB
                        </div>
                        <div>
                            📍 <strong>Lokasi:</strong> Jln Sunan Giri No 17 Groyok Kel Sukorejo Lamongan
                        </div>
                        <div>
                            📅 <strong>Tanggal:</strong> ' . $data['date'] . '
                        </div>
                        <br>
                        <p><strong>Persyaratan Dresscode:</strong></p>
                        <div>
                        <strong>Pria:</strong> Atasan putih, bawahan hitam, sepatu hitam.
                        </div>
                        <div>
                        <strong>Wanita:</strong> Atasan putih, bawahan hitam, sepatu hitam formal. Jika beragama Islam, wajib mengenakan kerudung hitam.
                        </div>
                        <p class="mt-2 leading-loose text-gray-600 dark:text-gray-300">
                            Silakan konfirmasi kehadiran Anda dengan membalas email ini sebelum ' . $data['date'] . '. Jika waktu
                            yang dijadwalkan tidak sesuai, beri tahu kami agar dapat dijadwalkan ulang.

                            Jangan ragu untuk menghubungi kami jika ada pertanyaan lebih lanjut. Kami menantikan pertemuan dengan
                            Anda!
                        </p>
                        <p class="mt-2 leading-loose text-gray-600 dark:text-gray-300">
                            Salam hangat,
                            HRD ' . config('app.name') . '
                        </p>
                        <p>
                            <strong>Phone:</strong>(0778) 4081191
                        </p>
                        <p>
                            <strong>Email:</strong>FinnaStore@gmail.com
                        </p>
                        <p class="mt-8 text-gray-600 dark:text-gray-300">
                            Terima kasih, <br>
                            ' . config('app.name') . '
                        </p>
                        '
                    ]);
                    return redirect('/users/notifications');
                }
            }
        }
    }
    public function checkMailPage(string $encryptedPayload)
    {
        try {
            $id = (int) Crypt::decryptString($encryptedPayload);
            $pelamar = Pelamar::where('id', $id)->first();
            if (!$pelamar || $pelamar->user_id != Auth::user()->id) {
                return abort(404);
            }
            $notification = Notification::where('pelamar_id')->where('type', 'test')->first();
            $notification->is_read = true;
            $notification->save();
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
