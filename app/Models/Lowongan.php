<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Lowongan extends Model
{
    use HasFactory;
    protected $fillable = [
        "judul",
        "deskripsi",
        "url_gambar",
    ];
    public function pelamars()
    {
        return $this->hasMany(Pelamar::class);
    }
    public function kriterias()
    {
        return $this->hasMany(Kriteria::class);
    }
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
    public function getThumbnailUrl()
    {
        $isUrl = str_contains($this->url_gambar, 'http');
        return $isUrl ? $this->url_gambar : Storage::disk('public')->url($this->url_gambar);
    }
}
