<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("pelamar_id");
            $table->string('jenis');
            $table->integer('nilai');
            $table->boolean('is_finished')->default(false);
            $table->bigInteger('start_at');
            $table->bigInteger('end_at');
            $table->timestamps();

            $table->foreign('pelamar_id')->references("id")->on("pelamars")->onDelete("cascade");
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('tes');
    }
};
