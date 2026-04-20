<?php

use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\Admin\AnggotaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// kumpulan halaman admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class,'login'])->name('login-page');
    // route halaman dashboard admin
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    // route halaman daftar buku untuk dikelolah
    Route::get('/list-buku', [BukuController::class, 'listBuku'])->name('buku');
    // route halaman create buku
    Route::get('/list-buku/create', [BukuController::class, 'create'])->name('buku.create');
    // route halaman edit buku
    Route::get('/list-buku/{id}/edit', [BukuController::class, 'edit'])->name('buku.edit');
    // route halaman daftar anggota
    Route::get('/list-anggota', [AnggotaController::class, 'listAnggota'])->name('anggota');
    // route halaman create anggota
    Route::get('/list-anggota/create', [AnggotaController::class, 'create'])->name('anggota.create');
    // route untuk menyimpan anggota baru
    Route::post('/list-anggota', [AnggotaController::class, 'store'])->name('anggota.store');
    // route halaman jenis keanggotaan
    Route::get('/list-anggota/jenis', [AnggotaController::class, 'jenis'])->name('anggota.jenis');
    // route halaman tambah jenis keanggotaan
    Route::get('/list-anggota/jenis/create', [AnggotaController::class, 'jenisCreate'])->name('anggota.jenis.create');
    // route untuk menyimpan jenis keanggotaan
    Route::post('/list-anggota/jenis', [AnggotaController::class, 'jenisStore'])->name('anggota.jenis.store');
    // route halaman edit anggota
    Route::get('/list-anggota/{id}/edit', [AnggotaController::class, 'edit'])->name('anggota.edit');
});
