<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\TamuController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfilController;


Route::redirect('/', 'home');
Route::get('home', [HomeController::class, 'index'])->name('home');

Route::get('form-tamu', [TamuController::class, 'create'])->name('tamu.create');
Route::post('form-tamu', [TamuController::class, 'store'])->name('tamu.store');
Route::get('daftar-tamu', [TamuController::class, 'index'])->name('tamu.index');
// Route to run storage:link
Route::get('generate-storage-link', function() {
  Artisan::call('storage:link');
  echo 'success';
});

Route::controller(AuthController::class)->group(function() {
  Route::get('auth/login', 'loginForm')->name('login')->middleware('guest');
  Route::post('auth/postLogin', 'postLogin')->name('postLogin'); // Gunakan route name untuk post login
  Route::post('logout', 'logout')->name('logout');
  Route::get('auth/register', 'registrationForm')->name('register');
  Route::post('auth/postRegister','postRegister')->name('postRegister');
});

// Routes with common 'auth' middleware
Route::middleware(['auth'])->group(function () {
  Route::get('rekap', [RekapController::class, 'index'])->name('rekap.index'); // Rute untuk menampilkan daftar
  Route::get('rekap/filter', [RekapController::class, 'index'])->name('rekap.filter'); // Rute untuk memfilter
  Route::resource('rekap', RekapController::class)->except(['index', 'show']); // Rute resource tanpa index dan show
});