<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TamuController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BulananController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProfilController;


Route::redirect('/', 'home');
Route::get('home', [HomeController::class, 'index'])->name('home');

Route::get('form-tamu', [TamuController::class, 'create'])->name('tamu.create');
Route::post('form-tamu', [TamuController::class, 'store'])->name('tamu.store');
Route::get('/daftar-tamu', [TamuController::class, 'daftarTamuUmum'])->name('tamu.umum');

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);


Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');;
Route::post('/register', [RegisterController::class, 'store']);

Route::post('/logout', [LoginController::class, 'logout']);


// Routes with common 'auth' middleware
Route::middleware(['auth'])->group(function () {
  Route::resource('bulanan', BulananController::class);
  Route::get('bulanan/filter', [BulananController::class, 'filter'])->name('bulanan.filter');
  Route::get('bulanan/{id}', [BulananController::class, 'show'])->name('bulanan.show');
  Route::get('/bulanan/{bulanan}/delete', [BulananController::class, 'destroy']);
  Route::resource('edit', ProfilController::class);
  Route::post('update/{profil}', 'App\Http\Controllers\ProfilController@update')->name('profil.update');
});