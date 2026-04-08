<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function proses(Request $request)
    {
        $request->validate([
            'login_id' => 'required',
            'password' => 'required',
        ], [
            'login_id.required' => 'Email / Member ID wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $loginType = filter_var($request->login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'member_id';

        $credentials = [
            $loginType => $request->login_id,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect('/admin/dashboard');
        }

        return back()->with('error', 'Login gagal. Kombinasi Email/Member ID dan Kata Sandi tidak sesuai.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}