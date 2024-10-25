<?php

use App\Http\Controllers\CetakController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\IndexController;
use App\Http\Controllers\Web\SearchController;
use App\Http\Controllers\Web\WishController;
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


Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/login', function () {
    return redirect('/admin/login');
})->name('login');


Route::get('admin/cetak/jurnal-umum', [CetakController::class,'jurnalUmum']);
Route::get('admin/cetak/laporan-akun', [CetakController::class,'laporanAkun']);
Route::get('admin/cetak/laporan-akun/coa/{coa}/cetak', [CetakController::class,'laporanAkunCoa']);

Route::get('admin/cetak/laporan-laba-rugi', [CetakController::class,'laporanLabaRugi']);
Route::get('admin/cetak/laporan-perubahan-modal', [CetakController::class,'laporanPerubahanModal']);
Route::get('admin/cetak/laporan-posisi-keuangan', [CetakController::class,'laporanPosisiKeuangan']);
Route::get('admin/cetak/laporan-calk', [CetakController::class,'laporanCalk']);

