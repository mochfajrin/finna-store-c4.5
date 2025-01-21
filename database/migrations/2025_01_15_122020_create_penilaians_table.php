<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('penilaians', function (Blueprint $table) {
            $table->id();
            $table->integer('nilai');
            $table->unsignedBigInteger('pelamar_id');
            $table->timestamps();

            $table->foreign("pelamar_id")->references("id")->on("pelamars")->onDelete("cascade");
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('penilaians');
    }
};
