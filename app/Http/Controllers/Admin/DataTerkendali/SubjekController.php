<?php

namespace App\Http\Controllers\Admin\DataTerkendali;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubjekController extends Controller
{
    public function ambilDataSubjek()
    {
        $subjek = [
            [
                'id' => 1,
                'kode_subjek' => 'PRG',
                'nama' => 'Programming',
                'created_at' => '2026-04-01',
                'updated_at' => '2026-04-01',
            ],
            [
                'id' => 2,
                'kode_subjek' => 'MNG',
                'nama' => 'Manajemen',
                'created_at' => '2026-04-01',
                'updated_at' => '2026-04-02',
            ],
            [
                'id' => 3,
                'kode_subjek' => 'TECH',
                'nama' => 'Technology',
                'created_at' => '2026-04-01',
                'updated_at' => '2026-04-03',
            ],
            [
                'id' => 4,
                'kode_subjek' => 'NET',
                'nama' => 'Networking',
                'created_at' => '2026-04-01',
                'updated_at' => '2026-04-01',
            ],
            [
                'id' => 5,
                'kode_subjek' => 'DB',
                'nama' => 'Database',
                'created_at' => '2026-04-01',
                'updated_at' => '2026-04-04',
            ],
            [
                'id' => 6,
                'kode_subjek' => 'AI',
                'nama' => 'Artificial Intelligence',
                'created_at' => '2026-04-01',
                'updated_at' => '2026-04-05',
            ],
            [
                'id' => 7,
                'kode_subjek' => 'BUS',
                'nama' => 'Bisnis',
                'created_at' => '2026-04-01',
                'updated_at' => '2026-04-01',
            ],
            [
                'id' => 8,
                'kode_subjek' => 'FIN',
                'nama' => 'Keuangan',
                'created_at' => '2026-04-01',
                'updated_at' => '2026-04-02',
            ],
            [
                'id' => 9,
                'kode_subjek' => 'DSN',
                'nama' => 'Desain',
                'created_at' => '2026-04-01',
                'updated_at' => '2026-04-03',
            ],
            [
                'id' => 10,
                'kode_subjek' => 'EDU',
                'nama' => 'Pendidikan',
                'created_at' => '2026-04-01',
                'updated_at' => '2026-04-01',
            ],
        ];
        return $subjek;
    }
    public function index()
    {
        $subjek = $this->ambilDataSubjek();
        return view('admin.dataterkendali.subjek.subjek', compact('subjek'));
    }

    public function create()
    {
        return view('admin.dataterkendali.subjek.form-subjek');
    }
}
