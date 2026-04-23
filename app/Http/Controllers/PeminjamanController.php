<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function ambilDataBuku()
    {
        $koleksi_baru = [
            [
                'id' => 1,
                'judul' => 'Laut Bercerita',
                'penulis' => 'Leila S. Chudori',
                'cover' => 'https://imgv2-1-f.scribdassets.com/img/document/443499450/original/75e0895939/1?v=1',
                'edisi' => 'Cet. 1',
                'isbn' => '9786024246945',
                'no_panggil' => '813 LEI l',
                'tahun' => 2017,
                'penerbit' => 'Kepustakaan Populer Gramedia',
                'bahasa' => 'Indonesia',
                'halaman' => 379,
                'subject' => ['Fiksi', 'Sejarah', 'Sosial Politik', 'Novel Indonesia'],
                'deskripsi' => 'Novel yang mengangkat kisah aktivis mahasiswa pada masa Orde Baru.',

                'kode_item_buku' => 'BK001246',
                'tanggal_jatuh_tempo' => '16-04-2026',
                'status_peminjaman' => 'Masa Peminjaman',
            ],

            [
                'id' => 2,
                'judul' => 'Semua Bisa Menjadi Programmer Laravel Basic',
                'penulis' => 'Yuniar Supardi',
                'cover' => 'https://cdn.gramedia.com/uploads/items/9786230010460_Cov_Semua_Bisa_Menjadi_Programmer_Laravel_Basic.jpg',
                'edisi' => 'Cet. 1',
                'isbn' => '9786230010460',
                'no_panggil' => '005.262 YUN s',
                'tahun' => 2022,
                'penerbit' => 'Elex Media',
                'bahasa' => 'Indonesia',
                'halaman' => 320,
                'subject' => ['Programming', 'Laravel', 'PHP', 'Web Development'],
                'deskripsi' => 'Panduan dasar framework Laravel untuk pemula.',

                'kode_item_buku' => 'BK001301',
                'tanggal_jatuh_tempo' => '26-04-2026',
                'status_peminjaman' => 'Jatuh Tempo',
            ],
        ];

        return $koleksi_baru;
    }
    public function peminjamanSekarangPage()
    {
        $koleksi_baru = $this->ambilDataBuku();
        return view('profile.peminjamanSekarang', compact('koleksi_baru'));
    }

    public function sejarahPeminjamanPage()
    {
        $koleksi_baru = $this->ambilDataBuku();
        return view('profile.sejarahPeminjaman', compact('koleksi_baru'));
    }

}
