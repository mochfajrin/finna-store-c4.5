<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tes extends Model
{
    use HasFactory;

    protected $fillable = [
        "id_pelamar",
        "jenis",
        "deskripsi",
        "nilai",
    ];

    public function pelamar()
    {
        return $this->belongsTo(Pelamar::class);
    }
}
