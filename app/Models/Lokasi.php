<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    use HasFactory;
    protected $table = 'lokasi';
    protected $primaryKey = 'kodepos';
    public $timestamps = false;

    public function sekolah()
    {
        return $this->hasMany(Sekolah::class);
    }
    
}
