<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jenjang extends Model
{
    use HasFactory;
    protected $table = 'jenjang';

    public function sekolah()
    {
        return $this->hasMany(Sekolah::class, 'id_jenjang', 'id_jenjang');
    }
}
