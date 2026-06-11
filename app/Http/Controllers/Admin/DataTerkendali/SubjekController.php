<?php

namespace App\Http\Controllers\Admin\DataTerkendali;

use App\Http\Controllers\Controller;
use App\Models\Subjek;
use Illuminate\Http\Request;

class SubjekController extends Controller
{
    public function indexSubjek(Request $request)
    {
        // Fungsi atau method untuk menampilkan daftar data subjek
        $query = Subjek::query();
        // Search
        if ($request->filled('search')) {
            $query->where('nama_subjek', 'like', '%' . $request->search . '%');
        }

        // Sort
        if ($request->sort == 'terlama') {
            $query->orderBy('tanggal_dibuat', 'asc');
        } else {
            $query->orderBy('tanggal_dibuat', 'desc');
        }

        $subjek = $query
            ->paginate(10)
            ->withQueryString();

        return view('admin.dataterkendali.subjek.subjek', compact('subjek'));
    }

    public function createSubjek()
    {
        // Fungsi atau method untuk menampilkan form tambah data subjek
        return view('admin.dataterkendali.subjek.form-subjek');
    }

    public function storeSubjek(Request $request)
    {
        // Fungsi atau method untuk menyimpan data subjek baru
        try {

            $validateSubjek = $request->validate([
                'nama_subjek' => 'required|string',
            ]);

            $namaSubjek = strtolower($request->nama_subjek);

            $cekData = Subjek::whereRaw('LOWER(nama_subjek) = ?', [$namaSubjek])->first();

            // jika sudah ada
            if ($cekData) {
                return redirect()->back()->withInput()->with('error', 'Nama subjek sudah ada, silahkan gunakan nama lain');
            }

            Subjek::create($validateSubjek);


            return redirect()
                ->route('admin.data-terkendali.subjek.index')
                ->with('success', 'Data subjek berhasil ditambahkan');

        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Data subjek gagal ditambahkan');

        }
    }

    public function editSubjek($id)
    {
        // Fungsi atau method untuk menampilkan form edit data subjek
        $subjek = Subjek::findOrFail($id);
        return view('admin.dataterkendali.subjek.form-subjek', compact('subjek'));
    }

    public function updateSubjek(Request $request)
    {
        // Fungsi atau method untuk memperbarui data subjek
        try {
            $validateSubjek = $request->validate([
                'id_subjek' => 'required|integer',
                'nama_subjek' => 'required|string',
            ]);

            $namaSubjek = strtolower($request->nama_subjek);

            $cekData = subjek::whereRaw('LOWER(nama_subjek) = ?', [$namaSubjek])->where('id_subjek', '!=', $validateSubjek['id_subjek'])->first();

            // jika sudah ada
            if ($cekData) {
                return redirect()->back()->withInput()->with('error', 'Nama subjek sudah ada, silahkan gunakan nama lain');
            }

            $subjek = Subjek::findOrFail($validateSubjek['id_subjek']);
            $subjek->nama_subjek = $validateSubjek['nama_subjek'];
            $subjek->save();

            return redirect()->route('admin.data-terkendali.subjek.index')->with('success', 'Data subjek berhasil diperbaharui');
        } catch (\Exception $e) {
            //throw $th;
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Data subjek gagal diperbaharui');
        }
    }

    public function destroySubjek(Request $request)
    {
        // Fungsi atau method untuk menghapus data subjek
        try {
            if (!$request->id_subjek) {
                return redirect()
                    ->back()
                    ->with('error', 'Pilih minimal satu data');

            }

            Subjek::whereIn(
                'id_subjek',
                $request->id_subjek
            )->delete();

            return redirect()
                ->back()
                ->with('success', 'Data berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Data gagal dihapus');
        }
    }
}
