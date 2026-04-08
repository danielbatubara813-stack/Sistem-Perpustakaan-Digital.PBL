<?php

use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// halaman beranda untuk pengunjung
Route::get('/', [HomeController::class, 'homePage'])->name('home-page');

// halaman login
Route::get('/login', [AuthController::class, 'login'])->name('login-page');
Route::get('/register', [AuthController::class, 'register'])->name('register-page');
Route::post('/register', [AuthController::class, 'prosesRegister']);
Route::post('/login', [AuthController::class, 'proses']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



// kumpulan halaman admin
Route::prefix('admin')->name('admin.')->group(function () {
    // route halaman dashboard admin
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    // route halaman daftar buku untuk dikelolah
    Route::get('/list-buku', [BukuController::class, 'listBuku'])->name('buku');
});