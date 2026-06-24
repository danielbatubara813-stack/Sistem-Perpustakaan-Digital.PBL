<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Anggota;

class HomeController extends Controller
{
    public function homePage()
    {
        $koleksi_baru = Buku::with(['penulis', 'penerbit', 'tipe', 'bahasa', 'items'])
            ->orderBy('tanggal_dibuat', 'desc')
            ->limit(7)
            ->get()
            ->map(fn($buku) => $this->formatBook($buku));

        $koleksi_popular = Buku::with(['penulis', 'penerbit', 'tipe', 'bahasa', 'items'])
            ->withCount([
                'items as dipinjam_count' => fn($query) => $query->where('status_item', 'Sedang Dipinjam'),
            ])
            ->orderByDesc('dipinjam_count')
            ->orderByDesc('tanggal_dibuat')
            ->limit(7)
            ->get()
            ->map(fn($buku) => $this->formatBook($buku));

        $penikmat_koleksi = Anggota::with(['peminjaman', 'jenisKeanggotaan'])
            ->withCount('peminjaman')
            ->orderBy('peminjaman_count', 'desc')
            ->limit(3)
            ->get()
            ->map(function ($anggota) {
                $totalBukuYangDipinjam = $anggota->peminjaman()
                    ->where('status', 'Dipinjam')
                    ->count();

                return [
                    'nama' => $anggota->nama,
                    'jenis_keanggotaan' => $anggota->jenisKeanggotaan->nama_jenis ?? 'Anggota',
                    'total_peminjaman' => $anggota->peminjaman_count,
                    'total_buku' => $totalBukuYangDipinjam,
                    'profile' => $anggota->profile
                        ? asset('storage/' . $anggota->profile)
                        : asset('images/bookcover.png'),
                ];
            });

        return view('home', compact('koleksi_baru', 'koleksi_popular', 'penikmat_koleksi'));
    }

    private function formatBook(Buku $buku): array
    {
        return [
            'id' => $buku->id_buku,
            'judul' => $buku->judul_buku,
            'penulis' => $buku->penulis->pluck('nama_penulis')->filter()->join(', ') ?: '-',
            'cover' => $buku->cover_buku
                ? asset('storage/covers/' . $buku->cover_buku)
                : asset('images/bookcover.png'),
            'isbn' => $buku->isbn,
            'edisi' => $buku->edisi,
            'penerbit' => $buku->penerbit->nama_penerbit ?? '-',
            'no_panggil' => $buku->no_panggil,
            'deskripsi' => $buku->deskripsi,
            'ketersediaan' => $buku->items->where('status_item', 'Tersedia')->count(),
        ];
    }
}
