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
            $request->session()->regenerate();
            return redirect()->route('profile.akun-saya-page');
        }

        return back()->with('error', 'Login gagal. Email/Nomor Identitas atau kata sandi salah.');
    }
}
