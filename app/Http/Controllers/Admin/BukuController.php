<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function listBuku()
    {
        return view('admin.buku');
    }

    public function create()
    {
        return view('admin.buku-create');
    }

    public function edit($id)
    {
        return view('admin.buku-edit', ['id' => $id]);
    }
}
