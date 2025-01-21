<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;
    protected $fillable = [
        "nilai",
        "pelamar_id"
    ];
    public function pelamar()
    {
        return $this->belongsTo(Pelamar::class);
    }
}
