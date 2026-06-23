<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;
use App\Models\TipeKoleksi;
use App\Models\DokBahasa;
use App\Models\Penerbit;
use App\Models\Subjek;
use App\Models\ItemBuku;
use App\Models\Penulis;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use Throwable;

class BukuController extends Controller
{
    public function listBuku(Request $request)
    {
        $query = Buku::with(['bahasa', 'subjek'])
            ->withCount('items');

        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($query) use ($search) {
                $query
                    ->where('judul_buku', 'like', '%' . $search . '%')
                    ->orWhere('isbn', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('bahasa')) {
            $query->where('kode_bahasa', $request->input('bahasa'));
        }

        if ($request->filled('subjek')) {
            $query->whereHas('subjek', function ($query) use ($request) {
                $query->where('subjek.id_subjek', $request->input('subjek'));
            });
        }

        if ($request->input('sort') === 'terlama') {
            $query->orderBy('tanggal_dibuat', 'asc');
        } else {
            $query->orderBy('tanggal_dibuat', 'desc');
        }

        $books = $query
            ->paginate(10)
            ->withQueryString();

        $bahasaOptions = DokBahasa::orderBy('nama_bahasa')->get();
        $subjekOptions = Subjek::orderBy('nama_subjek')->get();

        return view('admin.buku.buku', compact('books', 'bahasaOptions', 'subjekOptions'));
    }

    public function create()
    {
        $tipe = TipeKoleksi::all();
        $bahasa = DokBahasa::all();
        $penerbit = Penerbit::all();
        $subjek = Subjek::all();
        $penulis = Penulis::all();
        $tipe_penulis = Penulis::select('tipe_penulis')->distinct()->pluck('tipe_penulis');

        // sediakan instance Buku kosong agar form dapat merujuk ke $book dengan aman saat membuat
        $book = new Buku();
        $kode1Item = null;
        $kode2Item = null;

        return view('admin.buku.form-buku', compact('book', 'tipe', 'bahasa', 'penerbit', 'subjek', 'penulis', 'tipe_penulis', 'kode1Item', 'kode2Item'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_buku' => 'required|string|max:255',
            'isbn' => 'required|string|max:13|unique:buku,isbn',
            'tanggal_terbit' => 'required|date',
            'deskripsi' => 'required|string',
            'edisi' => 'required|string|max:100',
            'no_panggil' => 'required|string|max:255',
            'no_rak' => 'required|string|max:255',
            'id_tipe' => 'required|exists:tipe_koleksi,id_tipe',
            'kode_bahasa' => 'required|exists:dok_bahasa,kode_bahasa',
            'id_penerbit' => 'required|exists:penerbit,id_penerbit',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
            'id_subjek' => 'required|array',
            'id_subjek.*' => 'integer|exists:subjek,id_subjek',
            'kode_1' => 'required|string|size:4',
            'kode_2' => 'required|string|size:4',
            'jumlah_buku' => 'required|integer|min:1',
            'id_penulis' => 'nullable|array',
            'id_penulis.*' => 'integer|exists:penulis,id_penulis',
            'penulis_baru' => 'nullable|array',
            'penulis_baru.*' => 'string|max:255',
            'penulis_baru_tipe' => 'nullable|array',
            'penulis_baru_tipe.*' => 'in:Nama Orang,Badan Organisasi,Konferensi',
        ]);

        if (!$this->requestMemilikiPenulis($request)) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'penulis_input' => 'Pilih penulis dari daftar atau tambahkan penulis baru.',
                ]);
        }

        $data = $request->only([
            'id_tipe', 'kode_bahasa', 'id_penerbit', 'isbn', 'judul_buku',
            'tanggal_terbit', 'deskripsi', 'edisi', 'no_panggil', 'no_rak'
        ]);

        $kode1 = $this->normalizeItemCodePart($request->kode_1);
        $kode2 = $this->normalizeItemCodePart($request->kode_2);

        $itemIds = [];
        for ($i = 1; $i <= $request->jumlah_buku; $i++) {
            $itemIds[] = $this->makeItemId($kode1, $kode2, $i);
        }

        if (ItemBuku::whereIn('id_item', $itemIds)->exists()) {
            return redirect()->back()->withInput()->with('error', 'Kode item buku sudah digunakan. Silakan regenerate Kode 1 dan 2.');
        }

        if ($request->hasFile('cover')) {
            $file = $request->file('cover');
            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9_.-]/', '_', $file->getClientOriginalName());
            $file->storeAs('covers', $filename, 'public');
            $data['cover_buku'] = $filename;
        }

        DB::transaction(function () use ($data, $request, $itemIds) {
            $book = Buku::create($data);

            $book->subjek()->sync($request->id_subjek);
            $book->penulis()->sync($this->ambilIdPenulisUntukSync($request));

            foreach ($itemIds as $idItem) {
                $itemBuku = ItemBuku::create([
                    'id_item' => $idItem,
                    'id_buku' => $book->id_buku,
                    'status_item' => 'Tersedia',
                ]);
            }
        });

        return redirect()->route('admin.buku')->with('success', 'Data buku berhasil disimpan');
    }

    public function edit($id)
    {
        $book = Buku::findOrFail($id);

        $tipe = TipeKoleksi::all();
        $bahasa = DokBahasa::all();
        $penerbit = Penerbit::all();
        $subjek = Subjek::all();
        $penulis = Penulis::all();
        $tipe_penulis = Penulis::select('tipe_penulis')->distinct()->pluck('tipe_penulis');
        [$kode1Item, $kode2Item] = $this->extractItemCodeParts($book->items()->orderBy('tanggal_dibuat')->value('id_item'));

        return view('admin.buku.form-buku', compact('book', 'tipe', 'bahasa', 'penerbit', 'subjek', 'penulis', 'tipe_penulis', 'kode1Item', 'kode2Item'));
    }

    public function update(Request $request, $id)
    {
        $book = Buku::findOrFail($id);

        $request->validate([
            'judul_buku' => 'required|string|max:255',
            'isbn' => 'required|string|max:13|unique:buku,isbn,' . $book->id_buku . ',id_buku',
            'tanggal_terbit' => 'required|date',
            'deskripsi' => 'required|string',
            'edisi' => 'required|string|max:100',
            'no_panggil' => 'required|string|max:255',
            'no_rak' => 'required|string|max:255',
            'id_tipe' => 'required|exists:tipe_koleksi,id_tipe',
            'kode_bahasa' => 'required|exists:dok_bahasa,kode_bahasa',
            // kode_1 / kode_2 are immutable on edit; we'll derive them from existing items
            'kode_1' => 'nullable|string|size:4',
            'kode_2' => 'nullable|string|size:4',
            'jumlah_buku' => 'required|integer|min:1',
            'id_penerbit' => 'required|exists:penerbit,id_penerbit',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
            'id_subjek' => 'required|array',
            'id_subjek.*' => 'integer|exists:subjek,id_subjek',
            'id_penulis' => 'nullable|array',
            'id_penulis.*' => 'integer|exists:penulis,id_penulis',
            'penulis_baru' => 'nullable|array',
            'penulis_baru.*' => 'string|max:255',
            'penulis_baru_tipe' => 'nullable|array',
            'penulis_baru_tipe.*' => 'in:Nama Orang,Badan Organisasi,Konferensi',
        ]);

        if (!$this->requestMemilikiPenulis($request)) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'penulis_input' => 'Pilih penulis dari daftar atau tambahkan penulis baru.',
                ]);
        }

        $data = $request->only([
            'id_tipe', 'kode_bahasa', 'id_penerbit', 'isbn', 'judul_buku',
            'tanggal_terbit', 'deskripsi', 'edisi', 'no_panggil', 'no_rak'
        ]);

        $newCount = (int) $request->input('jumlah_buku', $book->items()->count());

        // Determine kode parts from existing items to prevent changes
        [$kode1, $kode2] = $this->extractItemCodeParts($book->items()->orderBy('tanggal_dibuat')->value('id_item'));
        // fallback to request (edge cases)
        if (!$kode1) $kode1 = $this->normalizeItemCodePart($request->input('kode_1', ''));
        if (!$kode2) $kode2 = $this->normalizeItemCodePart($request->input('kode_2', ''));

        $oldCount = $book->items()->count();
        $newItemIds = [];

        // Disallow decreasing jumlah on edit — only allow adding
        if ($newCount < $oldCount) {
            return redirect()->back()->withInput()->with('error', 'Jumlah buku hanya dapat ditambah saat edit, tidak dapat dikurangi.');
        }

        if ($newCount > $oldCount) {
            for ($i = $oldCount + 1; $i <= $newCount; $i++) {
                $newItemIds[] = $this->makeItemId($kode1, $kode2, $i);
            }

            if (ItemBuku::whereIn('id_item', $newItemIds)->exists()) {
                return redirect()->back()->withInput()->with('error', 'Kode item buku sudah digunakan. Hubungi administrator.');
            }
        }

        if ($request->hasFile('cover')) {
            $this->deleteCoverIfExists($book->cover_buku);

            $file = $request->file('cover');
            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9_.-]/', '_', $file->getClientOriginalName());
            $file->storeAs('covers', $filename, 'public');
            $data['cover_buku'] = $filename;
        }

        DB::transaction(function () use ($book, $data, $request, $newItemIds) {
            $book->update($data);

            foreach ($newItemIds as $idItem) {
                ItemBuku::create([
                    'id_item' => $idItem,
                    'id_buku' => $book->id_buku,
                    'status_item' => 'Tersedia',
                ]);
            }
            $book->subjek()->sync($request->id_subjek);
            $book->penulis()->sync($this->ambilIdPenulisUntukSync($request));
        });

        return redirect()->route('admin.buku')->with('success', 'Data buku berhasil diperbarui');
    }

    public function destroy($id)
    {
        $book = Buku::findOrFail($id);

        try {
            // lepaskan relasi pivot
            if (method_exists($book, 'penulis')) {
                $book->penulis()->detach();
            }
            if (method_exists($book, 'subjek')) {
                $book->subjek()->detach();
            }

            // hapus baris item_buku terkait terlebih dahulu agar tidak terjadi pelanggaran FK
            ItemBuku::where('id_buku', $book->id_buku)->delete();

            // hapus file cover di disk jika ada
            $this->deleteCoverIfExists($book->cover_buku);

            $book->delete();

            return redirect()->route('admin.buku')->with('success', 'Data buku berhasil dihapus');
        } catch (Throwable $e) {
            return redirect()->route('admin.buku')->with('error', 'Gagal menghapus buku: ' . $e->getMessage());
        }
    }

    /**
     * Hapus beberapa buku yang dipilih dari daftar
     */
    public function destroyMultiple(Request $request)
    {
        $ids = $request->input('id_buku', []);

        if (!is_array($ids) || !count($ids)) {
            return redirect()->route('admin.buku')->with('warning', 'Pilih minimal satu data');
        }

        try {
            foreach ($ids as $id) {
                $book = Buku::find($id);
                if (!$book) continue;

                // lepaskan relasi pivot
                if (method_exists($book, 'penulis')) {
                    $book->penulis()->detach();
                }
                if (method_exists($book, 'subjek')) {
                    $book->subjek()->detach();
                }

                // hapus item terkait
                ItemBuku::where('id_buku', $book->id_buku)->delete();

                // hapus file cover jika ada di disk
                $this->deleteCoverIfExists($book->cover_buku);

                $book->delete();
            }

            return redirect()->route('admin.buku')->with('success', 'Data buku berhasil dihapus');
        } catch (Throwable $e) {
            return redirect()->route('admin.buku')->with('error', 'Gagal menghapus beberapa buku: ' . $e->getMessage());
        }
    }

    /**
     * Hapus file cover jika nilainya adalah nama file yang ada di disk.
     * Menangani kasus di mana DB mungkin berisi data biner atau data-URI.
     */
    protected function deleteCoverIfExists($cover)
    {
        if (!$cover) return;
        if (!is_string($cover)) return;

        $cover = trim($cover);
        if ($cover === '') return;

        // Jika berupa data URI, tidak ada file yang perlu dihapus di disk
        if (str_starts_with($cover, 'data:image/')) return;

        // Jika mengandung karakter kontrol tidak dapat dicetak, asumsikan data biner tersimpan di DB; tidak ada file yang perlu dihapus di disk
        if (preg_match('/[\x00-\x08\x0B\x0C\x0E-\x1F]/', $cover)) return;

        $path = 'covers/' . $cover;
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    protected function normalizeItemCodePart($value)
    {
        return strtoupper(substr((string) $value, 0, 4));
    }

    protected function makeItemId($kode1, $kode2, $urutan)
    {
        return $kode1 . '-' . $kode2 . '-' . str_pad((int) $urutan, 4, '0', STR_PAD_LEFT);
    }

    protected function extractItemCodeParts($idItem)
    {
        if (!$idItem || !is_string($idItem)) {
            return [null, null];
        }

        $parts = explode('-', $idItem);

        return [$parts[0] ?? null, $parts[1] ?? null];
    }

    protected function requestMemilikiPenulis(Request $request)
    {
        $penulisLama = collect($request->input('id_penulis', []))
            ->filter(fn($id) => filled($id));

        $penulisBaru = collect($request->input('penulis_baru', []))
            ->map(fn($nama) => trim((string) $nama))
            ->filter();

        return $penulisLama->isNotEmpty() || $penulisBaru->isNotEmpty();
    }

    protected function ambilIdPenulisUntukSync(Request $request)
    {
        $penulisIds = collect($request->input('id_penulis', []))
            ->filter(fn($id) => filled($id))
            ->map(fn($id) => (int) $id);

        $tipePenulisBaru = $request->input('penulis_baru_tipe', []);
        $namaPenulisBaru = collect($request->input('penulis_baru', []))
            ->map(function ($nama, $index) use ($tipePenulisBaru) {
                return [
                    'nama' => trim((string) $nama),
                    'tipe' => $this->normalisasiTipePenulis($tipePenulisBaru[$index] ?? 'Nama Orang'),
                ];
            })
            ->filter(fn($penulis) => $penulis['nama'] !== '')
            ->unique(fn($penulis) => strtolower($penulis['nama']));

        foreach ($namaPenulisBaru as $dataPenulisBaru) {
            $namaPenulis = $dataPenulisBaru['nama'];
            $penulis = Penulis::whereRaw(
                'LOWER(nama_penulis) = ?',
                [strtolower($namaPenulis)]
            )->first();

            if (!$penulis) {
                $penulis = Penulis::create([
                    'nama_penulis' => $namaPenulis,
                    'tipe_penulis' => $dataPenulisBaru['tipe'],
                ]);
            }

            $penulisIds->push((int) $penulis->id_penulis);
        }

        return $penulisIds
            ->unique()
            ->values()
            ->all();
    }

    protected function normalisasiTipePenulis($tipePenulis)
    {
        $opsiTipePenulis = ['Nama Orang', 'Badan Organisasi', 'Konferensi'];

        return in_array($tipePenulis, $opsiTipePenulis, true)
            ? $tipePenulis
            : 'Nama Orang';
    }
}
