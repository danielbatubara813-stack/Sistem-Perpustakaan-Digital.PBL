<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileAnggotaController extends Controller
{
    public function akunSayaPage()
    {
        return view('profile.akunSaya');
    }
}
