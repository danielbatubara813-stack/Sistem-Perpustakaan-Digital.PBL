<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    public function ambilData()
    {
        $reservasi = [
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

                'tanggal_pengajuan' => '16-04-2026',
                'status_reservasi' => 'Menunggu Konfirmasi',
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

                'tanggal_pengajuan' => '26-04-2026',
                'status_reservasi' => 'Sudah Konfirmasi',
            ],
        ];
        return $reservasi;
    }
    public function reservasi()
    {
        $reservasi = $this->ambilData();
        return view('profile.reservasi', compact('reservasi'));
    }

    public function daftarReservasi()
    {
        $reservasi = $this->ambilData();
        return view('profile.daftar-reservasi', compact('reservasi'));
    }
}
