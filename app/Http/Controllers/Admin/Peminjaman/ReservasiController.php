<?php

namespace App\Http\Controllers\Admin\Peminjaman;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    public function ambilData()
    {
        $reservasi = $reservasi ?? [
            [
                'id' => 1,
                'nama_pengaju' => 'Daniel Anju Adinov Batubara',
                'identity' => '3312501025',
                'judul' => 'Laut Bercerita',
                'penulis' => 'Leila S. Chudori',
                'cover' => 'https://imgv2-1-f.scribdassets.com/img/document/443499450/original/75e0895939/1?v=1',
                'tanggal_pengajuan' => '10-04-2026 09:10:00',
                'status_reservasi' => 'Menunggu Konfirmasi',
            ],
            [
                'id' => 2,
                'nama_pengaju' => 'Cynthia Lasmini',
                'identity' => '3312501026',
                'judul' => 'Atomic Habits',
                'penulis' => 'James Clear',
                'cover' => 'https://images-na.ssl-images-amazon.com/images/I/91bYsX41DVL.jpg',
                'tanggal_pengajuan' => '11-04-2026 10:20:15',
                'status_reservasi' => 'Sudah Konfirmasi',
            ],
            [
                'id' => 3,
                'nama_pengaju' => 'Rudi Hartono',
                'identity' => '3312501027',
                'judul' => 'Clean Code',
                'penulis' => 'Robert C. Martin',
                'cover' => 'https://images-na.ssl-images-amazon.com/images/I/41jEbK-jG+L.jpg',
                'tanggal_pengajuan' => '12-04-2026 13:45:30',
                'status_reservasi' => 'Ditolak',
            ],
            [
                'id' => 4,
                'nama_pengaju' => 'Siti Aisyah',
                'identity' => '3312501028',
                'judul' => 'Rich Dad Poor Dad',
                'penulis' => 'Robert T. Kiyosaki',
                'cover' => 'https://images-na.ssl-images-amazon.com/images/I/81bsw6fnUiL.jpg',
                'tanggal_pengajuan' => '13-04-2026 08:25:10',
                'status_reservasi' => 'Menunggu Konfirmasi',
            ],
            [
                'id' => 5,
                'nama_pengaju' => 'Andi Saputra',
                'identity' => '3312501029',
                'judul' => 'Deep Work',
                'penulis' => 'Cal Newport',
                'cover' => 'https://images-na.ssl-images-amazon.com/images/I/71g2ednj0JL.jpg',
                'tanggal_pengajuan' => '14-04-2026 14:12:55',
                'status_reservasi' => 'Sudah Konfirmasi',
            ],
            [
                'id' => 6,
                'nama_pengaju' => 'Dewi Lestari',
                'identity' => '3312501030',
                'judul' => 'The Pragmatic Programmer',
                'penulis' => 'Andrew Hunt',
                'cover' => 'https://images-na.ssl-images-amazon.com/images/I/518FqJvR9aL.jpg',
                'tanggal_pengajuan' => '15-04-2026 16:40:22',
                'status_reservasi' => 'Menunggu Konfirmasi',
            ],
            [
                'id' => 7,
                'nama_pengaju' => 'Budi Santoso',
                'identity' => '3312501031',
                'judul' => 'Sapiens',
                'penulis' => 'Yuval Noah Harari',
                'cover' => 'https://images-na.ssl-images-amazon.com/images/I/713jIoMO3UL.jpg',
                'tanggal_pengajuan' => '16-04-2026 11:05:33',
                'status_reservasi' => 'Ditolak',
            ],
            [
                'id' => 8,
                'nama_pengaju' => 'Lina Marlina',
                'identity' => '3312501032',
                'judul' => 'Laravel Up & Running',
                'penulis' => 'Matt Stauffer',
                'cover' => 'https://images-na.ssl-images-amazon.com/images/I/51Q4XzF6UQL.jpg',
                'tanggal_pengajuan' => '17-04-2026 09:55:44',
                'status_reservasi' => 'Sudah Konfirmasi',
            ],
            [
                'id' => 9,
                'nama_pengaju' => 'Hendra Wijaya',
                'identity' => '3312501033',
                'judul' => 'Start With Why',
                'penulis' => 'Simon Sinek',
                'cover' => 'https://images-na.ssl-images-amazon.com/images/I/71t4GuxLCuL.jpg',
                'tanggal_pengajuan' => '18-04-2026 12:15:18',
                'status_reservasi' => 'Menunggu Konfirmasi',
            ],
            [
                'id' => 10,
                'nama_pengaju' => 'Maya Putri',
                'identity' => '3312501034',
                'judul' => 'Thinking Fast and Slow',
                'penulis' => 'Daniel Kahneman',
                'cover' => 'https://images-na.ssl-images-amazon.com/images/I/71w6Z+1kZEL.jpg',
                'tanggal_pengajuan' => '19-04-2026 15:30:05',
                'status_reservasi' => 'Sudah Konfirmasi',
            ],
        ];

        return $reservasi;
    }
    public function reservasi()
    {
        $reservasi = $this->ambilData();
        return view('admin.peminjaman.daftar-reservasi', compact('reservasi'));
    }
}
