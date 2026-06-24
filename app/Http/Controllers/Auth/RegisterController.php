<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\JenisKeanggotaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register()
    {
        session()->forget('_old_input');
        return view('register');
    }

    public function prosesRegister(Request $request)
    {
        $request->validate([
            'email'          => 'required|email|unique:anggota,email',
            'nik'            => 'required|unique:anggota,nomor_identitas',
            'name'           => 'required',
            'no_handphone'   => 'required|unique:anggota,no_hp',
            'gender'         => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir'  => 'required|date',
            'password'       => 'required|confirmed|min:6',
            'photo_ktp'      => 'required|image|mimes:jpg,jpeg,png|max:10240',
        ], [
            'email.required'               => 'Email wajib diisi.',
            'email.email'                  => 'Format email tidak valid.',
            'email.unique'                 => 'Email sudah terdaftar.',
            'nik.required'                 => 'Nomor identitas wajib diisi.',
            'nik.unique'                   => 'Nomor identitas sudah terdaftar.',
            'name.required'                => 'Nama lengkap wajib diisi.',
            'no_handphone.required'        => 'Nomor handphone wajib diisi.',
            'no_handphone.unique'          => 'Nomor handphone sudah terdaftar.',
            'gender.required'              => 'Jenis kelamin wajib dipilih.',
            'tanggal_lahir.required'       => 'Tanggal lahir wajib diisi.',
            'password.required'            => 'Kata sandi wajib diisi.',
            'password.confirmed'           => 'Konfirmasi kata sandi tidak cocok.',
            'password.min'                 => 'Kata sandi minimal 6 karakter.',
            'photo_ktp.required'           => 'Foto KTP wajib diunggah.',
            'photo_ktp.image'               => 'Foto KTP harus berupa gambar.',
            'photo_ktp.mimes'                => 'Foto KTP harus berformat jpg, jpeg, atau png.',
            'photo_ktp.max'                  => 'Ukuran foto KTP maksimal 10MB.',
        ]);

        // Foto KTP hanya untuk data internal/admin, BUKAN foto profile anggota
        $fotoKtp = $request->file('photo_ktp')->store('foto_ktp', 'public');

        $defaultJenis = JenisKeanggotaan::firstOrCreate([
            'nama_jenis' => 'Mahasiswa',
        ]);

        Anggota::create([
            'id_jenis'              => $defaultJenis->id_jenis,
            'nomor_identitas'       => $request->nik,
            'jenis_nomor_identitas' => 'NIM',
            'email'                 => $request->email,
            'nama'                  => $request->name,
            'no_hp'                 => $request->no_handphone,
            'status_anggota'        => 'Aktif',
            'jenis_kelamin'         => $request->gender,
            'tanggal_lahir'         => $request->tanggal_lahir,
            'verifikasi_admin'      => 'Menunggu',
            'foto_ktp'              => $fotoKtp,   // data admin, bukan profile
            'profile'               => null,        // foto profile default kosong, diisi nanti oleh anggota
            'tanggal_diubah'        => now(),
            'password'              => Hash::make($request->password),
        ]);

        return redirect()->route('login-page')
            ->with('success', 'Akun berhasil dibuat! Silakan login untuk mengakses Profil.');
    }
}
