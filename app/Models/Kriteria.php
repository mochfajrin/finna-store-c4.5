<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;
    protected $fillable = [
        "lowongan_id",
        "judul",
    ];

    public function lowongan()
    {
        return $this->belongsTo(Lowongan::class);
    }
    public function pelamar()
    {
        return $this->belongsTo(Pelamar::class);
    }
    public function evaluasi()
    {
        return $this->belongsTo(Evaluasi::class);
    }
}
