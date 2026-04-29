<?php

namespace App\Http\Controllers\Admin\DataTerkendali;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PenerbitController extends Controller
{
    public function index()
    {
        $penerbit = [
            [
                'nama' => 'Gramedia',
                'created_at' => '2024-01-01 10:00:00',
                'updated_at' => '2024-01-05 12:00:00'
            ],
            [
                'nama' => 'Erlangga',
                'created_at' => '2024-02-10 09:30:00',
                'updated_at' => '2024-02-12 14:20:00'
            ],
            [
                'nama' => 'Mizan',
                'created_at' => '2024-03-15 08:15:00',
                'updated_at' => '2024-03-18 16:45:00'
            ],
        ];

        return view('admin.dataterkendali.penerbit.penerbit', compact('penerbit'));
    }

    public function create()
    {
        return view('admin.dataterkendali.penerbit.form-penerbit');
    }
}
