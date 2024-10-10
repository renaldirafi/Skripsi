<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fasilitassekolah extends Model
{
    use HasFactory;
    protected $table = 'fasilitassekolah';
    public $timestamps = false;
    protected $fillable = [
        'npsn',          // Add npsn
        'id_fasilitas',   // Add id_kategori 
    ];

    public function fasilitas()
    {
        return $this->belongsTo(Fasilitas::class);
    }
    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }
}
