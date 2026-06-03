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
    // route bulk delete buku (multi-delete)
    Route::delete('/list-buku/destroy', [BukuController::class, 'destroyMultiple'])->name('buku.destroyMultiple');
    // route halaman daftar anggota
    Route::get('/list-buku', [BukuController::class, 'listBuku'])->name('buku');
    // route halaman daftar buku untuk dikelolah
    Route::get('/list-buku/create', [BukuController::class, 'create'])->name('buku.create');
    // route halaman create buku
    Route::post('/list-buku', [BukuController::class, 'store'])->name('buku.store');
    // route simpan buku baru
    Route::get('/list-buku/{id}/edit', [BukuController::class, 'edit'])->name('buku.edit');
    // route halaman edit buku
    Route::put('/list-buku/{id}', [BukuController::class, 'update'])->name('buku.update');
    // update buku
    Route::delete('/list-buku/{id}', [BukuController::class, 'destroy'])
    ->name('buku.destroy');
    // hapus buku

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
            Route::get('/', [TipeKoleksiController::class, 'indexTipeKoleksi'])->name('index');
            Route::get('/create', [TipeKoleksiController::class, 'createTipeKoleksi'])->name('create');
            Route::post('/', [TipeKoleksiController::class, 'storeTipeKoleksi'])->name('store');
            Route::get('/{id}/edit', [TipeKoleksiController::class, 'editTipeKoleksi'])->name('edit');
            Route::put('/update', [TipeKoleksiController::class, 'updateTipeKoleksi'])->name('update');
            Route::delete('/destroy', [TipeKoleksiController::class, 'destroyTipeKoleksi'])->name('destroy');
        });
        Route::prefix('subjek')->name('subjek.')->group(function () {
            Route::get('/', [SubjekController::class, 'indexSubjek'])->name('index');
            Route::get('/create', [SubjekController::class, 'createSubjek'])->name('create');
            Route::post('/', [SubjekController::class, 'storeSubjek'])->name('store');
            Route::get('/{id}/edit', [SubjekController::class, 'editSubjek'])->name('edit');
            Route::put('/update', [SubjekController::class, 'updateSubjek'])->name('update');
            Route::delete('/destroy', [SubjekController::class, 'destroySubjek'])->name('destroy');
        });
        Route::prefix('dok-bahasa')->name('dok-bahasa.')->group(function () {
            Route::get('/', [DokBahasaController::class, 'indexBahasa'])->name('index');
            Route::get('/create', [DokBahasaController::class, 'createBahasa'])->name('create');
            Route::post('/', [DokBahasaController::class, 'storeBahasa'])->name('store');
            Route::get('/{id}/edit', [DokBahasaController::class, 'editBahasa'])->name('edit');
            Route::put('/update', [DokBahasaController::class, 'updateBahasa'])->name('update');
            Route::delete('/destroy', [DokBahasaController::class, 'destroyBahasa'])->name('destroy');
        });

        Route::prefix('penulis')->name('penulis.')->group(function () {
            Route::get('/', [PenulisController::class, 'indexPenulis'])->name('index');
            Route::get('/create', [PenulisController::class, 'createPenulis'])->name('create');
            Route::post('/', [PenulisController::class, 'storePenulis'])->name('store');
            Route::get('/{id}/edit', [PenulisController::class, 'editPenulis'])->name('edit');
            Route::put('/update', [PenulisController::class, 'updatePenulis'])->name('update');
            Route::delete('/destroy', [PenulisController::class, 'destroyPenulis'])->name('destroy');
        });

        Route::prefix('penerbit')->name('penerbit.')->group(function () {
            Route::get('/', [PenerbitController::class, 'indexPenerbit'])->name('index');
            Route::get('/create', [PenerbitController::class, 'createPenerbit'])->name('create');
            Route::post('/', [PenerbitController::class, 'storePenerbit'])->name('store');
            Route::get('/{id}/edit', [PenerbitController::class, 'editPenerbit'])->name('edit');
            Route::put('/update', [PenerbitController::class, 'updatePenerbit'])->name('update');
            Route::delete('/destroy', [PenerbitController::class, 'destroyPenerbit'])->name('destroy');
        });
    });
});
