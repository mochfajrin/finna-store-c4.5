<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wawancara extends Model
{
    use HasFactory;
    protected $fillable = [
        "id_user",
        "id_pelamar",
        "nilai",
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function pelamar()
    {
        return $this->belongsTo(Pelamar::class);
    }
}
