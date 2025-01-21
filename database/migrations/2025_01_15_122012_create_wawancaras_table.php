<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('wawancaras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("pelamar_id");
            $table->integer("nilai");
            $table->timestamps();

            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
            $table->foreign("pelamar_id")->references("id")->on("pelamars")->onDelete("cascade");
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('wawancaras');
    }
};
