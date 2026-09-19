<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\TamuController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/home');
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/form-tamu', [TamuController::class, 'create'])->name('tamu.create');
Route::post('/form-tamu', [TamuController::class, 'store'])
    ->middleware('throttle:60,1')
    ->name('tamu.store');

Route::middleware('guest')->group(function () {
    Route::get('/auth/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/auth/login', [AuthController::class, 'postLogin'])
        ->middleware('throttle:5,1')
        ->name('login.store');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware(['auth', 'superadmin'])->group(function () {
    Route::redirect('/daftar-tamu', '/rekap')->name('tamu.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/rekap', [RekapController::class, 'index'])->name('rekap.index');
    Route::get('/rekap/filter', [RekapController::class, 'index'])->name('rekap.filter');
    Route::get('/rekap/export/excel', [RekapController::class, 'exportExcel'])->name('rekap.export.excel');
    Route::get('/rekap/export/pdf', [RekapController::class, 'exportPdf'])->name('rekap.export.pdf');
    Route::get('/rekap/{tamu}/photo', [RekapController::class, 'photo'])->name('rekap.photo');
    Route::get('/rekap/{tamu}', [RekapController::class, 'show'])->name('rekap.show');
    Route::get('/rekap/{tamu}/edit', [RekapController::class, 'edit'])->name('rekap.edit');
    Route::put('/rekap/{tamu}', [RekapController::class, 'update'])->name('rekap.update');
    Route::delete('/rekap/{tamu}', [RekapController::class, 'destroy'])->name('rekap.destroy');
});
