<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tes extends Model
{
    use HasFactory;

    protected $fillable = [
        "pelamar_id",
        "jenis",
        "deskripsi",
        "nilai",
    ];

    public function pelamar()
    {
        return $this->belongsTo(Pelamar::class);
    }
}
