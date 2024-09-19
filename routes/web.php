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

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/Admin', function () {
//     return view('includes.master');
// });
// Route::get('/Semua-bulan', function () {
//     return view('dasboard.index');
// })->name('dasboard.index');

// Route::get('/tamu', function () {
//     return view('form.index');
// })->name('form.create');

// Route::get('/Bulanan', function () {
//     return view('dasboard.ondex');
// })->name('dasboard.ondex');

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
Route::resource('edit', ProfilController::class);
route::post('update/{profil}', 'App\Http\Controllers\ProfilController@update')->name('profil.update');
Route::resource('Admin', BulananController::class)->middleware('auth');
Route::resource('Semua-bulan', SemuaBulanController::class);


Route::get('/bulanan', [BulananController::class, 'index'])->name('dashboard.ondex');
Route::get('/Semua-bulan', [SemuaBulanController::class, 'index'])->name('dashboard.index');


// January
Route::get('/january', [SemuaBulanController::class, 'index1'])->name('table.mont1');

// February
Route::get('/february', [SemuaBulanController::class, 'index2'])->name('monthly-data.february');

// March
Route::get('/march', [SemuaBulanController::class, 'index3'])->name('monthly-data.march');

// April
Route::get('/april', [SemuaBulanController::class, 'index4'])->name('monthly-data.april');

// May
Route::get('/may', [SemuaBulanController::class, 'index5'])->name('monthly-data.may');

// June
Route::get('/june', [SemuaBulanController::class, 'index6'])->name('monthly-data.june');

// July
Route::get('/july', [SemuaBulanController::class, 'index7'])->name('monthly-data.july');

// August
Route::get('/august', [SemuaBulanController::class, 'index8'])->name('monthly-data.august');

// September
Route::get('/september', [SemuaBulanController::class, 'index9'])->name('monthly-data.september');

// October
Route::get('/october', [SemuaBulanController::class, 'index10'])->name('monthly-data.october');

// November
Route::get('/november', [SemuaBulanController::class, 'index11'])->name('monthly-data.november');

// December
Route::get('/december', [SemuaBulanController::class, 'index12'])->name('monthly-data.december');





