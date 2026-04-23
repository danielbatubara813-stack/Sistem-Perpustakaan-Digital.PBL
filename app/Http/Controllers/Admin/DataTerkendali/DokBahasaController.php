<?php

namespace App\Http\Controllers\Admin\DataTerkendali;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DokBahasaController extends Controller
{
    public function ambilDataBahasa()
    {
        $bahasa = [
            [
                'id' => 1,
                'kode_bahasa' => 'EN',
                'nama' => 'Inggris',
                'created_at' => '2026-04-01',
                'updated_at' => '2026-04-01',
            ],
            [
                'id' => 2,
                'kode_bahasa' => 'ID',
                'nama' => 'Indonesia',
                'created_at' => '2026-04-01',
                'updated_at' => '2026-04-01',
            ],
        ];
        return $bahasa;
    }
    public function index()
    {
        $bahasa = $this->ambilDataBahasa();
        return view('admin.dataterkendali.dokumen-bahasa.dokumen-bahasa', compact('bahasa'));
    }

    public function create()
    {
        return view('admin.dataterkendali.dokumen-bahasa.form-dok-bahasa');
    }
}
