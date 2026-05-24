<?php

namespace App\Http\Controllers\Admin\DataTerkendali;

use App\Http\Controllers\Controller;
use App\Models\Penerbit;
use Illuminate\Http\Request;

class PenerbitController extends Controller
{
    public function indexPenerbit()
    {
        // Fungsi atau method untuk menampilkan daftar data penerbit
        $penerbit = Penerbit::paginate(10);

        return view('admin.dataterkendali.penerbit.penerbit', compact('penerbit'));
    }

    public function createPenerbit()
    {
        // Fungsi atau method untuk menampilkan form tambah data penerbit
        return view('admin.dataterkendali.penerbit.form-penerbit');
    }

    public function storePenerbit(Request $request)
    {
        // Fungsi atau method untuk menyimpan data penerbit baru
        try {

            $validatePenerbit = $request->validate([
                'nama_penerbit' => 'required|string',
            ]);

            $namaPenerbit = strtolower($request->nama_penerbit);

            $cekData = Penerbit::whereRaw('LOWER(nama_penerbit) = ?', [$namaPenerbit])->first();

            // jika sudah ada
            if ($cekData) {
                return redirect()->back()->withInput()->with('error', 'Nama penerbit sudah ada, silahkan gunakan nama lain');
            }

            Penerbit::create($validatePenerbit);

            return redirect()
                ->route('admin.data-terkendali.penerbit.index')
                ->with('success', 'Data penerbit berhasil ditambahkan');

        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Data penerbit gagal ditambahkan');

        }
    }

    public function editPenerbit($id)
    {
        // Fungsi atau method untuk menampilkan form edit data penerbit
        $penerbit = Penerbit::findOrFail($id);
        return view('admin.dataterkendali.penerbit.form-penerbit', compact('penerbit'));
    }

    public function updatePenerbit(Request $request)
    {
        // Fungsi atau method untuk memperbarui data penerbit
        try {
            $validatePenerbit = $request->validate([
                'id_penerbit' => 'required|integer',
                'nama_penerbit' => 'required|string',
            ]);

            $namaPenerbit = strtolower($request->nama_penerbit);

            $cekData = Penerbit::whereRaw('LOWER(nama_penerbit) = ?', [$namaPenerbit])->where('id_penerbit', '!=', $validatePenerbit['id_penerbit'])->first();

            // jika sudah ada
            if ($cekData) {
                return redirect()->back()->withInput()->with('error', 'Nama penerbit sudah ada, silahkan gunakan nama lain');
            }

            $penerbit = Penerbit::findOrFail($validatePenerbit['id_penerbit']);
            $penerbit->nama_penerbit = $validatePenerbit['nama_penerbit'];
            $penerbit->save();

            return redirect()->route('admin.data-terkendali.penerbit.index')->with('success', 'Data penerbit berhasil diperbaharui');
        } catch (\Exception $e) {
            //throw $th;
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Data penerbit gagal diperbaharui');
        }
    }

    public function destroyPenerbit(Request $request)
    {
        // Fungsi atau method untuk menghapus data penerbit
        try {
            if (!$request->id_penerbit) {
                return redirect()
                    ->back()
                    ->with('error', 'Pilih minimal satu data');

            }

            Penerbit::whereIn(
                'id_penerbit',
                $request->id_penerbit
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
