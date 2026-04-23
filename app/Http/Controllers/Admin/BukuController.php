<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function ambilDataBuku()
    {
        $koleksi_baru = [
            [
                'judul' => 'Laut Bercerita',
                'penulis' => 'Leila S. Chudori',
                'isbn' => '9786024246945',
                'last_update' => '2026-04-02',
                'jumlah_copy' => 2,
            ],
            [
                'judul' => 'Semua Bisa Menjadi Programmer Laravel Basic',
                'penulis' => 'Yuniar Supardi',
                'isbn' => '9786230010460',
                'last_update' => '2026-04-12',
                'jumlah_copy' => 2,
            ],
            [
                'judul' => 'The Next.js Handbook: A Complete Resource for Developers',
                'penulis' => 'Brandon Kim',
                'isbn' => '9781803235929',
                'last_update' => '2026-04-15',
                'jumlah_copy' => 2,
            ],
            [
                'judul' => 'Akuntansi Dasar Untuk Bisnis: Teori dan Praktik',
                'penulis' => 'Ely Suhayati',
                'isbn' => '9786232287655',
                'last_update' => '2026-04-01',
                'jumlah_copy' => 1,
            ],
            [
                'judul' => 'Buku Internet of Things (IoT) dan Aplikasinya',
                'penulis' => 'Adhan Efendi',
                'isbn' => '9786230269370',
                'last_update' => '2026-04-01',
                'jumlah_copy' => 1,
            ],
            [
                'judul' => 'Blockchain: Dari Konsep hingga Implementasi',
                'penulis' => 'Achmad Fitro, S. Kom., M.Kom, dkk.',
                'isbn' => '9786230225475',
                'last_update' => '2026-04-18',
                'jumlah_copy' => 2,
            ],
            [
                'judul' => 'Rich Dad Poor Dad',
                'penulis' => 'Robert T. Kiyosaki',
                'isbn' => '9786020333175',
                'last_update' => '2026-04-11',
                'jumlah_copy' => 2,
            ],
            [
                'judul' => 'Clean Code',
                'penulis' => 'Robert C. Martin',
                'isbn' => '9780132350884',
                'last_update' => '2026-04-01',
                'jumlah_copy' => 1,
            ],
            [
                'judul' => 'Atomic Habits',
                'penulis' => 'James Clear',
                'isbn' => '9780735211292',
                'last_update' => '2026-04-01',
                'jumlah_copy' => 1,
            ],
            [
                'judul' => 'Database System Concepts',
                'penulis' => 'Abraham Silberschatz',
                'isbn' => '9780078022159',
                'last_update' => '2026-04-09',
                'jumlah_copy' => 2,
            ],
        ];

        return $koleksi_baru;
    }
    public function listBuku()
    {
        $books = $this->ambilDataBuku();

        return view('admin.buku.buku', compact('books'));
    }

    public function create()
    {
        return view('admin.buku.buku-create');
    }

    public function edit($id)
    {
        return view('admin.buku.buku-edit', ['id' => $id]);
    }
}
