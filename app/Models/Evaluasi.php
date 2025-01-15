<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluasi extends Model
{
    use HasFactory;
    protected $fillable = [
        "id_pelamar",
        "id_kriteria",
        "nilai",
    ];

    public function wawancara()
    {
        return $this->belongsTo(Wawancara::class);
    }
    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }
}
