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
        "nilai",
        'is_finished',
        "start_at",
        "end_at",
    ];

    public function pelamar()
    {
        return $this->belongsTo(Pelamar::class);
    }
}
