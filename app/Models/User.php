<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    protected $table = 'admin'; 
    protected $primaryKey = 'id_admin'; // Primary key tabel

    // Menentukan kolom yang bisa diisi
    protected $fillable = ['username', 'password'];
    public $timestamps = false;

}
