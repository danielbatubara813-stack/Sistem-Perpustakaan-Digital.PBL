<?php

use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// kumpulan halaman admin
Route::prefix('admin')->name('admin.')->group(function () {
    // route halaman dashboard admin
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    // route halaman daftar buku untuk dikelolah
    Route::get('/list-buku', [BukuController::class, 'listBuku'])->name('buku');
});
