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
        Schema::table('sekolah', function (Blueprint $table) {
            $table->decimal('longitude',10,8) -> change();
            $table->decimal('latitude',10,8)-> after('kodepos') -> change() ;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sekolah', function (Blueprint $table) {
            $table->decimal('latitude', 10, 8)->after('longitude');
            
            // Mengubah tipe data kolom latitude dan longitude ke tipe data asalnya
            $table->float('longitude')->change();
            $table->float('latitude')->change();

        });
    }
};
