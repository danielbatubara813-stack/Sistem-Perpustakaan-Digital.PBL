<?php

namespace App\Http\Controllers\Admin\Anggota;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Anggota;
use App\Models\JenisKeanggotaan;
use Illuminate\Support\Facades\Hash;

class AnggotaController extends Controller
{

    public function indexAnggota(Request $request)
    {
        // Fungsi atau method untuk menampilkan daftar data anggota
        $query = Anggota::with('jenisKeanggotaan');

        // Search nama / nomor identitas
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                ->orWhere('nomor_identitas', 'like', '%' . $request->search . '%');
            });
        }

        // Filter jenis keanggotaan
        if ($request->id_jenis) {
            $query->where('id_jenis', $request->id_jenis);
        }

        // Filter status
        if ($request->status) {
            $query->where('status_anggota', $request->status);
        }

        // Sorting
        if ($request->sort == 'terlama') {
            $query->orderBy('tanggal_diubah', 'asc');
        } else {
            $query->orderBy('tanggal_diubah', 'desc');
        }

        $anggota = $query->paginate(10);

        // supaya filter tidak hilang saat pindah page
        $anggota->appends($request->all());

        $jenis = JenisKeanggotaan::all();

        return view(
            'admin.anggota.anggota',
            compact('anggota', 'jenis')
        );
    }

    public function createAnggota()
    {
        // Fungsi atau method untuk menampilkan form tambah data anggota
        $jenisKeanggotaan = JenisKeanggotaan::all();

        return view(
            'admin.anggota.form-anggota',
            compact('jenisKeanggotaan')
        );
    }

    public function storeAnggota(Request $request)
    {
        $request->validate([
            'membership_type'   => 'required|exists:jenis_keanggotaan,id_jenis',
            'identity_number'   => 'required|unique:anggota,nomor_identitas',
            'identity_type'     => 'required|in:NIM,NIBN,NIDN',
            'email'             => 'required|email|unique:anggota,email',
            'name'              => 'required',
            'phone'             => 'required|unique:anggota,no_hp',
            'gender'            => 'required',
            'birth_date'        => 'required|date',
            'registration_date' => 'required|date',
            'institution'       => 'required',
            'ktp_photo'         => 'required|image|mimes:jpg,jpeg,png|max:10240',
            'profile_photo'     => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
        ]);

        // Upload foto KTP
        $fotoKtp = $request->file('ktp_photo')->store('ktp', 'public');

        // Upload foto profil
        $fotoProfil = null;

        if ($request->hasFile('profile_photo')) {
            $fotoProfil = $request->file('profile_photo')->store('profil', 'public');
        }

        // Simpan data anggota
        Anggota::create([
            'id_jenis'              => $request->membership_type,
            'nomor_identitas'       => $request->identity_number,
            'jenis_nomor_identitas' => $request->identity_type,
            'email'                 => $request->email,
            'nama'                  => $request->name,
            'no_hp'                 => $request->phone,
            'status_anggota'        => 'Aktif',
            'jenis_kelamin'         => $request->gender == 'L'
                                        ? 'Laki-Laki'
                                        : 'Perempuan',
            'tanggal_lahir'         => $request->birth_date,
            'tanggal_daftar'        => $request->registration_date,
            'instansi'              => $request->institution,
            'verifikasi_admin'      => 'Menunggu',
            'foto_ktp'              => $fotoKtp,
            'profile'               => $fotoProfil,
            'tanggal_diubah'        => now(),

            // Password otomatis dari nomor identitas
            'password'              => Hash::make($request->identity_number),
        ]);

        return redirect()
            ->route('admin.anggota.daftar')
            ->with('success', 'Data anggota berhasil ditambahkan');
    }

    public function editAnggota($id)
    {
        // Fungsi atau method untuk menampilkan form edit data anggota
        $anggota = Anggota::findOrFail($id);
        $jenisKeanggotaan = JenisKeanggotaan::all();

        return view(
            'admin.anggota.form-anggota',
            compact('anggota', 'jenisKeanggotaan')
        );
    }

    public function updateAnggota(Request $request, $id)
    {
        // Fungsi atau method untuk memperbarui data anggota
        $anggota = Anggota::findOrFail($id);

        $request->validate([
            'membership_type' => 'required|exists:jenis_keanggotaan,id_jenis',
            // Pengecualian ID anggota yang sedang diedit agar tidak error unique
            'identity_number' => 'required|unique:anggota,nomor_identitas,' . $id . ',id_anggota',
            'identity_type'   => 'required|in:NIM,NIBN,NIDN',
            'email'           => 'required|email|unique:anggota,email,' . $id . ',id_anggota',
            'name'            => 'required',
            'phone'           => 'required|unique:anggota,no_hp,' . $id . ',id_anggota',
            'gender'          => 'required',
            'birth_date'      => 'required|date',
            'institution'     => 'required',
        ]);

        $updateData = [
            'id_jenis'               => $request->membership_type,
            'nomor_identitas'        => $request->identity_number,
            'jenis_nomor_identitas'  => $request->identity_type,
            'email'                  => $request->email,
            'nama'                   => $request->name,
            'no_hp'                  => $request->phone,
            'status_anggota'         => $request->status_anggota ?? $anggota->status_anggota,
            'jenis_kelamin'          => $request->gender == 'L'
                                        ? 'Laki-Laki'
                                        : 'Perempuan',
            'tanggal_lahir'          => $request->birth_date,
            'tanggal_daftar'         => $request->registration_date ?? $anggota->tanggal_daftar,
            'instansi'               => $request->institution,
            'verifikasi_admin'       => $request->verifikasi_admin ?? $anggota->verifikasi_admin,
            'tanggal_diubah'         => now(),
        ];

        // Update foto KTP jika ada file baru
        if ($request->hasFile('ktp_photo')) {
            $request->validate([
                'ktp_photo' => 'image|mimes:jpg,jpeg,png|max:10240',
            ]);
            $updateData['foto_ktp'] = $request->file('ktp_photo')->store('ktp', 'public');
        }

        // Update foto profil jika ada file baru
        if ($request->hasFile('profile_photo')) {
            $request->validate([
                'profile_photo' => 'image|mimes:jpg,jpeg,png|max:10240',
            ]);
            $updateData['profile'] = $request->file('profile_photo')->store('profil', 'public');
        }

        $anggota->update($updateData);

        return redirect()
            ->route('admin.anggota.daftar')
            ->with('success', 'Data anggota berhasil diperbarui');
    }

    public function bulkDestroyAnggota(Request $request)
    {
        // Fungsi atau method untuk menghapus banyak data anggota sekaligus
        try {
            $ids = $request->ids ?? [];

            if (empty($ids)) {
                return redirect()
                    ->back()
                    ->with('error', 'Tidak ada data yang dipilih');
            }

            Anggota::whereIn('id_anggota', $ids)->delete();

            return redirect()
                ->back()
                ->with('success', count($ids) . ' data anggota berhasil dihapus');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Data anggota gagal dihapus');
        }
    }

    public function destroyAnggota($id)
    {
        // Fungsi atau method untuk menghapus data anggota
        try {

            $anggota = Anggota::findOrFail($id);

            $anggota->delete();

            return redirect()
                ->back()
                ->with(
                    'success',
                    'Data anggota berhasil dihapus'
                );

        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Data anggota gagal dihapus'
                );
        }
    }
}
