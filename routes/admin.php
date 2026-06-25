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
use App\Http\Controllers\Admin\ExportLaporanController;
use App\Http\Controllers\Admin\Peminjaman\PeminjamanController;
use App\Http\Controllers\Admin\Peminjaman\ReservasiController;
use App\Http\Controllers\Admin\Pengembalian\PengembalianBukuController;
use App\Http\Controllers\Admin\Pengembalian\PengembalianCepatController;
use App\Http\Controllers\Admin\Pengembalian\PengembalianController;
use App\Http\Controllers\Auth\LoginAdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use Illuminate\Support\Facades\Route;

// kumpulan halaman admin
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/login', [LoginAdminController::class, 'login'])->name('login-page');
    Route::post('/login', [LoginAdminController::class, 'proses'])->name('login.proses');

    Route::post('/logout', [LogoutController::class, 'logoutAdmin'])->name('logout');

    Route::middleware('auth:admin')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

        // Buku (hapus duplikat)
        Route::get('/list-buku', [BukuController::class, 'listBuku'])->name('buku');
        Route::get('/list-buku/create', [BukuController::class, 'create'])->name('buku.create');
        Route::post('/list-buku', [BukuController::class, 'store'])->name('buku.store');
        Route::get('/list-buku/{id}/edit', [BukuController::class, 'edit'])->name('buku.edit');
        Route::put('/list-buku/{id}', [BukuController::class, 'update'])->name('buku.update');
        Route::delete('/list-buku/{id}', [BukuController::class, 'destroy'])->name('buku.destroy');
        Route::delete('/list-buku/destroy', [BukuController::class, 'destroyMultiple'])->name('buku.destroyMultiple');

        // Anggota
        Route::prefix('list-anggota')->name('anggota.')->group(function () {
            Route::get('/', [AnggotaController::class, 'indexAnggota'])->name('daftar');
            Route::get('/create', [AnggotaController::class, 'createAnggota'])->name('create');
            Route::post('/', [AnggotaController::class, 'storeAnggota'])->name('store');
            Route::delete('/destroy', [AnggotaController::class, 'destroyAnggota'])->name('destroy');
            Route::get('/{id}/edit', [AnggotaController::class, 'editAnggota'])->name('edit');
            Route::put('/{id}', [AnggotaController::class, 'updateAnggota'])->name('update');

            Route::get('/jenis', [JenisKeanggotaanController::class, 'jenis'])->name('jenis');
            Route::get('/jenis/create', [JenisKeanggotaanController::class, 'jenisCreate'])->name('jenis.create');
            Route::post('/jenis', [JenisKeanggotaanController::class, 'jenisStore'])->name('jenis.store');
            Route::delete('/jenis/destroy', [JenisKeanggotaanController::class, 'destroyJenis'])->name('jenis.destroy');
            Route::get('/jenis/{id}/edit', [JenisKeanggotaanController::class, 'jenisEdit'])->name('jenis.edit');
            Route::put('/jenis/{id}', [JenisKeanggotaanController::class, 'jenisUpdate'])->name('jenis.update');
            Route::delete('/jenis/{id}', [JenisKeanggotaanController::class, 'jenisDestroy'])->name('jenis.destroy');
        });

        // Peminjaman
        Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman');
        Route::get('/peminjaman/catat-peminjaman', [PeminjamanController::class, 'catatPeminjaman'])
            ->name('peminjaman.catat-peminjaman');
        Route::post('/peminjaman/catat-peminjaman', [PeminjamanController::class, 'store'])
            ->name('peminjaman.store');

        Route::get('/peminjaman/aturan', [PeminjamanController::class, 'aturan'])
            ->name('peminjaman.aturan');
        Route::get('/peminjaman/aturan/create', [PeminjamanController::class, 'aturanCreate'])
            ->name('peminjaman.aturan.create');
        Route::post('/peminjaman/aturan', [PeminjamanController::class, 'aturanStore'])
            ->name('peminjaman.aturan.store');
        Route::delete('/peminjaman/aturan/destroy', [PeminjamanController::class, 'aturanDestroyMultiple'])
            ->name('peminjaman.aturan.destroyMultiple');
        Route::get('/peminjaman/aturan/{id}/edit', [PeminjamanController::class, 'aturanEdit'])
            ->name('peminjaman.aturan.edit');
        Route::put('/peminjaman/aturan/{id}', [PeminjamanController::class, 'aturanUpdate'])
            ->name('peminjaman.aturan.update');
        Route::delete('/peminjaman/aturan/{id}', [PeminjamanController::class, 'aturanDestroy'])
            ->name('peminjaman.aturan.destroy');

        Route::get('/reservasi', [ReservasiController::class, 'reservasi'])->name('peminjaman.reservasi');
        Route::put('/reservasi/disetujui', [ReservasiController::class, 'reservasiDisetujui'])->name('peminjaman.reservasi.disetujui');
        Route::put('/reservasi/ditolak', [ReservasiController::class, 'reservasiDitolak'])->name('peminjaman.reservasi.ditolak');
        Route::put('/reservasi/jadikan-peminjaman', [ReservasiController::class, 'jadikanPeminjaman'])->name('peminjaman.reservasi.jadikan-peminjaman');
        
        // Pengembalian
        Route::prefix('pengembalian')->name('pengembalian.')->group(function () {
            Route::get('/', [PengembalianController::class, 'index'])
                ->name('index');
            Route::get('/cepat', [PengembalianCepatController::class, 'index'])
                ->name('cepat');
            Route::post('/cepat', [PengembalianCepatController::class, 'pengembalianCepat'])
                ->name('cepat-process');
            Route::get('/buku', [PengembalianBukuController::class, 'index'])
                ->name('buku');
            Route::post('/buku', [PengembalianBukuController::class, 'kembalikanBuku'])
                ->name('kembalikan');
        });

        // Data Terkendali
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
        Route::post('/export/laporan', [ExportLaporanController::class, 'export'])->name('export.laporan');

    });

});
