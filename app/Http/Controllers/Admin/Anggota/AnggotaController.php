<?php

namespace App\Http\Controllers\Admin\Anggota;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function listAnggota()
    {
        return view('admin.anggota.anggota');
    }

    public function create()
    {
        return view('admin.anggota.form-anggota');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'nullable|email|max:255',
            'identity_number' => 'required|string|max:100',
            'identity_type' => 'required|in:NIM,NIDN',
            'name' => 'required|string|max:255',
            'institution' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'registration_date' => 'nullable|date',
            'membership_type' => 'nullable|string|max:100',
            'gender' => 'nullable|in:L,P',
            'phone' => 'nullable|string|max:20',
            'ktp_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
        ]);

        if ($request->hasFile('ktp_photo')) {
            $validated['ktp_photo'] = $request->file('ktp_photo')->store('anggota/ktp', 'public');
        }

        if ($request->hasFile('profile_photo')) {
            $validated['profile_photo'] = $request->file('profile_photo')->store('anggota/profile', 'public');
        }

        // Placeholder: currently not persisting to database.
        // In future, create a model and save the validated data.

        return redirect()->route('admin.anggota.anggota')->with('success', 'Anggota berhasil ditambahkan (placeholder).');
    }

    public function edit($id)
    {
        return view('admin.buku.form-buku', ['mode' => 'edit']);
    }
}
