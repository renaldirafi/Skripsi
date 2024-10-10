<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gambar extends Model
{
    use HasFactory;
    protected $table = 'gambar';
    public $timestamps = false;
    protected $fillable = [
        'id_gambar',          // Add npsn
        'npsn',
        'nama_file'   // Add id_kategori 
    ];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'npsn', 'NPSN');
    }
}