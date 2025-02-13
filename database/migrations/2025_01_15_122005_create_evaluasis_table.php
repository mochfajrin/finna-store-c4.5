<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('evaluasis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pelamar_id');
            $table->unsignedBigInteger('kriteria_id');
            $table->integer('nilai');
            $table->timestamps();

            $table->unique(['pelamar_id', 'kriteria_id']);
            $table->foreign("pelamar_id")->references("id")->on("pelamars")->onDelete("cascade");
            $table->foreign("kriteria_id")->references("id")->on("kriterias")->onDelete("cascade");
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('evaluasis');
    }
};
