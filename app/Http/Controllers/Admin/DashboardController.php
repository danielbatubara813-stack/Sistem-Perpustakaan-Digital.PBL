<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\ItemBuku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // fungsi mengembalikan view pada admin
    public function dashboard()
    {
        $totalBuku = Buku::count();

        $totalBukuDipinjam = ItemBuku::where('status_item', 'Sedang Dipinjam')
            ->count();

        $totalAnggota = Anggota::count();

        $totalPeminjaman = Peminjaman::count();

        $statusAnggota = Anggota::selectRaw('status_anggota, COUNT(*) as total')
            ->groupBy('status_anggota')
            ->pluck('total', 'status_anggota');

        $statusPeminjaman = Peminjaman::selectRaw('status, COUNT(*) as total_peminjaman')
            ->groupBy('status')
            ->pluck('total_peminjaman', 'status');

        $bukuTerbaru = Buku::with([
            'penulis',
            'penerbit',
            'tipe'
        ])
            ->latest('tanggal_dibuat')
            ->take(10)
            ->get();

        $peminjamanTerbaru = Peminjaman::with([
            'anggota',
            'itemBuku.buku'
        ])
            ->latest('tanggal_peminjaman')
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalBuku',
            'totalBukuDipinjam',
            'totalAnggota',
            'totalPeminjaman',
            'statusAnggota',
            'statusPeminjaman',
            'bukuTerbaru',
            'peminjamanTerbaru'
        ));
    }
}
