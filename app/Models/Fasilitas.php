<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    use HasFactory;

    public function fasilitassekolah()
    {
        return $this->hasMany(Fasilitassekolah::class);
    }
}
