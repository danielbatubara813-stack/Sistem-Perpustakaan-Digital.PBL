<?php

namespace App\Http\Controllers\Admin\DataTerkendali;

use App\Http\Controllers\Controller;
use App\Models\TipeKoleksi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TipeKoleksiController extends Controller
{
    public function indexTipeKoleksi()
    {
        // Fungsi atau method untuk menampilkan daftar data tipe koleksi
        $tipe_koleksi = TipeKoleksi::paginate(10);

        return view('admin.dataterkendali.tipe-koleksi.tipe-koleksi', compact('tipe_koleksi'));
    }

    public function createTipeKoleksi()
    {
        // Fungsi atau method untuk menampilkan form tambah data tipe koleksi
        return view('admin.dataterkendali.tipe-koleksi.form-tipe-koleksi');
    }

    public function storeTipeKoleksi(Request $request)
    {
        // Fungsi atau method untuk menyimpan data tipe koleksi baru
        try {
            // validasi
            $validateTipeKoleksi = $request->validate([
                'nama_tipe' => 'required|string|max:255',
            ]);
            $namaTipe = strtolower($request->nama_tipe);

            $cekData = TipeKoleksi::whereRaw('LOWER(nama_tipe) = ?', [$namaTipe])->first();

            // jika sudah ada
            if ($cekData) {
                return redirect()->back()->withInput()->with('error', 'Nama tipe sudah ada, silahkan gunakan nama lain');
            }

            // simpan data
            TipeKoleksi::create($validateTipeKoleksi);

            // redirect success
            return redirect()->route('admin.data-terkendali.tipe-koleksi.index')
                ->with('success', 'Data tipe koleksi berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Data tipe koleksi gagal ditambahkan');
        }
    }

    public function editTipeKoleksi($id)
    {
        // Fungsi atau method untuk menampilkan form edit data tipe koleksi
        $tipe_koleksi = TipeKoleksi::findOrFail($id);
        return view('admin.dataterkendali.tipe-koleksi.form-tipe-koleksi', compact('tipe_koleksi'));
    }

    public function updateTipeKoleksi(Request $request)
    {
        // Fungsi atau method untuk memperbarui data tipe koleksi
        try {
            $validateTipeKoleksi = $request->validate([
                'id_tipe' => 'required|integer',
                'nama_tipe' => 'required|string',
            ]);

            $namaTipe = strtolower($request->nama_tipe);

            $cekData = TipeKoleksi::whereRaw('LOWER(nama_tipe) = ?', [$namaTipe])->where('id_tipe', '!=', $validateTipeKoleksi['id_tipe'])->first();

            // jika sudah ada
            if ($cekData) {
                return redirect()->back()->withInput()->with('error', 'Nama tipe sudah ada, silahkan gunakan nama lain');
            }

            $tipe_koleksi = TipeKoleksi::findOrFail($validateTipeKoleksi['id_tipe']);
            $tipe_koleksi->nama_tipe = $validateTipeKoleksi['nama_tipe'];
            $tipe_koleksi->save();

            return redirect()->route('admin.data-terkendali.tipe-koleksi.index')->with('success', 'Data tipe koleksi berhasil diperbaharui');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Data tipe koleksi gagal diperbaharui');
        }
    }

    public function destroyTipeKoleksi(Request $request)
    {
        // Fungsi atau method untuk menghapus data tipe koleksi
        try {
            if (!$request->id_tipe) {
                return redirect()->back()->with('error', 'Pilih minimal satu data');

            }

            TipeKoleksi::whereIn(
                'id_tipe',
                $request->id_tipe
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
