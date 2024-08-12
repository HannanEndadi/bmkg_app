<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\TransaksiController;

Route::get('/', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');

Route::resource('/users', UserController::class)->middleware('auth');

Route::resource('/barang', BarangController::class)->middleware('auth');


Route::get('/peminjaman', [TransaksiController::class, 'pinjam'])->middleware('auth');
Route::get('/get-data-barang/{id}', [TransaksiController::class, 'getDataBarang']);
Route::post('/peminjaman/store', [TransaksiController::class, 'storePinjam'])->middleware('auth');

Route::get('/pengembalian', [TransaksiController::class, 'kembali'])->middleware('auth');
Route::get('/get-data-barang-kembali/{id}', [TransaksiController::class, 'getDataBarangKembali']);
Route::post('/pengembalian/store', [TransaksiController::class, 'storeKembali'])->middleware('auth');

Route::get('/riwayat', [TransaksiController::class, 'riwayat'])->middleware('auth');
