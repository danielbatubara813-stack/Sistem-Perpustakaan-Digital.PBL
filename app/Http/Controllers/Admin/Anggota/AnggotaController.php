<?php

namespace App\Http\Controllers\Admin\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\JenisKeanggotaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AnggotaController extends Controller
{
    public function indexAnggota(Request $request)
    {
        $query = Anggota::with('jenisKeanggotaan');

        // Search nama / nomor identitas
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%'.$request->search.'%')
                    ->orWhere('nomor_identitas', 'like', '%'.$request->search.'%');
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

        if ($request->verifikasi) {
            $query->where('verifikasi_admin', $request->verifikasi);
        }

        // Menunggu selalu di atas, lalu urut tanggal_daftar
        if ($request->sort == 'terlama') {
            $query->orderByRaw("FIELD(verifikasi_admin, 'Menunggu') DESC")
                ->orderBy('tanggal_daftar', 'asc');
        } else {
            $query->orderByRaw("FIELD(verifikasi_admin, 'Menunggu') DESC")
                ->orderBy('tanggal_daftar', 'desc');
        }

        $anggota = $query->paginate(10);

        // supaya filter tidak hilang saat pindah page
        $anggota->appends($request->all());

        $jenis = JenisKeanggotaan::all();
        $anggotaMenunggu = Anggota::where('verifikasi_admin', 'Menunggu')->count();

        return view('admin.anggota.anggota', compact('anggota', 'jenis', 'anggotaMenunggu'));
    }

    public function createAnggota()
    {
        $jenisKeanggotaan = JenisKeanggotaan::all();

        return view('admin.anggota.form-anggota', compact('jenisKeanggotaan'));
    }

    public function storeAnggota(Request $request)
    {
        $request->validate([
            'membership_type' => 'required|exists:jenis_keanggotaan,id_jenis',
            'identity_number' => 'required|unique:anggota,nomor_identitas',
            'identity_type' => 'required|in:NIM,NIDN',
            'email' => 'required|email|unique:anggota,email',
            'name' => 'required',
            'phone' => 'required|unique:anggota,no_hp',
            'gender' => 'required',
            'birth_date' => 'required|date',
            'ktp_photo' => 'required|image|mimes:jpg,jpeg,png|max:10240',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',

        ], [
            'membership_type.required' => 'Tipe keanggotaan wajib dipilih.',
            'membership_type.exists' => 'Tipe keanggotaan tidak valid.',
            'identity_number.required' => 'Nomor identitas wajib diisi.',
            'identity_number.unique' => 'Nomor identitas sudah terdaftar.',
            'identity_type.required' => 'Jenis nomor identitas wajib dipilih.',
            'identity_type.in' => 'Jenis nomor identitas harus NIM atau NIDN.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'name.required' => 'Nama lengkap wajib diisi.',
            'phone.required' => 'Nomor HP wajib diisi.',
            'phone.unique' => 'Nomor HP sudah terdaftar.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'birth_date.required' => 'Tanggal lahir wajib diisi.',
            'birth_date.date' => 'Format tanggal lahir tidak valid.',
            'ktp_photo.required' => 'Foto KTP wajib diunggah.',
            'ktp_photo.image' => 'Foto KTP harus berupa gambar.',
            'ktp_photo.mimes' => 'Foto KTP harus berformat jpg, jpeg, atau png.',
            'ktp_photo.max' => 'Ukuran foto KTP maksimal 10 MB.',
            'profile_photo.image' => 'Foto profil harus berupa gambar.',
            'profile_photo.mimes' => 'Foto profil harus berformat jpg, jpeg, atau png.',
            'profile_photo.max' => 'Ukuran foto profil maksimal 10 MB.',
        ]);

        $fotoKtp = $request->file('ktp_photo')->store('ktp', 'public');
        $fotoProfil = null;

        if ($request->hasFile('profile_photo')) {
            $fotoProfil = $request->file('profile_photo')->store('profil', 'public');
        }

        Anggota::create([
            'id_jenis' => $request->membership_type,
            'nomor_identitas' => $request->identity_number,
            'jenis_nomor_identitas' => $request->identity_type,
            'email' => $request->email,
            'nama' => $request->name,
            'no_hp' => $request->phone,
            'status_anggota' => Anggota::STATUS_TIDAK_AKTIF,
            'jenis_kelamin' => $request->gender == 'L' ? 'Laki-Laki' : 'Perempuan',
            'tanggal_lahir' => $request->birth_date,
            'tanggal_daftar' => now(),
            'verifikasi_admin' => Anggota::VERIFIKASI_MENUNGGU,
            'foto_ktp' => $fotoKtp,
            'profile' => $fotoProfil,
            'tanggal_diubah' => now(),
            'password' => Hash::make($request->identity_number),
        ]);

        return redirect()
            ->route('admin.anggota.daftar')
            ->with('success', 'Data anggota berhasil ditambahkan');
    }

    public function editAnggota($id)
    {
        $anggota = Anggota::findOrFail($id);
        $jenisKeanggotaan = JenisKeanggotaan::all();

        return view('admin.anggota.form-anggota', compact('anggota', 'jenisKeanggotaan'));
    }

    public function updateAnggota(Request $request, $id)
    {
        $anggota = Anggota::findOrFail($id);

        $request->validate([
            'membership_type' => 'required|exists:jenis_keanggotaan,id_jenis',
            // Pengecualian ID anggota yang sedang diedit agar tidak error unique
            'identity_number' => 'required|unique:anggota,nomor_identitas,'.$id.',id_anggota',
            'identity_type' => 'required|in:NIM,NIDN',
            'email' => 'required|email|unique:anggota,email,'.$id.',id_anggota',
            'name' => 'required',
            'phone' => 'required|unique:anggota,no_hp,'.$id.',id_anggota',
            'gender' => 'required',
            'birth_date' => 'required|date',
            'ktp_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
            'status_anggota' => 'nullable|in:Aktif,Tidak Aktif',
            'verifikasi_admin' => 'nullable|in:Menunggu,Terverifikasi,Ditolak',
        ], [
            'membership_type.required' => 'Tipe keanggotaan wajib dipilih.',
            'membership_type.exists' => 'Tipe keanggotaan tidak valid.',
            'identity_number.required' => 'Nomor identitas wajib diisi.',
            'identity_number.unique' => 'Nomor identitas sudah terdaftar.',
            'identity_type.required' => 'Jenis nomor identitas wajib dipilih.',
            'identity_type.in' => 'Jenis nomor identitas harus NIM atau NIDN.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'name.required' => 'Nama lengkap wajib diisi.',
            'phone.required' => 'Nomor HP wajib diisi.',
            'phone.unique' => 'Nomor HP sudah terdaftar.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'birth_date.required' => 'Tanggal lahir wajib diisi.',
            'birth_date.date' => 'Format tanggal lahir tidak valid.',
            'ktp_photo.required' => 'Foto KTP wajib diunggah.',
            'ktp_photo.image' => 'Foto KTP harus berupa gambar.',
            'ktp_photo.mimes' => 'Foto KTP harus berformat jpg, jpeg, atau png.',
            'ktp_photo.max' => 'Ukuran foto KTP maksimal 10 MB.',
            'profile_photo.image' => 'Foto profil harus berupa gambar.',
            'profile_photo.mimes' => 'Foto profil harus berformat jpg, jpeg, atau png.',
            'profile_photo.max' => 'Ukuran foto profil maksimal 10 MB.',
        ]);

        if (! $request->hasFile('ktp_photo') && ! $anggota->foto_ktp) {
            return back()
                ->withErrors(['ktp_photo' => 'Foto KTP wajib diunggah.'])
                ->withInput();
        }

        $verifikasiAdmin = $request->verifikasi_admin ?? $anggota->verifikasi_admin;

        $updateData = [
            'id_jenis' => $request->membership_type,
            'nomor_identitas' => $request->identity_number,
            'jenis_nomor_identitas' => $request->identity_type,
            'email' => $request->email,
            'nama' => $request->name,
            'no_hp' => $request->phone,
            'jenis_kelamin' => $request->gender == 'L' ? 'Laki-Laki' : 'Perempuan',
            'tanggal_lahir' => $request->birth_date,
            'tanggal_daftar' => $anggota->tanggal_daftar,
            'verifikasi_admin' => $verifikasiAdmin,
            'tanggal_diubah' => now(),
        ];

        if ($verifikasiAdmin === Anggota::VERIFIKASI_TERVERIFIKASI) {
            $updateData['status_anggota'] = Anggota::STATUS_AKTIF;
        } else {
            $updateData['status_anggota'] = Anggota::STATUS_TIDAK_AKTIF;
        }

        if ($request->hasFile('ktp_photo')) {
            $request->validate(['ktp_photo' => 'image|mimes:jpg,jpeg,png|max:10240']);
            $updateData['foto_ktp'] = $request->file('ktp_photo')->store('ktp', 'public');
        }

        if ($request->hasFile('profile_photo')) {
            $request->validate(['profile_photo' => 'image|mimes:jpg,jpeg,png|max:10240']);
            $updateData['profile'] = $request->file('profile_photo')->store('profil', 'public');
        }

        $anggota->update($updateData);

        return redirect()
            ->route('admin.anggota.daftar')
            ->with('success', 'Data anggota berhasil diperbarui');
    }

    public function destroyAnggota(Request $request)
    {
        try {
            $ids = $request->ids ?? [];

            if (empty($ids)) {
                return redirect()->back()->with('error', 'Tidak ada data yang dipilih');
            }

            Anggota::whereIn('id_anggota', $ids)->delete();

            return redirect()->back()->with('success', count($ids).' data anggota berhasil dihapus');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data anggota gagal dihapus');
        }
    }
}
