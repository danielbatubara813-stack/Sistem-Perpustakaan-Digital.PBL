<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LupaPasswordController extends Controller
{
    /**
     * Tampilkan halaman lupa password.
     */
    public function tampilForm()
    {
        return view('lupa-password');
    }

    /**
     * Proses reset password langsung (tanpa token email).
     */
    public function prosesReset(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'kata_sandi_baru' => 'required|min:6',
            'konfirmasi_kata_sandi' => 'required|same:kata_sandi_baru',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.exists' => 'Email tidak ditemukan.',
            'kata_sandi_baru.required' => 'Kata sandi baru wajib diisi.',
            'kata_sandi_baru.min' => 'Kata sandi minimal 6 karakter.',
            'konfirmasi_kata_sandi.required' => 'Konfirmasi kata sandi wajib diisi.',
            'konfirmasi_kata_sandi.same' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.'])->withInput();
        }

        $user->password = Hash::make($request->kata_sandi_baru);
        $user->save();

        return redirect()->route('login')
            ->with('success', 'Kata sandi berhasil diubah. Silakan login.');
    }
}
