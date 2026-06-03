<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;
use App\Models\TipeKoleksi;
use App\Models\DokBahasa;
use App\Models\Penerbit;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function listBuku()
    {
        $books = Buku::all();

        return view('admin.buku.buku', compact('books'));
    }

    public function create()
    {
        $tipe = TipeKoleksi::all();
        $bahasa = DokBahasa::all();
        $penerbit = Penerbit::all();

        return view('admin.buku.form-buku', compact('tipe', 'bahasa', 'penerbit'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_buku' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:100|unique:buku,isbn',
            'tanggal_terbit' => 'nullable|date',
            'deskripsi' => 'nullable|string',
            'edisi' => 'nullable|string|max:100',
            'no_panggil' => 'nullable|string|max:255',
            'no_rak' => 'nullable|string|max:255',
            'id_tipe' => 'nullable|exists:tipe_koleksi,id_tipe',
            'kode_bahasa' => 'nullable|exists:dok_bahasa,kode_bahasa',
            'id_penerbit' => 'nullable|exists:penerbit,id_penerbit',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
        ]);

        $data = $request->only([
            'id_tipe', 'kode_bahasa', 'id_penerbit', 'isbn', 'judul_buku',
            'tanggal_terbit', 'deskripsi', 'edisi', 'no_panggil', 'no_rak'
        ]);

        if ($request->hasFile('cover')) {
            $file = $request->file('cover');
            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9_.-]/', '_', $file->getClientOriginalName());
            $file->storeAs('covers', $filename, 'public');
            $data['cover_buku'] = $filename;
        }

        Buku::create($data);

        return redirect()->route('admin.buku')->with('success', 'Data buku berhasil disimpan');
    }

    public function edit($id)
    {
        $book = Buku::findOrFail($id);

        $tipe = TipeKoleksi::all();
        $bahasa = DokBahasa::all();
        $penerbit = Penerbit::all();

        return view('admin.buku.form-buku', compact('book', 'tipe', 'bahasa', 'penerbit'));
    }

    public function update(Request $request, $id)
    {
        $book = Buku::findOrFail($id);

        $request->validate([
            'judul_buku' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:100|unique:buku,isbn,' . $book->id_buku . ',id_buku',
            'tanggal_terbit' => 'nullable|date',
            'deskripsi' => 'nullable|string',
            'edisi' => 'nullable|string|max:100',
            'no_panggil' => 'nullable|string|max:255',
            'no_rak' => 'nullable|string|max:255',
            'id_tipe' => 'nullable|exists:tipe_koleksi,id_tipe',
            'kode_bahasa' => 'nullable|exists:dok_bahasa,kode_bahasa',
            'id_penerbit' => 'nullable|exists:penerbit,id_penerbit',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
        ]);

        $data = $request->only([
            'id_tipe', 'kode_bahasa', 'id_penerbit', 'isbn', 'judul_buku',
            'tanggal_terbit', 'deskripsi', 'edisi', 'no_panggil', 'no_rak'
        ]);

        if ($request->hasFile('cover')) {
            // delete old cover if exists
            if ($book->cover_buku) {
                Storage::disk('public')->delete('covers/' . $book->cover_buku);
            }

            $file = $request->file('cover');
            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9_.-]/', '_', $file->getClientOriginalName());
            $file->storeAs('covers', $filename, 'public');
            $data['cover_buku'] = $filename;
        }

        $book->update($data);

        return redirect()->route('admin.buku')->with('success', 'Data buku berhasil diperbarui');
    }

    public function destroy($id)
    {
        $book = Buku::findOrFail($id);

        // delete cover file if exists
        if ($book->cover_buku) {
            Storage::disk('public')->delete('covers/' . $book->cover_buku);
        }

        $book->delete();

        return redirect()->route('admin.buku')->with('success', 'Data buku berhasil dihapus');
    }

    /**
     * Destroy multiple buku selected from listing
     */
    public function destroyMultiple(Request $request)
    {
        $ids = $request->input('id_buku', []);

        if (!is_array($ids) || !count($ids)) {
            return redirect()->route('admin.buku')->with('warning', 'Pilih minimal satu data');
        }

        foreach ($ids as $id) {
            $book = Buku::find($id);
            if (!$book) continue;

            if ($book->cover_buku) {
                Storage::disk('public')->delete('covers/' . $book->cover_buku);
            }

            $book->delete();
        }

        return redirect()->route('admin.buku')->with('success', 'Data buku berhasil dihapus');
    }
}
    