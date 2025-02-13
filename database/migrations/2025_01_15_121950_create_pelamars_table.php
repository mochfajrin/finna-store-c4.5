<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pelamars', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("lowongan_id");
            $table->string("nama");
            $table->enum("jenis_kelamin", ["l", "p"]);
            $table->string("no_telepon");
            $table->string("email");
            $table->string("alamat");
            $table->date("tanggal_lahir");
            $table->string("url_foto");
            $table->string("url_ijazah")->nullable();
            $table->string("url_ktp")->nullable();
            $table->string("url_skck")->nullable();
            $table->string("url_riwayat")->nullable();
            $table->timestamps();

            $table->foreign("lowongan_id")->references("id")->on("lowongans")->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('pelamars');
    }
};
