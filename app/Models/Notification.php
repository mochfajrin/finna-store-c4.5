<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'type', 'content', 'is_read', 'pelamar_id'];
    public function pelamar()
    {
        return $this->belongsTo(Pelamar::class);
    }

}
