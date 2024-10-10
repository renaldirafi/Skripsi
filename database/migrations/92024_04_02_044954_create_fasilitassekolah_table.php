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
        Schema::create('fasilitassekolah', function (Blueprint $table) {
            $table->unsignedBigInteger('NPSN');
            $table->unsignedBigInteger('id_fasilitas');
            
            $table->primary(['NPSN', 'id_fasilitas']); // Mendefinisikan dua kolom sebagai kunci utama
    
            $table->foreign('NPSN')->references('NPSN')->on('sekolah');
            $table->foreign('id_fasilitas')->references('id_fasilitas')->on('fasilitas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fasilitassekolah');
    }
};
