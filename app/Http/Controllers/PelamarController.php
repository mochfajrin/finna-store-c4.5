<?php

namespace App\Http\Controllers;

use App\Enums\PelamarGender;
use App\Mail\SendTestMail;
use App\Models\Lowongan;
use App\Models\Pelamar;
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
        $validated = $request->validate([
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
            'subject' => "Pengerjaan Tes Rekruitmen - $pelamar->nama",
            'link' => config('app.url') . "/pelamar/test/$encryptedPayload",
            'nama' => $pelamar->nama
        ];
        Mail::to($pelamar->email)->send(new SendTestMail($data));
        return redirect("lamaran/mail/$encryptedPayload");

    }
    public function checkMailPage(Request $request, string $encryptedPayload)
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
    public function sendMail()
    {

    }
    public function storeFile(UploadedFile $file, $path)
    {
        $extension = $file->getExtension();
        $uniqueName = uniqid() . '-' . time() . '.' . $extension;
        $path = $file->storeAs($path, $uniqueName, 'public');
        return $path;
    }
}
