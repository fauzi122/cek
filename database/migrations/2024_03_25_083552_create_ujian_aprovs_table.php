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
        Schema::create('ujian_aprovs', function (Blueprint $table) {
            $table->id();
            $table->string('kd_dosen', 20);
            $table->string('perakit_kirim', 10);
            $table->string('acc_kaprodi', 10);
            $table->string('acc_baak', 10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ujian_aprovs');
    }
};
