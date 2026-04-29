<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileAnggotaController extends Controller
{
    public function akunSayaPage()
    {
        return view('profile.akun-saya');
    }
}
