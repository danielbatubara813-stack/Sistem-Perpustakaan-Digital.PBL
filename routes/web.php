<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LupaPasswordController;
use App\Http\Controllers\HubungiKamiController;
use Illuminate\Support\Facades\Route;

// halaman beranda untuk pengunjung
Route::get('/', [HomeController::class, 'homePage'])->name('home-page');
Route::get('/cari-buku', [BukuController::class, 'cariBukuPage'])->name('cari-buku-page');
Route::get('/hubungi-kami', [HubungiKamiController::class, 'hubungiKamiPage'])->name('hubungi-kami-page');
Route::post('/hubungi-kami/kirim-pesan', [HubungiKamiController::class, 'kirimPesan'])->name('kirim-pesan');
Route::get('/detail-buku/{id_buku}', [BukuController::class, 'detailBukuPage'])->name('detail-buku-page');

// halaman login
Route::get('/login', [AuthController::class, 'login'])->name('login-page');
Route::post('/login', [AuthController::class, 'proses']);

Route::get('/register', [AuthController::class, 'register'])->name('register-page');
Route::post('/register', [AuthController::class, 'prosesRegister']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// halaman lupa password
Route::get('/lupa-password', [LupaPasswordController::class, 'tampilForm'])->name('lupa-password.tampil');
Route::post('/lupa-password', [LupaPasswordController::class, 'prosesReset'])->name('lupa-password.proses');

require 'admin.php';