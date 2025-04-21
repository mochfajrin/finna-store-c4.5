<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    use HasFactory;

    protected $fillable = [
        "pelamar_id",
        "wawancara_id",
        "pertanyaan",
        "nilai",
    ];

    public function pelamar()
    {
        return $this->belongsTo(Pelamar::class);
    }

    public function wawancara()
    {
        return $this->belongsTo(Wawancara::class);
    }
}
