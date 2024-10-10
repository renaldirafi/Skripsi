<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use HasFactory;
    protected $table = 'sekolah';
    protected $primaryKey = 'npsn';
    public $timestamps = false;
    protected $fillable = [
        'npsn',            // Add npsn here
        'nama_sekolah',
        'jalan_sekolah',
        'kodepos',
        'latitude',
        'longitude',
        'link_sekolah',
        'id_jenjang',
        'total_siswa',
    ];


    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'kodepos', 'kodepos');
    }

    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class, 'id_jenjang', 'id_jenjang');
    }
    public function gambar()
{
    return $this->hasMany(Gambar::class, 'npsn', 'NPSN');
}

public function kategoriSekolah()
{
    return $this->belongsToMany(Kategori::class, 'kategorisekolah', 'npsn', 'id_kategori');
}

    public function fasilitas_sekolah()
    {
        return $this->hasMany(Fasilitassekolah::class);
    }

    public function kategoris()
    {
        return $this->belongsToMany(Kategori::class, 'kategori_sekolah', 'npsn', 'id_kategori');
    }
    public function fasilitas()
{
    return $this->belongsToMany(Fasilitas::class, 'fasilitassekolah', 'npsn', 'id_fasilitas');
}
    
}
