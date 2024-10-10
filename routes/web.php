<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LokasiController;


Route::get('/', function () {
    return view('beranda');
});
Route::get('/beranda', function () {
    return view('beranda');
});
Route::get('/coba', function () {
    return view('coba');
});

Route::get('/home', function () {
    return view('home');
});
Route::get('/map', function () {
    return view('map');
});
Route::get('/login', function () {
    return view('login');
});
Route::get('/tambahdata', function () {
    return view('tambahdata');
});
Route::get('/editdata', function () {
    return view('edit');
});

Route::get('/', [KategoriController::class, 'index']);
Route::get('/beranda', [KategoriController::class, 'index']);
Route::get('/home', [KategoriController::class, 'index6'])->name('home')->middleware('auth');
Route::get('/home-json-search', [KategoriController::class, 'index56'])->name('home-json-search')->middleware('auth');
Route::get('/coba-json-search', [KategoriController::class, 'index56'])->name('coba-json-search');
Route::get('/coba', [KategoriController::class, 'index10']);
Route::post('/coba', [KategoriController::class, 'updateLocation']);
Route::get('/detailinstansi/{npsn}', [KategoriController::class, 'detailinstansi']);
Route::get('/tambahdata', [KategoriController::class, 'tambah'])->middleware('auth');
Route::post('/tambahdata', [KategoriController::class, 'store'])->name('sekolah.store')->middleware('auth');
Route::post('/home/delete', [KategoriController::class, 'delete'])->name('kategori.delete')->middleware('auth');
Route::get('/edit/{id}', [KategoriController::class, 'edit'])->name('sekolah.edit')->middleware('auth');
Route::get('/data', [KategoriController::class, 'indexcoba']);
Route::post('/login', [KategoriController::class, 'login'])->middleware('guest');
Route::get('/login',[KategoriController::class,'showLoginForm'])->name('login')->middleware('guest');
Route::post('/logout', [KategoriController::class, 'logout'])->name('logout');

// Route untuk mengupdate data
Route::put('/update/{id}', [KategoriController::class, 'update'])->name('sekolah.update')->middleware('auth');
