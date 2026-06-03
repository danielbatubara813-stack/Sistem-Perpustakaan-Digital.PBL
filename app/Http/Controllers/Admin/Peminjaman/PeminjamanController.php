<?php

namespace App\Http\Controllers\Admin\Peminjaman;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;

class PeminjamanController extends Controller
{

    public function ambilDataLoan()
{
    return Peminjaman::with('anggota')
    ->where('status', 'Dipinjam')
    ->get();
}

    public function ambilDataRules()
    {
        $rules = [
            [
                'tipe_anggota' => 'Mahasiswa',
                'tipe_koleksi' => 'Referensi',
                'jumlah' => 2,
                'periode' => '7 Hari'
            ],
            [
                'tipe_anggota' => 'Dosen',
                'tipe_koleksi' => 'Sirkulasi',
                'jumlah' => 3,
                'periode' => '14 Hari'
            ],
            [
                'tipe_anggota' => 'Staf',
                'tipe_koleksi' => 'Referensi',
                'jumlah' => 1,
                'periode' => '7 Hari'
            ]
        ];

        return $rules;
    }

    public function index()
    {
        $loans = $this->ambilDataLoan();

        $title = 'Peminjaman';

        $description = 'Kelola daftar peminjaman buku';

        return view(
            'admin.peminjaman.peminjaman',
            compact('title', 'description', 'loans')
        );
    }

    public function aturan()
    {
        $title = 'Aturan Peminjaman';

        $description =
            'Aturan peminjaman untuk tiap tipe keanggotaan dan koleksi';

        $rules = $this->ambilDataRules();

        return view(
            'admin.peminjaman.aturan',
            compact('title', 'description', 'rules')
        );
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
