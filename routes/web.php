<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LupaPasswordController;
use Illuminate\Support\Facades\Route;

// halaman beranda untuk pengunjung
Route::get('/', [HomeController::class, 'homePage'])->name('home-page');
Route::get('/cari-buku', [BukuController::class, 'cariBukuPage'])->name('cari-buku-page');

// halaman login
Route::get('/login', [AuthController::class, 'login'])->name('login-page');
Route::get('/register', [AuthController::class, 'register'])->name('register-page');
Route::post('/register', [AuthController::class, 'prosesRegister']);
Route::post('/login', [AuthController::class, 'proses']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// halaman lupa password
Route::get('/lupa-password', [LupaPasswordController::class, 'tampilForm'])->name('lupa-password.tampil');
Route::post('/lupa-password', [LupaPasswordController::class, 'prosesReset'])->name('lupa-password.proses');    

require 'admin.php';