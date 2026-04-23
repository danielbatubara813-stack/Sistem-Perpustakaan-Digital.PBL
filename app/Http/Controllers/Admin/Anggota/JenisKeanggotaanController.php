<?php

namespace App\Http\Controllers\Admin\Anggota;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JenisKeanggotaanController extends Controller
{
    public function jenis()
    {
        $types = [
            ['id' => 1, 'name' => 'Mahasiswa', 'created' => '08-04-2026 10:02:22', 'updated' => '08-04-2026 10:02:22'],
            ['id' => 2, 'name' => 'Dosen Tetap', 'created' => '08-04-2026 10:02:22', 'updated' => '08-04-2026 10:02:22'],
        ];

        return view('admin.anggota.anggota-jenis', ['types' => $types]);
    }

    public function jenisCreate()
    {
        return view('admin.anggota.form-anggota-jenis');
    }

    public function jenisStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Placeholder: not persisted to database yet.

        return redirect()->route('admin.anggota.anggota-jenis')->with('success', 'Jenis keanggotaan berhasil ditambahkan (placeholder).');
    }
}
