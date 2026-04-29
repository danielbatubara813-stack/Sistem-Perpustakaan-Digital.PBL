<?php

namespace App\Http\Controllers\Admin\Anggota;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function ambilData()
    {
        $members = $members ?? [
            [
                'identity' => '3312501025',
                'name' => 'Daniel Anju Adinov Batubara',
                'type' => 'Mahasiswa',
                'status' => 'Menunggu',
                'updated' => '08-04-2026 10:02:22',
            ],
            [
                'identity' => '12345',
                'name' => 'Cynthia Lasmini',
                'type' => 'Dosen Tetap',
                'status' => 'Aktif',
                'updated' => '08-04-2026 10:02:22',
            ],
            [
                'identity' => '67890',
                'name' => 'Rudi Hartono',
                'type' => 'Dosen Magang',
                'status' => 'Aktif',
                'updated' => '08-04-2026 10:02:22',
            ],
            [
                'identity' => '3312501026',
                'name' => 'Andi Saputra',
                'type' => 'Mahasiswa',
                'status' => 'Aktif',
                'updated' => '09-04-2026 09:15:10',
            ],
            [
                'identity' => '3312501027',
                'name' => 'Siti Rahma',
                'type' => 'Mahasiswa',
                'status' => 'Ditolak',
                'updated' => '09-04-2026 11:22:45',
            ],
            [
                'identity' => '54321',
                'name' => 'Budi Santoso',
                'type' => 'Dosen Tetap',
                'status' => 'Nonaktif',
                'updated' => '10-04-2026 08:45:00',
            ],
            [
                'identity' => '98765',
                'name' => 'Lina Marlina',
                'type' => 'Dosen Magang',
                'status' => 'Menunggu',
                'updated' => '10-04-2026 14:12:33',
            ],
            [
                'identity' => '3312501028',
                'name' => 'Fajar Nugroho',
                'type' => 'Mahasiswa',
                'status' => 'Aktif',
                'updated' => '11-04-2026 16:30:21',
            ],
            [
                'identity' => '3312501029',
                'name' => 'Dewi Lestari',
                'type' => 'Mahasiswa',
                'status' => 'Nonaktif',
                'updated' => '12-04-2026 13:05:55',
            ],
            [
                'identity' => '11223',
                'name' => 'Agus Salim',
                'type' => 'Dosen Tetap',
                'status' => 'Aktif',
                'updated' => '13-04-2026 07:50:12',
            ],
        ];

        return $members;
    }
    public function listAnggota()
    {
        $members = $this->ambilData();
        return view('admin.anggota.anggota', compact('members'));
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
