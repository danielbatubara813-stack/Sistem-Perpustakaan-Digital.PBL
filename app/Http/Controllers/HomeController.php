<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Anggota;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function homePage()
    {
        $koleksi_baru = Buku::with([
            'penulis',
            'penerbit',
            'tipe',
            'bahasa',
        ])
            ->withCount([
                'items as ketersediaan' => fn($query) =>
                    $query->where('status_item', 'Tersedia'),
            ])
            ->latest('tanggal_dibuat')
            ->take(7)
            ->get();

        $koleksi_popular = Buku::with([
            'penulis',
            'penerbit',
            'tipe',
            'bahasa',
        ])
            ->withCount([
                'items as dipinjam_count' => fn($query) =>
                    $query->where('status_item', 'Dipinjam'),

                'items as ketersediaan' => fn($query) =>
                    $query->where('status_item', 'Tersedia'),
            ])
            ->orderByDesc('dipinjam_count')
            ->orderByDesc('tanggal_dibuat')
            ->take(7)
            ->get();

        $penikmat_koleksi = Anggota::with('jenisKeanggotaan')
            ->withCount('peminjaman')
            ->addSelect([
                'total_buku' => DB::table('peminjaman')
                    ->join('item_buku', 'item_buku.id_item', '=', 'peminjaman.id_item')
                    ->whereColumn('peminjaman.id_anggota', 'anggota.id_anggota')
                    ->selectRaw('COUNT(DISTINCT item_buku.id_buku)')
            ])
            ->orderByDesc('total_buku')
            ->take(3)
            ->get();

        return view('home', compact('koleksi_baru', 'koleksi_popular', 'penikmat_koleksi'));
    }
}
