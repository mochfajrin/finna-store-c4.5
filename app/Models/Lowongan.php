<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lowongan extends Model
{
    use HasFactory;
    protected $fillable = [
        "judul",
        "deskripsi",
        "url_gambar",
    ];
    public function pelamar()
    {
        return $this->hasOne(Pelamar::class);
    }
    public function kriterias()
    {
        return $this->hasMany(Kriteria::class);
    }
}
