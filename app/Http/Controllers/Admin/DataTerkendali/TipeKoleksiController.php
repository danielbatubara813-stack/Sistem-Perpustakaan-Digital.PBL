<?php

namespace App\Http\Controllers\Admin\DataTerkendali;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TipeKoleksiController extends Controller
{
    public function ambilDataTipe()
    {
        $tipe_koleksi = [
            [
                'id' => 1,
                'nama' => 'Buku Teks',
                'created_at' => '2026-04-01 08:00:00',
                'updated_at' => '2026-04-01 08:00:00',
            ],
            [
                'id' => 2,
                'nama' => 'Referensi',
                'created_at' => '2026-04-01 08:10:00',
                'updated_at' => '2026-04-02 09:00:00',
            ],
            [
                'id' => 3,
                'nama' => 'Fiksi',
                'created_at' => '2026-04-01 08:20:00',
                'updated_at' => '2026-04-01 08:20:00',
            ],
            [
                'id' => 4,
                'nama' => 'Non-Fiksi',
                'created_at' => '2026-04-01 08:30:00',
                'updated_at' => '2026-04-03 10:15:00',
            ],
            [
                'id' => 5,
                'nama' => 'Majalah',
                'created_at' => '2026-04-01 08:40:00',
                'updated_at' => '2026-04-01 08:40:00',
            ],
            [
                'id' => 6,
                'nama' => 'Jurnal',
                'created_at' => '2026-04-01 08:50:00',
                'updated_at' => '2026-04-04 11:20:00',
            ],
            [
                'id' => 7,
                'nama' => 'Skripsi',
                'created_at' => '2026-04-01 09:00:00',
                'updated_at' => '2026-04-01 09:00:00',
            ],
            [
                'id' => 8,
                'nama' => 'Tesis',
                'created_at' => '2026-04-01 09:10:00',
                'updated_at' => '2026-04-02 13:45:00',
            ],
            [
                'id' => 9,
                'nama' => 'E-Book',
                'created_at' => '2026-04-01 09:20:00',
                'updated_at' => '2026-04-05 14:00:00',
            ],
            [
                'id' => 10,
                'nama' => 'Ensiklopedia',
                'created_at' => '2026-04-01 09:30:00',
                'updated_at' => '2026-04-01 09:30:00',
            ],
        ];
        return $tipe_koleksi;
    }
    public function index()
    {
        $tipe_koleksi = $this->ambilDataTipe();
        return view('admin.dataterkendali.tipe-koleksi.tipe-koleksi', compact('tipe_koleksi'));
    }

    public function create()
    {
        return view('admin.dataterkendali.tipe-koleksi.form-tipe-koleksi');
    }
}
