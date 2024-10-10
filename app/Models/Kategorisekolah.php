<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategorisekolah extends Model
{
    use HasFactory;
    protected $table = 'kategorisekolah';
    
    public $timestamps = false;
    protected $fillable = [
        'npsn',          // Add npsn
        'id_kategori',   // Add id_kategori
        'total_siswa',   // Add total_siswa
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }
}
