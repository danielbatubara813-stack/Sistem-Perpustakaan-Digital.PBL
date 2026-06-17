<?php

namespace App\Http\Controllers\Admin\DataTerkendali;

use App\Http\Controllers\Controller;
use App\Models\Penulis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PenulisController extends Controller
{
    public function indexPenulis(Request $request)
    {
        // Fungsi atau method untuk menampilkan daftar data penulis
        $query = Penulis::query();

        // Search
        if ($request->filled('search')) {
            $query->where('nama_penulis', 'like', '%' . $request->search . '%');
        }

        // Filter tipe penulis
        if ($request->filled('tipe_penulis')) {
            $query->where('tipe_penulis', $request->tipe_penulis);
        }

        // Sort
        if ($request->sort == 'terlama') {
            $query->orderBy('tanggal_dibuat', 'asc');
        } else {
            $query->orderBy('tanggal_dibuat', 'desc');
        }

        $penulis = $query
            ->paginate(10)
            ->withQueryString();

        return view('admin.dataterkendali.penulis.penulis', compact('penulis'));
    }

    public function createPenulis()
    {
        // Fungsi atau method untuk menampilkan form tambah data penulis
        return view('admin.dataterkendali.penulis.form-penulis');
    }

    public function storePenulis(Request $request)
    {
        // Fungsi atau method untuk menyimpan data penulis baru
        try {
            $rules = [
                'nama_penulis' => 'required|string',
                'tipe_penulis' => 'required|in:Nama Orang,Badan Organisasi,Konferensi',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'errors' => $validator->errors()
                    ], 422);
                }

                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $namaPenulis = strtolower($request->nama_penulis);

            $cekData = Penulis::whereRaw(
                'LOWER(nama_penulis) = ?',
                [$namaPenulis]
            )->first();

            // Jika sudah ada
            if ($cekData) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'error' => 'Nama penulis sudah ada, silahkan gunakan nama lain'
                    ], 409);
                }

                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Nama penulis sudah ada, silahkan gunakan nama lain');
            }

            $penulis = Penulis::create([
                'nama_penulis' => $request->nama_penulis,
                'tipe_penulis' => $request->tipe_penulis,
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'penulis' => $penulis
                ], 201);
            }

            return redirect()
                ->route('admin.data-terkendali.penulis.index')
                ->with('success', 'Data penulis berhasil ditambahkan');

        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'error' => 'Data penulis gagal ditambahkan'
                ], 500);
            }

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Data penulis gagal ditambahkan');
        }
    }

    public function editPenulis($id)
    {
        // Fungsi atau method untuk menampilkan form edit data penulis
        $penulis = Penulis::findOrFail($id);

        return view(
            'admin.dataterkendali.penulis.form-penulis',
            compact('penulis')
        );
    }

    public function updatePenulis(Request $request)
    {
        // Fungsi atau method untuk memperbarui data penulis
        try {
            $validatePenulis = $request->validate([
                'id_penulis' => 'required|integer',
                'nama_penulis' => 'required|string',
                'tipe_penulis' => 'required|in:Nama Orang,Badan Organisasi,Konferensi',
            ]);

            $namaPenulis = strtolower($request->nama_penulis);

            $cekData = Penulis::whereRaw(
                'LOWER(nama_penulis) = ?',
                [$namaPenulis]
            )
                ->where('id_penulis', '!=', $validatePenulis['id_penulis'])
                ->first();

            // Jika sudah ada
            if ($cekData) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Nama penulis sudah ada, silahkan gunakan nama lain');
            }

            $penulis = Penulis::findOrFail($validatePenulis['id_penulis']);
            $penulis->nama_penulis = $validatePenulis['nama_penulis'];
            $penulis->tipe_penulis = $validatePenulis['tipe_penulis'];
            $penulis->save();

            return redirect()
                ->route('admin.data-terkendali.penulis.index')
                ->with('success', 'Data penulis berhasil diperbaharui');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Data penulis gagal diperbaharui');
        }
    }

    public function destroyPenulis(Request $request)
    {
        // Fungsi atau method untuk menghapus data penulis
        try {
            if (!$request->id_penulis) {
                return redirect()
                    ->back()
                    ->with('error', 'Pilih minimal satu data');
            }

            Penulis::whereIn(
                'id_penulis',
                $request->id_penulis
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
