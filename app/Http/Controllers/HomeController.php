<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Anggota;

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
                    $query->where('status_item', 'Sedang Dipinjam'),

                'items as ketersediaan' => fn($query) =>
                    $query->where('status_item', 'Tersedia'),
            ])
            ->orderByDesc('dipinjam_count')
            ->orderByDesc('tanggal_dibuat')
            ->take(7)
            ->get();

        $penikmat_koleksi = Anggota::with('jenisKeanggotaan')
            ->withCount('peminjaman')
            ->orderByDesc('peminjaman_count')
            ->take(3)
            ->get();

        return view('home', compact('koleksi_baru', 'koleksi_popular', 'penikmat_koleksi'));
    }
}
