<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    $loginType = filter_var($request->login_id, FILTER_VALIDATE_EMAIL)
        ? 'email'
        : 'nomor_identitas';

    $credentials = [
        $loginType => $request->login_id,
        'password' => $request->password,
    ];

    if (Auth::guard('web')->attempt($credentials)) {
        $user = Auth::guard('web')->user();

        // Cek verifikasi admin
        if ($user->verifikasi_admin === 'Menunggu') {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            return back()->with('error', 'Akun Anda sedang menunggu verifikasi admin. Silakan coba beberapa saat lagi.');
        }

        if ($user->verifikasi_admin === 'Ditolak') {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            return back()->with('error', 'Akun Anda ditolak oleh admin. Silakan hubungi perpustakaan untuk informasi lebih lanjut.');
        }

        // Cek status anggota
        if ($user->status_anggota !== 'Aktif') {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            return back()->with('error', 'Akun Anda tidak aktif. Silakan hubungi admin perpustakaan.');
        }

        $request->session()->regenerate();
        return redirect()->route('profile.akun-saya-page')->with('success', 'Login berhasil');
    }

    return back()->with('error', 'Login gagal. Email/Nomor Identitas atau kata sandi salah.');
}

}
