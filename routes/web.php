<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\LupaPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DaftarBukuController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HubungiKamiController;
use App\Http\Controllers\Profile\PeminjamanController;
use App\Http\Controllers\Profile\ProfileAnggotaController;
use App\Http\Controllers\Profile\ReservasiController;
use App\Http\Controllers\TentangController;
use App\Http\Middleware\EnsureAnggotaAktif;
use Illuminate\Support\Facades\Route;

// Halaman Pengunjung
Route::get('/', [HomeController::class, 'homePage'])->name('home-page');
Route::get('/cari-buku', [DaftarBukuController::class, 'cariBukuPage'])->name('cari-buku-page');
Route::get('/detail-buku/{id_buku}', [DaftarBukuController::class, 'detailBukuPage'])->name('detail-buku-page');
Route::get('/hubungi-kami', [HubungiKamiController::class, 'hubungiKamiPage'])->name('hubungi-kami-page');
Route::post('/hubungi-kami/kirim-pesan', [HubungiKamiController::class, 'kirimPesan'])->name('kirim-pesan');
Route::get('/tentang', [TentangController::class, 'tentangPage'])->name('tentang-page');

Route::get('/login', [LoginController::class, 'login'])->name('login-page');
Route::post('/login', [LoginController::class, 'proses'])->name('login.proses');

Route::get('/register', [RegisterController::class, 'register'])->name('register-page');
Route::post('/register', [RegisterController::class, 'prosesRegister']);

Route::get('/lupa-password', [LupaPasswordController::class, 'verifikasiEmail'])
    ->name('password.request');
Route::post('/lupa-password', [LupaPasswordController::class, 'checkVerifikasiEmail'])
    ->name('password.email');

Route::get('/reset-password/{token}', [LupaPasswordController::class, 'showResetPassword'])
    ->name('password.reset');
Route::post('/reset-password', [LupaPasswordController::class, 'prosesReset'])
    ->name('password.update');

// Route Profile Anggota (hanya anggota yang sudah login)
Route::middleware(['auth:web', EnsureAnggotaAktif::class])->group(function () {
    Route::post('/reservasi/buat', [ReservasiController::class, 'createReservasiSementara'])->name('reservasi-create');
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/peminjaman-sekarang', [PeminjamanController::class, 'peminjamanSekarangPage'])->name('peminjaman-sekarang-page');
        Route::post('/peminjaman-sekarang/{kodePeminjaman}/perpanjang', [PeminjamanController::class, 'perpanjang'])->name('peminjaman.perpanjang');
        Route::get('/sejarah-peminjaman', [PeminjamanController::class, 'sejarahPeminjamanPage'])->name('sejarah-peminjaman-page');
        Route::get('/akun-saya', [ProfileAnggotaController::class, 'akunSayaPage'])->name('akun-saya-page');
        Route::post('/akun-saya/update', [ProfileAnggotaController::class, 'updateProfile'])->name('akun-saya.update');                    // ✅ updateProfile
        Route::post('/akun-saya/change-password', [ProfileAnggotaController::class, 'changePassword'])->name('akun-saya.change-password'); // ✅ changePassword
        Route::get('/reservasi', [ReservasiController::class, 'reservasi'])->name('reservasi-page');
        Route::post('/reservasi/ajukan', [ReservasiController::class, 'ajukanReservasi'])->name('reservasi-ajukan');
        Route::get('/daftar-reservasi', [ReservasiController::class, 'daftarReservasi'])->name('daftar-reservasi-page');
        Route::put('/reservasi/batalkan-reservasi', [ReservasiController::class, 'batalkanReservasi'])->name('reservasi.jadikan-reservasi');
    });
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
});

// Logout Anggota

require 'admin.php';
