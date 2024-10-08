<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TamuController;
use App\Http\Controllers\BulananController;
use Livewire\Livewire;
use App\Http\Livewire\WebcamCapture;
use App\Http\Controllers\WebcamController;
use App\Models\Tamu;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SemuaBulanController;
use App\Http\Controllers\ProfilController;
use App\Models\Bulanan;
use App\Models\Profil;
use App\Models\SemuaBulan;


Route::get('/form-index', function () {
    return view('form.index');
})->name('form.index');


Route::post('//store', [TamuController::class, 'store'])->name('tamu.store');
Route::get('/form-tamu', [TamuController::class, 'index2'])->name('tamu.index');

Route::resource('', TamuController::class);
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);

Route::get('/daftar-tamu', [TamuController::class, 'daftarTamuUmum'])->name('tamu.umum');


Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');;
Route::post('/register', [RegisterController::class, 'store']);

Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/bulanan/{bulanan}/delete', [BulananController::class, 'destroy']);

Route::resource('bulanan', BulananController::class);
Route::get('bulanan/filter', [BulananController::class, 'filter'])->name('bulanan.filter');
Route::get('bulanan/{id}', [BulananController::class, 'show'])->name('bulanan.show');

Route::resource('edit', ProfilController::class);
route::post('update/{profil}', 'App\Http\Controllers\ProfilController@update')->name('profil.update');
Route::resource('Admin', BulananController::class)->middleware('auth');
Route::resource('Semua-bulan', SemuaBulanController::class);


