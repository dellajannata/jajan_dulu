<?php

use App\Http\Controllers\MakananController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
//makanan
Route::get('/makanan', [MakananController::class, 'index'])->name('makanan.index');
Route::post('/keranjang/tambah-sementara', [KeranjangController::class, 'tambahSementara'])->name('keranjang.tambahSementara');
Route::get('/keranjang', [KeranjangController::class, 'tampilKeranjang'])->name('keranjang.tampilKeranjang');
Route::post('/keranjang/simpan', [KeranjangController::class, 'simpanKeranjang'])->name('keranjang.simpanKeranjang');
Route::delete('/keranjang/hapus/{index}', [KeranjangController::class, 'hapusDariKeranjang'])->name('keranjang.hapus');
Route::get('/waiting-payment/{order_id}', [KeranjangController::class, 'waitingPayment'])->name('waiting.payment');