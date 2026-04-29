<?php

namespace App\Http\Controllers\Admin\DataTerkendali;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PenulisController extends Controller
{
    public function index()
    {
        $title = 'Data Penulis';
        $description = 'Daftar penulis berdasarkan tipe';
        $penulis = [
            [
                'nama' => 'Tere Liye',
                'tipe' => 'Nama Orang',
                'created_at' => '2026-04-01 10:15:00',
                'updated_at' => '2026-04-10 12:00:00',
            ],
            [
                'nama' => 'Gramedia Pustaka Utama',
                'tipe' => 'Badan Organisasi',
                'created_at' => '2026-03-20 09:00:00',
                'updated_at' => '2026-04-05 14:20:00',
            ],
            [
                'nama' => 'IEEE Conference on Data Science 2025',
                'tipe' => 'Konferensi',
                'created_at' => '2026-02-15 08:30:00',
                'updated_at' => '2026-03-01 11:45:00',
            ],
            [
                'nama' => 'Andrea Hirata',
                'tipe' => 'Nama Orang',
                'created_at' => '2026-04-12 13:10:00',
                'updated_at' => '2026-04-18 16:25:00',
            ],
            [
                'nama' => 'World Health Organization',
                'tipe' => 'Badan Organisasi',
                'created_at' => '2026-01-10 07:50:00',
                'updated_at' => '2026-02-20 10:10:00',
            ],
        ];
        return view('admin.dataterkendali.penulis.penulis', compact('title', 'description', 'penulis'));
    }

    public function create() {
        return view('admin.dataterkendali.penulis.form-penulis');
    }
}
