<?php

use App\Http\Controllers\KabupatenController;
use App\Http\Controllers\LaporanController;
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

Route::get('/', [PendudukController::class, 'index'])->name('home');

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
Route::get('/penduduk/{id}', [PendudukController::class, 'show'])->name('penduduk_edit');
Route::post('/penduduk/{id}', [PendudukController::class, 'update']);
Route::delete('/penduduk/{id}', [PendudukController::class, 'destroy'])->name('penduduk_hapus');

// Laporan
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
Route::get('/laporan/excel', [LaporanController::class, 'exportExcel'])->name('excel-export');
Route::get('/laporan/print/provinsi', [LaporanController::class, 'printProvinsi'])->name('print-pend-provinsi');
Route::get('/laporan/print/kabupaten/{id}', [LaporanController::class, 'exportKabupaten'])->name('print-pend-kabupaten');

Route::get('/penduduk/getKabupaten/{id}', [PendudukController::class, 'getKabupaten']);
