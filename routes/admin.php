<?php

use App\Http\Controllers\Admin\Anggota\AnggotaController;
use App\Http\Controllers\Admin\Anggota\JenisKeanggotaanController;

use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DataTerkendali\DokBahasaController;
use App\Http\Controllers\Admin\DataTerkendali\PenerbitController;
use App\Http\Controllers\Admin\DataTerkendali\PenulisController;
use App\Http\Controllers\Admin\DataTerkendali\SubjekController;
use App\Http\Controllers\Admin\DataTerkendali\TipeKoleksiController;
use App\Http\Controllers\Admin\Peminjaman\PeminjamanController;
use App\Http\Controllers\Admin\Peminjaman\ReservasiController;
use App\Http\Controllers\Admin\Pengembalian\PengembalianBukuController;
use App\Http\Controllers\Admin\Pengembalian\PengembalianCepatController;
use App\Http\Controllers\Admin\Pengembalian\PengembalianController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

// kumpulan halaman admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [LoginController::class, 'login'])->name('login-page');
    // route halaman dashboard admin
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    // route halaman daftar buku untuk dikelolah
    Route::get('/list-buku', [BukuController::class, 'listBuku'])->name('buku');
    // route halaman create buku
    Route::get('/list-buku/create', [BukuController::class, 'create'])->name('buku.create');
    // route halaman edit buku
    Route::get('/list-buku/{id}/edit', [BukuController::class, 'edit'])->name('buku.edit');
    // route halaman daftar anggota

    Route::prefix('list-anggota')->name('anggota.')->group(function () {
        Route::get('/', [AnggotaController::class, 'listAnggota'])->name('daftar');
        // route halaman create anggota
        Route::get('/create', [AnggotaController::class, 'create'])->name('create');
        // route untuk menyimpan anggota baru
        Route::post('', [AnggotaController::class, 'store'])->name('store');
        // route halaman edit anggota
        Route::get('/{id}/edit', [AnggotaController::class, 'edit'])->name('edit');
        // route halaman jenis keanggotaan
        Route::get('/jenis', [JenisKeanggotaanController::class, 'jenis'])->name('jenis');
        // route halaman tambah jenis keanggotaan
        Route::get('/jenis/create', [JenisKeanggotaanController::class, 'jenisCreate'])->name('jenis.create');
        // route untuk menyimpan jenis keanggotaan
        Route::post('/jenis', [JenisKeanggotaanController::class, 'jenisStore'])->name('jenis.store');
    });

    // Peminjaman
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman');

    Route::get('/peminjaman/aturan', [PeminjamanController::class, 'aturan'])
        ->name('peminjaman.aturan');
    Route::get('/peminjaman/aturan/create', [PeminjamanController::class, 'aturanCreate'])
        ->name('peminjaman.aturan.create');
    Route::get('/peminjaman/catat-peminjaman', [PeminjamanController::class, 'catatPeminjaman'])
        ->name('peminjaman.catat-peminjaman');

    Route::get('/peminjaman/reservasi', [ReservasiController::class, 'reservasi'])->name('peminjaman.reservasi');

    // Pengembalian
    Route::get('/pengembalian', [PengembalianController::class, 'index'])
        ->name('pengembalian');
    Route::get('/pengembalian/cepat', [PengembalianCepatController::class, 'index'])
        ->name('pengembalian.cepat');
    Route::get('/pengembalian/buku', [PengembalianBukuController::class, 'index'])
        ->name('pengembalian.buku');


    Route::prefix('data-terkendali')->name('data-terkendali.')->group(function () {
        Route::prefix('tipe-koleksi')->name('tipe-koleksi.')->group(function () {
            Route::get('/', [TipeKoleksiController::class, 'index'])->name('index');
            Route::get('/create', [TipeKoleksiController::class, 'create'])->name('create');
            Route::post('/', [TipeKoleksiController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [TipeKoleksiController::class, 'edit'])->name('edit');
        });
        Route::prefix('subjek')->name('subjek.')->group(function () {
            Route::get('/', [SubjekController::class, 'index'])->name('index');
            Route::get('/create', [SubjekController::class, 'create'])->name('create');
            Route::post('/', [SubjekController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [SubjekController::class, 'edit'])->name('edit');
        });
        Route::prefix('dok-bahasa')->name('dok-bahasa.')->group(function () {
            Route::get('/', [DokBahasaController::class, 'index'])->name('index');
            Route::get('/create', [DokBahasaController::class, 'create'])->name('create');
            Route::post('/', [DokBahasaController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [DokBahasaController::class, 'edit'])->name('edit');
        });

        Route::prefix('penulis')->name('penulis.')->group(function () {
            Route::get('/', [PenulisController::class, 'index'])->name('index');
            Route::get('/create', [PenulisController::class, 'create'])->name('create');
            Route::post('/', [PenulisController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [PenulisController::class, 'edit'])->name('edit');
        });

        Route::prefix('penerbit')->name('penerbit.')->group(function () {
            Route::get('/', [PenerbitController::class, 'index'])->name('index');
            Route::get('/create', [PenerbitController::class, 'create'])->name('create');
            Route::post('/', [PenerbitController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [PenerbitController::class, 'edit'])->name('edit');
        });
    });
});
