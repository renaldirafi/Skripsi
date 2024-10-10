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
        Schema::create('kategorisekolah', function (Blueprint $table) {
            $table->unsignedBigInteger('NPSN');
            $table->unsignedBigInteger('id_kategori');
            
            $table->primary(['NPSN', 'id_kategori']); // Mendefinisikan dua kolom sebagai kunci utama
    
            $table->foreign('NPSN')->references('NPSN')->on('sekolah');
            $table->foreign('id_kategori')->references('id_kategori')->on('kategori');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategorisekolah');
    }
};
