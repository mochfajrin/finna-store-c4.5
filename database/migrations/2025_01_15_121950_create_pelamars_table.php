<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pelamars', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("id_lowongan");
            $table->string("nama");
            $table->enum("jenis_kelamin", ["l", "p"]);
            $table->string("no_telepon");
            $table->string("email");
            $table->string("alamat");
            $table->date("tanggal_lahir");
            $table->string("url_foto");
            $table->string("url_ijazah");
            $table->string("url_ktp");
            $table->string("url_skck");
            $table->string("url_riwayat");
            $table->timestamps();

            $table->foreign("id_lowongan")->references("id")->on("lowongans")->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelamars');
    }
};
