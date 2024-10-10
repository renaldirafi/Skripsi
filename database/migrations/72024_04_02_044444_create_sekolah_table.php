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
        Schema::create('sekolah', function (Blueprint $table) {
            $table->bigIncrements('NPSN');
            $table->string('nama_sekolah',50);
            $table->string('jalan_sekolah');
            $table->unsignedBigInteger('kodepos');
            $table->integer('longitude');
            $table->integer('latitude');
            $table->integer('total_siswa');
            $table->unsignedBigInteger('id_jenjang');
            $table->string('link_sekolah');
            $table->binary('foto_sekolah');

            $table->foreign('kodepos')->references('kodepos')->on('lokasi');
            $table->foreign('id_jenjang')->references('id_jenjang')->on('jenjang');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sekolah');
    }
};
