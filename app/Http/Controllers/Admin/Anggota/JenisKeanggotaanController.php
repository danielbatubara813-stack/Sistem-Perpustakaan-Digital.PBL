<?php

namespace App\Http\Controllers\Admin\Anggota;

use App\Http\Controllers\Controller;
use App\Models\JenisKeanggotaan;
use Illuminate\Http\Request;

class JenisKeanggotaanController extends Controller
{
    public function jenis(Request $request)
    {
        $query = JenisKeanggotaan::query();

        // Search by nama_jenis
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('nama_jenis', 'like', '%' . $search . '%');
        }

        // Sort
        $sort = $request->input('sort', 'terbaru');
        if ($sort === 'terlama') {
            $query->orderBy('tanggal_dibuat', 'asc');
        } else {
            $query->orderBy('tanggal_dibuat', 'desc');
        }

        $types = $query->get();

        return view('admin.anggota.anggota-jenis', compact('types'));
    }

    public function jenisCreate()
    {
        return view('admin.anggota.form-anggota-jenis');
    }

    public function jenisStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:jenis_keanggotaan,nama_jenis',
        ]);

        JenisKeanggotaan::create([
            'nama_jenis' => $request->name,
        ]);

        return redirect()
            ->route('admin.anggota.jenis')
            ->with('success', 'Jenis keanggotaan berhasil ditambahkan');
    }

    public function jenisEdit($id)
    {
        $type = JenisKeanggotaan::findOrFail($id);

        return view('admin.anggota.form-anggota-jenis', compact('type'));
    }

    public function jenisUpdate(Request $request, $id)
    {
        $type = JenisKeanggotaan::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:jenis_keanggotaan,nama_jenis,' . $id . ',id_jenis',
        ]);

        $type->update([
            'nama_jenis' => $request->name,
        ]);

        return redirect()
            ->route('admin.anggota.jenis')
            ->with('success', 'Jenis keanggotaan berhasil diperbarui');
    }

    public function jenisDestroy($id)
    {
        try {
            $type = JenisKeanggotaan::findOrFail($id);

            // Cek apakah masih ada anggota dengan jenis ini
            if ($type->anggota()->count() > 0) {
                return redirect()
                    ->back()
                    ->with('error', 'Jenis keanggotaan tidak dapat dihapus karena masih digunakan oleh anggota');
            }

            $type->delete();

            return redirect()
                ->back()
                ->with('success', 'Jenis keanggotaan berhasil dihapus');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Jenis keanggotaan gagal dihapus');
        }
    }

    public function bulkDestroyJenis(Request $request)
    {
        try {
            $ids = $request->ids ?? [];

            if (empty($ids)) {
                return redirect()
                    ->back()
                    ->with('error', 'Tidak ada data yang dipilih');
            }

            // Cek apakah ada jenis yang masih digunakan
            $types = JenisKeanggotaan::whereIn('id_jenis', $ids)->get();
            $inUse = $types->filter(function ($type) {
                return $type->anggota()->count() > 0;
            });

            if ($inUse->count() > 0) {
                return redirect()
                    ->back()
                    ->with('error', $inUse->count() . ' jenis keanggotaan tidak dapat dihapus karena masih digunakan oleh anggota');
            }

            JenisKeanggotaan::whereIn('id_jenis', $ids)->delete();

            return redirect()
                ->back()
                ->with('success', count($ids) . ' jenis keanggotaan berhasil dihapus');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Jenis keanggotaan gagal dihapus');
        }
    }
}
