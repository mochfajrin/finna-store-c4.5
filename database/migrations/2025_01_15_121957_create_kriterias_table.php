<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kriterias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("lowongan_id");
            $table->string("judul");
            $table->timestamps();

            $table->foreign("lowongan_id")->references("id")->on("lowongans")->onDelete("cascade");
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('kriterias');
    }
};
