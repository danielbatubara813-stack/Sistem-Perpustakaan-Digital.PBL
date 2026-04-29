<?php

namespace App\Http\Controllers\Admin\Peminjaman;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function ambilDataLoan()
    {
        $loans = $loans ?? [
            [
                'member' => 'Daniel Anju Adinov Batubara',
                'identity' => '3312501025',
                'kode_item' => '0735712573',
                'tanggal_pinjam' => '02-04-2026 10:02:22',
                'jatuh_tempo' => '09-04-2026 10:02:22',
            ],
            [
                'member' => 'Cynthia Lasmini',
                'identity' => '3312501026',
                'kode_item' => '0735712574',
                'tanggal_pinjam' => '03-04-2026 12:20:05',
                'jatuh_tempo' => '10-04-2026 12:20:05',
            ],
            [
                'member' => 'Rudi Hartono',
                'identity' => '3312501027',
                'kode_item' => '0735712575',
                'tanggal_pinjam' => '04-04-2026 09:15:00',
                'jatuh_tempo' => '11-04-2026 09:15:00',
            ],
            [
                'member' => 'Siti Aisyah',
                'identity' => '3312501028',
                'kode_item' => '0735712576',
                'tanggal_pinjam' => '05-04-2026 08:30:10',
                'jatuh_tempo' => '12-04-2026 08:30:10',
            ],
            [
                'member' => 'Andi Saputra',
                'identity' => '3312501029',
                'kode_item' => '0735712577',
                'tanggal_pinjam' => '06-04-2026 14:45:33',
                'jatuh_tempo' => '13-04-2026 14:45:33',
            ],
            [
                'member' => 'Dewi Lestari',
                'identity' => '3312501030',
                'kode_item' => '0735712578',
                'tanggal_pinjam' => '07-04-2026 11:10:55',
                'jatuh_tempo' => '14-04-2026 11:10:55',
            ],
            [
                'member' => 'Budi Santoso',
                'identity' => '3312501031',
                'kode_item' => '0735712579',
                'tanggal_pinjam' => '08-04-2026 16:25:40',
                'jatuh_tempo' => '15-04-2026 16:25:40',
            ],
            [
                'member' => 'Lina Marlina',
                'identity' => '3312501032',
                'kode_item' => '0735712580',
                'tanggal_pinjam' => '09-04-2026 13:05:12',
                'jatuh_tempo' => '16-04-2026 13:05:12',
            ],
            [
                'member' => 'Hendra Wijaya',
                'identity' => '3312501033',
                'kode_item' => '0735712581',
                'tanggal_pinjam' => '10-04-2026 09:50:27',
                'jatuh_tempo' => '17-04-2026 09:50:27',
            ],
            [
                'member' => 'Maya Putri',
                'identity' => '3312501034',
                'kode_item' => '0735712582',
                'tanggal_pinjam' => '11-04-2026 15:35:18',
                'jatuh_tempo' => '18-04-2026 15:35:18',
            ],
        ];
        return $loans;
    }
    public function ambilDataRules()
    {
        $rules = $rules ?? [
            ['tipe_anggota' => 'Mahasiswa', 'tipe_koleksi' => 'Referensi', 'jumlah' => 2, 'periode' => '7 Hari'],
            ['tipe_anggota' => 'Dosen', 'tipe_koleksi' => 'Sirkulasi', 'jumlah' => 3, 'periode' => '14 Hari'],
            ['tipe_anggota' => 'Staf', 'tipe_koleksi' => 'Referensi', 'jumlah' => 1, 'periode' => '7 Hari'],
        ];
        return $rules;
    }
    public function index()
    {
        $loans = $this->ambilDataLoan();
        $title = 'Peminjaman';
        $description = 'Kelola daftar peminjaman buku';

        return view('admin.peminjaman.peminjaman', compact('title', 'description', 'loans'));
    }

    public function aturan()
    {
        $title = 'Aturan Peminjaman';
        $description = 'Aturan peminjaman untuk tiap tipe keanggotaan dan koleksi';
        $rules = $this->ambilDataRules();

        return view('admin.peminjaman.aturan', compact('title', 'description', 'rules'));
    }

    public function catatPeminjaman()
    {
        return view('admin.peminjaman.catat-peminjaman');
    }

    public function aturanCreate()
    {
        return view('admin.peminjaman.form-aturan-peminjaman');
    }
}
