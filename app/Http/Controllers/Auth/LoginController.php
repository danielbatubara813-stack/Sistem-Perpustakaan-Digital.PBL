<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function proses(Request $request)
    {
        $request->validate([
            'login_id' => 'required',
            'password' => 'required',
        ], [
            'login_id.required' => 'Email / Nomor Identitas wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $loginId = $request->login_id;

        $anggota = Anggota::where('email', $loginId)
            ->orWhere('nomor_identitas', $loginId)
            ->first();

        if (! $anggota || ! Hash::check($request->password, $anggota->password)) {
            return back()->with('error', 'Login gagal. Email/Nomor Identitas atau kata sandi salah.');
        }

        if (! $anggota->dapatMengaksesLayanan()) {
            return back()->with('error', $anggota->pesanAksesDitolak());
        }

        Auth::guard('web')->login($anggota);
        $request->session()->regenerate();

        return redirect()->route('profile.akun-saya-page')->with('success', 'Login berhasil');
    }
}
