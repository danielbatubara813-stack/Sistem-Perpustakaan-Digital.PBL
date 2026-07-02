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
        $jenisKeanggotaan = JenisKeanggotaan::all();
        return view('register', compact('jenisKeanggotaan'));
    }

    public function prosesRegister(Request $request)
    {
        $request->validate([
            'email'           => 'required|email|unique:anggota,email',
            'identity_number' => 'required|unique:anggota,nomor_identitas',
            'identity_type'   => 'required|in:NIM,NIDN',
            'name'            => 'required',
            'membership_type' => 'required|exists:jenis_keanggotaan,id_jenis',
            'phone'           => 'required|unique:anggota,no_hp',
            'gender'          => 'required|in:L,P',
            'birth_date'      => 'required|date',
            'password'        => 'required|confirmed|min:6',
            'ktp_photo'       => 'required|image|mimes:jpg,jpeg,png|max:10240',
            'profile_photo'   => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
        ], [
            'email.required'            => 'Email wajib diisi.',
            'email.email'               => 'Format email tidak valid.',
            'email.unique'              => 'Email sudah terdaftar.',
            'identity_number.required'  => 'Nomor identitas wajib diisi.',
            'identity_number.unique'    => 'Nomor identitas sudah terdaftar.',
            'identity_type.required'    => 'Jenis nomor identitas wajib dipilih.',
            'name.required'             => 'Nama lengkap wajib diisi.',
            'membership_type.required'  => 'Tipe keanggotaan wajib dipilih.',
            'membership_type.exists'    => 'Tipe keanggotaan tidak valid.',
            'phone.required'            => 'Nomor telepon wajib diisi.',
            'phone.unique'              => 'Nomor telepon sudah terdaftar.',
            'gender.required'           => 'Jenis kelamin wajib dipilih.',
            'birth_date.required'       => 'Tanggal lahir wajib diisi.',
            'password.required'         => 'Kata sandi wajib diisi.',
            'password.confirmed'        => 'Konfirmasi kata sandi tidak cocok.',
            'password.min'              => 'Kata sandi minimal 6 karakter.',
            'ktp_photo.required'        => 'Foto KTP wajib diunggah.',
            'ktp_photo.image'           => 'Foto KTP harus berupa gambar.',
            'ktp_photo.mimes'           => 'Foto KTP harus berformat jpg, jpeg, atau png.',
            'ktp_photo.max'             => 'Ukuran foto KTP maksimal 10MB.',
        ]);

        $fotoKtp = $request->file('ktp_photo')->store('ktp', 'public');

        $fotoProfil = null;
        if ($request->hasFile('profile_photo')) {
            $fotoProfil = $request->file('profile_photo')->store('profil', 'public');
        }

        Anggota::create([
            'id_jenis'              => $request->membership_type,
            'nomor_identitas'       => $request->identity_number,
            'jenis_nomor_identitas' => $request->identity_type,
            'email'                 => $request->email,
            'nama'                  => $request->name,
            'no_hp'                 => $request->phone,
            'status_anggota'        => 'tidak aktif',
            'jenis_kelamin'         => $request->gender == 'L' ? 'Laki-Laki' : 'Perempuan',
            'tanggal_lahir'         => $request->birth_date,
            'verifikasi_admin'      => 'Menunggu',
            'foto_ktp'              => $fotoKtp,
            'profile'               => $fotoProfil,
            'tanggal_diubah'        => now(),
            'password'              => Hash::make($request->password),
        ]);

        return redirect()->route('login-page')
            ->with('success', 'Akun berhasil dibuat! Silakan login untuk mengakses Profil.');
    }
}
