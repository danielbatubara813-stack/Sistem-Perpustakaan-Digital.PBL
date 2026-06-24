<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileAnggotaController extends Controller
{
    private function getProfileData()
    {
        $user = Anggota::find(Auth::guard('web')->id());

        $totalPeminjaman = Peminjaman::where('id_anggota', $user->id_anggota)->count();

        $totalJudul = Peminjaman::where('id_anggota', $user->id_anggota)
            ->distinct('id_item')
            ->count('id_item');

        return compact('user', 'totalPeminjaman', 'totalJudul');
    }

    public function akunSayaPage()
    {
        return view('profile.akun-saya', $this->getProfileData());
    }

    public function updateProfile(Request $request)
    {
        $user = Anggota::find(Auth::guard('web')->id());

        $request->validate([
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
        ]);

        if ($request->hasFile('profile_image')) {
            if ($user->profile && Storage::disk('public')->exists($user->profile)) {
                Storage::disk('public')->delete($user->profile);
            }

            $path = $request->file('profile_image')->store('profile', 'public');
            $user->profile = $path;
            $user->save();
        }

        return back()->with('success', 'Foto profil berhasil diperbarui.');
    }

    public function changePassword(Request $request)
    {
        $user = Anggota::find(Auth::guard('web')->id());

        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:6|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Kata sandi saat ini salah.'
            ]);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        $request->session()->regenerate();

        return back()->with('success', 'Kata sandi berhasil diubah.');
    }
}
