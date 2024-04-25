<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ujian_berita_acaras', function (Blueprint $table) {
            $table->id();
            $table->string('kd_dosen', 10);
            $table->string('mtk', 6);
            $table->string('kel_ujian', 30);
            $table->string('hari', 10);
            $table->string('paket', 20);
            $table->string('isi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ujian_berita_acaras');
    }
};
