<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function listAnggota()
    {
        return view('admin.anggota');
    }

    public function create()
    {
        return view('admin.anggota-create');
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

        return redirect()->route('admin.anggota')->with('success', 'Anggota berhasil ditambahkan (placeholder).');
    }

    public function edit($id)
    {
        return view('admin.anggota-edit', ['id' => $id]);
    }

    public function jenis()
    {
        $types = [
            ['id' => 1, 'name' => 'Mahasiswa', 'created' => '08-04-2026 10:02:22', 'updated' => '08-04-2026 10:02:22'],
            ['id' => 2, 'name' => 'Dosen Tetap', 'created' => '08-04-2026 10:02:22', 'updated' => '08-04-2026 10:02:22'],
        ];

        return view('admin.anggota-jenis', ['types' => $types]);
    }

    public function jenisCreate()
    {
        return view('admin.anggota-jenis-create');
    }

    public function jenisStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Placeholder: not persisted to database yet.

        return redirect()->route('admin.anggota.jenis')->with('success', 'Jenis keanggotaan berhasil ditambahkan (placeholder).');
    }
}
