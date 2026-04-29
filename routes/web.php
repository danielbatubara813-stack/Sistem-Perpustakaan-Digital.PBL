<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\LupaPasswordController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\DaftarBukuController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HubungiKamiController;
use App\Http\Controllers\Profile\ReservasiController;
use App\Http\Controllers\TentangController;

use App\Http\Controllers\Profile\PeminjamanController;
use App\Http\Controllers\Profile\ProfileAnggotaController;

use Illuminate\Support\Facades\Route;

// halaman beranda untuk pengunjung
Route::get('/', [HomeController::class, 'homePage'])->name('home-page');

Route::get('/cari-buku', [DaftarBukuController::class, 'cariBukuPage'])->name('cari-buku-page');
Route::get('/detail-buku/{id_buku}', [DaftarBukuController::class, 'detailBukuPage'])->name('detail-buku-page');

// Routing halaman hubungi kami
Route::get('/hubungi-kami', [HubungiKamiController::class, 'hubungiKamiPage'])->name('hubungi-kami-page');
// Routing proses hubungi kami
Route::post('/hubungi-kami/kirim-pesan', [HubungiKamiController::class, 'kirimPesan'])->name('kirim-pesan');
// Routing halaman tentang
Route::get('/tentang', [TentangController::class, 'tentangPage'])->name('tentang-page');

Route::prefix('profile')->name('profile.')->group(function () {
    Route::get('/peminjaman-sekarang', [PeminjamanController::class, 'peminjamanSekarangPage'])->name('peminjaman-sekarang-page');
    Route::get('/sejarah-peminjaman', [PeminjamanController::class, 'sejarahPeminjamanPage'])->name('sejarah-peminjaman-page');
    Route::get('/akun-saya', [ProfileAnggotaController::class, 'akunSayaPage'])->name('akun-saya-page');
    Route::get('/reservasi', [ReservasiController::class, 'reservasi'])->name('reservasi-page');
    Route::get('/daftar-reservasi', [ReservasiController::class, 'daftarReservasi'])->name('daftar-reservasi-page');
});

// Routing halaman login
Route::get('/login', [LoginController::class, 'login'])->name('login-page');
// Routing proses login
Route::post('/login', [LoginController::class, 'proses']);

// Routing halaman register
Route::get('/register', [RegisterController::class, 'register'])->name('register-page');
// Routing proses register
Route::post('/register', [RegisterController::class, 'prosesRegister']);

// Routing proses logout
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

Route::get('/verifikasi-email', [LupaPasswordController::class, 'verifikasiEmail'])->name('verifikasi-email');
// Routing halaman lupa password
Route::get('/lupa-password', [LupaPasswordController::class, 'tampilForm'])->name('lupa-password.tampil');
// Routing proses lupa password
Route::post('/lupa-password', [LupaPasswordController::class, 'prosesReset'])->name('lupa-password.proses');

require 'admin.php';