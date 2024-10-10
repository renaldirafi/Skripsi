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
        Schema::create('gambar', function (Blueprint $table) {
            $table->bigIncrements('id_gambar');
            $table->unsignedBigInteger('npsn');
            $table->string('nama_file');

            $table->foreign('npsn')->references('npsn')->on('sekolah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gambar');
    }
};
