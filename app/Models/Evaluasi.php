<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluasi extends Model
{
    use HasFactory;
    protected $fillable = [
        "pelamar_id",
        "kriteria_id",
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
