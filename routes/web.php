<?php

use App\Http\Controllers\KabupatenController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\ProvinsiController;
use App\Models\Provinsi;
use Illuminate\Support\Facades\Route;

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

// Provinsi
Route::get('/provinsi', [ProvinsiController::class, 'index'])->name('provinsi');
Route::post('/provinsi', [ProvinsiController::class, 'store']);
Route::get('/provinsi/{id}', [ProvinsiController::class, 'show']);
Route::post('/provinsi/{id}', [ProvinsiController::class, 'update']);
Route::delete('/provinsi/{id}', [ProvinsiController::class, 'destroy']);

// Kabupaten
Route::get('/kabupaten', [KabupatenController::class, 'index'])->name('kabupaten');
Route::post('/kabupaten', [KabupatenController::class, 'store']);
Route::get('/kabupaten/{id}', [KabupatenController::class, 'show']);
Route::post('/kabupaten/{id}', [KabupatenController::class, 'update']);
Route::delete('/kabupaten/{id}', [KabupatenController::class, 'destroy']);

// Penduduk
Route::get('/penduduk/filter', [PendudukController::class, 'filter'])->name('filter');
Route::post('/penduduk/filter', [PendudukController::class, 'filter'])->name('filter');

Route::get('/penduduk', [PendudukController::class, 'index'])->name('penduduk');
Route::get('/penduduk/tambah', [PendudukController::class, 'create'])->name('penduduk_tambah');
Route::post('/penduduk', [PendudukController::class, 'store'])->name('penduduk_store');
Route::get('/penduduk/{id}', [PendudukController::class, 'show']);
Route::post('/penduduk/{id}', [PendudukController::class, 'update']);
Route::delete('/penduduk/{id}', [PendudukController::class, 'destroy']);

Route::get('/penduduk/getKabupaten/{id}', [PendudukController::class, 'getKabupaten']);
