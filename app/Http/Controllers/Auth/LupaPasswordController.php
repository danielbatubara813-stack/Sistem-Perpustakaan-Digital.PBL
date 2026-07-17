<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Mail;

class LupaPasswordController extends Controller
{

    public function verifikasiEmail()
    {
        return view('verifikasi-email');
    }

    public function checkVerifikasiEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:anggota,email',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.exists' => 'Email tidak ditemukan.',
        ]);

        $anggota = Anggota::where('email', $request->email)->first();

        $token = Password::broker('anggota')->createToken($anggota);

        $url = route('password.reset', [
            'token' => $token,
            'email' => $anggota->email,
        ]);

        Mail::to($anggota->email)
            ->send(new ResetPasswordMail($anggota, $url));

        return redirect()->back()->with(
            'success',
            'Link reset password berhasil dikirim ke email Anda.'
        );
    }

    public function showResetPassword(Request $request, $token)
    {
        return view('reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    public function prosesReset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ], [
            'token.required' => 'Token reset password tidak valid.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sama.',
        ]);

        $status = Password::broker('anggota')->reset(
            $request->only(
                'email',
                'password',
                'password_confirmation',
                'token'
            ),

            function ($anggota, $password) {
                $anggota->password = Hash::make($password);
                $anggota->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()
                ->route('login-page')
                ->with(
                    'success',
                    'Password berhasil diubah. Silakan login kembali.'
                );
        }

        return back()->withErrors([
            'email' => __($status),
        ])->withInput();
    }
}
