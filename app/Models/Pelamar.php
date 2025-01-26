<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelamar extends Model
{
    use HasFactory;

    protected $fillable = [
        'lowongan_id',
        'nama',
        'jenis_kelamin',
        'no_telepon',
        'email',
        'alamat',
        'tanggal_lahir',
        'url_foto',
        'url_ijazah',
        'url_ktp',
        'url_skck',
        'url_riwayat',
    ];
    public function kriterias()
    {
        return $this->hasMany(Kriteria::class);
    }
    public function wawancara()
    {
        return $this->hasOne(Wawancara::class);
    }
    public function tes()
    {
        return $this->hasMany(Tes::class);
    }
    public function evaluasi()
    {
        return $this->hasMany(Evaluasi::class);
    }
    public function penilaian()
    {
        return $this->hasOne(Penilaian::class);
    }
}
