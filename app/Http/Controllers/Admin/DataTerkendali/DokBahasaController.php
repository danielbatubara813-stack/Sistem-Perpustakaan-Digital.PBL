<?php

namespace App\Http\Controllers\Admin\DataTerkendali;

use App\Http\Controllers\Controller;
use App\Models\DokBahasa;
use Illuminate\Http\Request;

class DokBahasaController extends Controller
{
    public function indexBahasa(Request $request)
    {
        // Fungsi atau method untuk menampilkan daftar data Bahasa
        $query = DokBahasa::query();
        // Search
        if ($request->filled('search')) {
            $query->where('nama_bahasa', 'like', '%' . $request->search . '%')->orWhere('kode_bahasa', 'like', '%' . $request->search . '%');
        }
        // Sort
        if ($request->sort == 'terlama') {
            $query->orderBy('tanggal_dibuat', 'asc');
        } else {
            $query->orderBy('tanggal_dibuat', 'desc');
        }

        $bahasa = $query
            ->paginate(10)
            ->withQueryString();

        return view('admin.dataterkendali.dokumen-bahasa.dokumen-bahasa', compact('bahasa'));
    }

    public function createBahasa()
    {
        // Fungsi atau method untuk menampilkan form tambah data Bahasa
        return view('admin.dataterkendali.dokumen-bahasa.form-dok-bahasa');
    }

    public function storeBahasa(Request $request)
    {
        // Fungsi atau method untuk menyimpan data Bahasa baru
        try {
            if (strlen($request->kode_bahasa) > 2) {
                return redirect()->back()->withInput()->with('error', 'Kode bahasa maksimal hanya 2 karakter.');
            }

            $kodeBahasa = strtoupper($request->kode_bahasa);
            $namaBahasa = strtolower($request->nama_bahasa);

            $cekKodeBahasa = DokBahasa::whereRaw('LOWER(kode_bahasa) = ?', [strtolower($kodeBahasa)])->first();

            if ($cekKodeBahasa) {
                return redirect()->back()->withInput()
                    ->with('error', 'Kode bahasa sudah ada, silahkan gunakan kode lain');
            }

            $cekNamaBahasa = DokBahasa::whereRaw('LOWER(nama_bahasa) = ?', [strtolower($namaBahasa)])->first();

            if ($cekNamaBahasa) {
                return redirect()->back()->withInput()
                    ->with('error', 'Nama bahasa sudah ada, silahkan gunakan nama lain');

            }

            $validateBahasa = $request->validate([
                'kode_bahasa' => 'required|string|max:2',
                'nama_bahasa' => 'required|string|max:255',
            ]);

            DokBahasa::create([
                'kode_bahasa' => strtoupper($validateBahasa['kode_bahasa']),
                'nama_bahasa' => $validateBahasa['nama_bahasa'],
            ]);

            return redirect()->route('admin.data-terkendali.dok-bahasa.index')
                ->with('success', 'Data bahasa berhasil ditambahkan');

        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Data Bahasa gagal ditambahkan');

        }
    }

    public function editBahasa($id)
    {
        // Fungsi atau method untuk menampilkan form edit data Bahasa
        $bahasa = DokBahasa::findOrFail($id);
        return view('admin.dataterkendali.dokumen-bahasa.form-dok-bahasa', compact('bahasa'));
    }

    public function updateBahasa(Request $request)
    {
        // Fungsi atau method untuk memperbarui data Bahasa
        try {
            if (strlen($request->kode_bahasa) > 2) {
                return redirect()->back()->withInput()->with('error', 'Kode bahasa maksimal hanya 2 karakter.');
            }

            $kodeBahasa = strtoupper($request->kode_bahasa);
            $namaBahasa = strtolower($request->nama_bahasa);

            $cekKodeBahasa = DokBahasa::whereRaw('LOWER(kode_bahasa) = ?', [strtolower($kodeBahasa)])
                ->where('kode_bahasa', '!=', $kodeBahasa)->first();

            if ($cekKodeBahasa) {
                return redirect()->back()->withInput()
                    ->with('error', 'Kode bahasa sudah ada, silahkan gunakan kode lain');
            }

            $cekNamaBahasa = DokBahasa::whereRaw('LOWER(nama_bahasa) = ?', [strtolower($namaBahasa)])
                ->where('kode_bahasa', '!=', $kodeBahasa)->first();

            if ($cekNamaBahasa) {
                return redirect()->back()->withInput()
                    ->with('error', 'Nama bahasa sudah ada, silahkan gunakan nama lain');
            }


            $validateBahasa = $request->validate([
                'kode_bahasa' => 'required|string|max:2',
                'nama_bahasa' => 'required|string|max:255',
            ]);

            $bahasa = DokBahasa::findOrFail($kodeBahasa);

            $bahasa->kode_bahasa = strtoupper($validateBahasa['kode_bahasa']);
            $bahasa->nama_bahasa = $validateBahasa['nama_bahasa'];

            $bahasa->save();

            return redirect()
                ->route(
                    'admin.data-terkendali.dok-bahasa.index'
                )
                ->with(
                    'success',
                    'Data bahasa berhasil diperbaharui'
                );
        } catch (\Exception $e) {
            //throw $th;
            return redirect()->back()->withInput()->with('error', 'Data Bahasa gagal diperbaharui');
        }
    }

    public function destroyBahasa(Request $request)
    {
        // Fungsi atau method untuk menghapus data Bahasa
        try {
            if (!$request->kode_bahasa) {
                return redirect()->back()->with('error', 'Pilih minimal satu data');
            }

            DokBahasa::whereIn('kode_bahasa', $request->kode_bahasa)->delete();

            return redirect()->back()->with('success', 'Data berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('error', 'Data gagal dihapus');
        }
    }
}
