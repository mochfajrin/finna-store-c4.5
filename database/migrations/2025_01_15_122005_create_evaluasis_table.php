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
        Schema::create('evaluasis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pelamar');
            $table->unsignedBigInteger('id_kriteria');
            $table->integer('nilai');
            $table->timestamps();

            $table->foreign("id_pelamar")->references("id")->on("pelamars")->onDelete("cascade");
            $table->foreign("id_kriteria")->references("id")->on("kriterias")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluasis');
    }
};
