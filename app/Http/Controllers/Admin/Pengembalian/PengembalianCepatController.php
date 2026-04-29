<?php

namespace App\Http\Controllers\Admin\Pengembalian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PengembalianCepatController extends Controller
{
    public function index()
    {
        $title = 'Pengembalian';
        $description = 'Kelola pengembalian buku';

        return view('admin.pengembalian.pengembalian-cepat', compact('title', 'description'));
    }
}
