<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{

    public function register()
    {
        return view('register');
    }

    public function prosesRegister(Request $request)
    {
        $request->validate([
            'nik' => 'required|unique:users,nik',
            'email' => 'required|email|unique:users,email',
            'name' => 'required',
            'no_handphone' => 'required',
            'password' => 'required|confirmed|min:6',
        ], [
            'nik.required' => 'NIK wajib diisi.',
            'nik.unique' => 'NIK sudah terdaftar sebelumnya.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar sebelumnya.',
            'name.required' => 'Nama lengkap wajib diisi.',
            'no_handphone.required' => 'Nomor handphone wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
        ]);

        do {
            $memberId = str_pad(mt_rand(1, 9999999999), 10, '0', STR_PAD_LEFT);
        } while (User::where('member_id', $memberId)->exists());

        $user = User::create([
            'nik' => $request->nik,
            'email' => $request->email,
            'name' => $request->name,
            'phone' => $request->no_handphone,
            'member_id' => $memberId,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/admin/dashboard')->with('success', 'Akun berhasil dibuat! Member ID Anda: ' . $memberId);
    }
}
