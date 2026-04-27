<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TentangController extends Controller
{
        public function tentangPage()
    {
        return view('tentang');
    }
}
