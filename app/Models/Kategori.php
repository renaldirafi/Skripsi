<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;
    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';
    public $timestamps = false;

    public function kategori_sekolah()
    {
        return $this->hasMany(Kategorisekolah::class);
    }
    public function sekolahs()
    {
        return $this->belongsToMany(Sekolah::class, 'kategorisekolah', 'id_kategori', 'npsn');
    }
    
}
