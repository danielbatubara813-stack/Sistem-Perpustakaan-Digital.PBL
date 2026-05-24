<?php

namespace App\Http\Controllers\Admin\DataTerkendali;

use App\Http\Controllers\Controller;
use App\Models\Penulis;
use Illuminate\Http\Request;

class PenulisController extends Controller
{
    public function indexPenulis()
    {
        // Fungsi atau method untuk menampilkan daftar data penulis
        $penulis = Penulis::paginate(10);

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

            $validatePenulis = $request->validate([
                'nama_penulis' => 'required|string',
                'tipe_penulis' => 'required|in:Nama Orang,Badan Organisasi,Konferensi',
            ]);

            $namaPenulis = strtolower($request->nama_penulis);

            $cekData = Penulis::whereRaw('LOWER(nama_penulis) = ?', [$namaPenulis])->first();

            // jika sudah ada
            if ($cekData) {
                return redirect()->back()->withInput()->with('error', 'Nama penulis sudah ada, silahkan gunakan nama lain');
            }

            Penulis::create($validatePenulis);

            return redirect()
                ->route('admin.data-terkendali.penulis.index')
                ->with('success', 'Data penulis berhasil ditambahkan');

        } catch (\Exception $e) {

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
        return view('admin.dataterkendali.penulis.form-penulis', compact('penulis'));
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

            $cekData = Penulis::whereRaw('LOWER(nama_penulis) = ?', [$namaPenulis])->where('id_penulis', '!=', $validatePenulis['id_penulis'])->first();

            // jika sudah ada
            if ($cekData) {
                return redirect()->back()->withInput()->with('error', 'Nama penulis sudah ada, silahkan gunakan nama lain');
            }

            $penulis = Penulis::findOrFail($validatePenulis['id_penulis']);
            $penulis->nama_penulis = $validatePenulis['nama_penulis'];
            $penulis->tipe_penulis = $validatePenulis['tipe_penulis'];
            $penulis->save();

            return redirect()->route('admin.data-terkendali.penulis.index')->with('success', 'Data penulis berhasil diperbaharui');
        } catch (\Exception $e) {
            //throw $th;
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
