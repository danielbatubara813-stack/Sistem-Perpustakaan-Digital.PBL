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
use App\Models\Peminjaman;
use App\Models\Reservasi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

use Throwable;

class BukuController extends Controller
{
    private const STATUS_ITEM_MANUAL = ['Tersedia', 'Tidak Tersedia'];
    private const STATUS_RESERVASI_ITEM_AKTIF = ['Menunggu Konfirmasi', 'Siap Diambil'];

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
        $this->validasiBuku($request);

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
        $book = Buku::with([
            'items' => function ($query) {
                $query
                    ->orderBy('tanggal_dibuat')
                    ->orderBy('id_item');
            },
        ])->findOrFail($id);

        $this->sinkronkanStatusItemBuku($book);

        $book->load([
            'items' => function ($query) {
                $query
                    ->orderBy('tanggal_dibuat')
                    ->orderBy('id_item');
            },
        ]);

        $tipe = TipeKoleksi::all();
        $bahasa = DokBahasa::all();
        $penerbit = Penerbit::all();
        $subjek = Subjek::all();
        $penulis = Penulis::all();
        $tipe_penulis = Penulis::select('tipe_penulis')->distinct()->pluck('tipe_penulis');
        [$kode1Item, $kode2Item] = $this->extractItemCodeParts($book->items()->orderBy('tanggal_dibuat')->value('id_item'));

        return view('admin.buku.form-buku', compact('book', 'tipe', 'bahasa', 'penerbit', 'subjek', 'penulis', 'tipe_penulis', 'kode1Item', 'kode2Item'));
    }

    public function updateItemStatus(Request $request, string $idItem)
    {
        $validated = $request->validate([
            'status_item' => ['required', 'in:Tersedia,Tidak Tersedia'],
        ], [
            'status_item.required' => 'Status item buku wajib dipilih.',
            'status_item.in' => 'Status item buku hanya dapat diubah menjadi Tersedia atau Tidak Tersedia.',
        ]);

        $pesanSukses = null;

        try {
            DB::transaction(function () use ($idItem, $validated, &$pesanSukses) {
                $itemBuku = ItemBuku::where('id_item', $idItem)
                    ->lockForUpdate()
                    ->first();

                if (!$itemBuku) {
                    throw ValidationException::withMessages([
                        'status_item' => 'Item buku tidak ditemukan.',
                    ]);
                }

                if ($this->itemBukuSedangDipinjam($itemBuku)) {
                    $itemBuku->update(['status_item' => 'Dipinjam']);

                    throw ValidationException::withMessages([
                        'status_item' => 'Buku masih dipinjam.',
                    ]);
                }

                if ($this->itemBukuSedangDipesan($itemBuku)) {
                    $itemBuku->update(['status_item' => 'Dipesan']);

                    throw ValidationException::withMessages([
                        'status_item' => 'Buku sedang dipesan melalui reservasi.',
                    ]);
                }

                if ($itemBuku->status_item === 'Tidak Aktif') {
                    $itemBuku->update(['status_item' => 'Tidak Tersedia']);
                    $itemBuku->refresh();
                }

                if (!in_array($itemBuku->status_item, self::STATUS_ITEM_MANUAL, true)) {
                    throw ValidationException::withMessages([
                        'status_item' => 'Status buku hanya dapat diubah manual jika item sedang Tersedia atau Tidak Tersedia.',
                    ]);
                }

                if ($itemBuku->status_item === $validated['status_item']) {
                    $pesanSukses = 'Status item buku ' . $itemBuku->id_item . ' sudah '
                        . $validated['status_item'] . '.';
                    return;
                }

                $itemBuku->update([
                    'status_item' => $validated['status_item'],
                ]);

                $pesanSukses = 'Status item buku ' . $itemBuku->id_item . ' berhasil diubah menjadi '
                    . $validated['status_item'] . '.';
            });
        } catch (ValidationException $e) {
            return redirect()
                ->back()
                ->with('error', collect($e->errors())->flatten()->first());
        } catch (Throwable $e) {
            return redirect()
                ->back()
                ->with('error', 'Status item buku gagal diubah. Silakan coba lagi.');
        }

        return redirect()
            ->back()
            ->with('success', $pesanSukses);
    }

    public function update(Request $request, $id)
    {
        $book = Buku::findOrFail($id);

        $this->validasiBuku($request, $book);

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
        $book = Buku::find($id);

        if (!$book) {
            return redirect()->route('admin.buku')->with('error', 'Data buku tidak ditemukan atau sudah dihapus.');
        }

        $pemakaian = $this->detailPemakaianBuku($book);

        if ($pemakaian['digunakan']) {
            return redirect()
                ->route('admin.buku')
                ->with('error', $this->pesanBukuSedangDigunakan($book, $pemakaian));
        }

        try {
            $cover = $book->cover_buku;

            DB::transaction(function () use ($book) {
                $this->hapusBukuTanpaPemakaian($book);
            });

            $this->deleteCoverIfExists($cover);

            return redirect()->route('admin.buku')->with('success', 'Data buku berhasil dihapus');
        } catch (Throwable $e) {
            return redirect()->route('admin.buku')->with('error', 'Gagal menghapus buku. Pastikan data buku tidak sedang digunakan pada peminjaman atau reservasi.');
        }
    }

    /**
     * Hapus beberapa buku yang dipilih dari daftar
     */
    public function destroyMultiple(Request $request)
    {
        $ids = collect($request->input('id_buku', []))
            ->filter(fn($id) => filled($id))
            ->unique()
            ->values();

        if ($ids->isEmpty()) {
            return redirect()->route('admin.buku')->with('warning', 'Pilih minimal satu data');
        }

        $books = Buku::whereIn('id_buku', $ids)->get();

        if ($books->isEmpty()) {
            return redirect()->route('admin.buku')->with('error', 'Data buku yang dipilih tidak ditemukan atau sudah dihapus.');
        }

        $bukuDigunakan = $books
            ->map(function ($book) {
                return [
                    'book' => $book,
                    'pemakaian' => $this->detailPemakaianBuku($book),
                ];
            })
            ->filter(fn($data) => $data['pemakaian']['digunakan'])
            ->values();

        if ($bukuDigunakan->isNotEmpty()) {
            return redirect()
                ->route('admin.buku')
                ->with('error', $this->pesanBeberapaBukuSedangDigunakan($bukuDigunakan));
        }

        try {
            $covers = $books->pluck('cover_buku')->filter();

            DB::transaction(function () use ($books) {
                foreach ($books as $book) {
                    $this->hapusBukuTanpaPemakaian($book);
                }
            });

            foreach ($covers as $cover) {
                $this->deleteCoverIfExists($cover);
            }

            return redirect()->route('admin.buku')->with('success', 'Data buku berhasil dihapus');
        } catch (Throwable $e) {
            return redirect()->route('admin.buku')->with('error', 'Gagal menghapus beberapa buku. Pastikan data buku tidak sedang digunakan pada peminjaman atau reservasi.');
        }
    }

    protected function hapusBukuTanpaPemakaian(Buku $book)
    {
        if (method_exists($book, 'penulis')) {
            $book->penulis()->detach();
        }

        if (method_exists($book, 'subjek')) {
            $book->subjek()->detach();
        }

        ItemBuku::where('id_buku', $book->id_buku)->delete();

        $book->delete();
    }

    protected function detailPemakaianBuku(Buku $book)
    {
        $itemIds = $book->items()->pluck('id_item');

        $peminjaman = $itemIds->isEmpty()
            ? 0
            : DB::table('peminjaman')->whereIn('id_item', $itemIds)->count();

        $peminjamanAktif = $itemIds->isEmpty()
            ? 0
            : DB::table('peminjaman')
                ->whereIn('id_item', $itemIds)
                ->whereIn('status', ['Dipinjam', 'Terlambat'])
                ->count();

        $pengembalian = $itemIds->isEmpty()
            ? 0
            : DB::table('pengembalian')
                ->join('peminjaman', 'pengembalian.kode_peminjaman', '=', 'peminjaman.kode_peminjaman')
                ->whereIn('peminjaman.id_item', $itemIds)
                ->count();

        $reservasi = DB::table('reservasi')
            ->where('id_buku', $book->id_buku)
            ->count();

        $reservasiAktif = DB::table('reservasi')
            ->where('id_buku', $book->id_buku)
            ->whereIn('status', ['Draft', 'Menunggu Konfirmasi', 'Menunggu Antrian', 'Siap Diambil'])
            ->count();

        return [
            'peminjaman' => $peminjaman,
            'peminjaman_aktif' => $peminjamanAktif,
            'pengembalian' => $pengembalian,
            'reservasi' => $reservasi,
            'reservasi_aktif' => $reservasiAktif,
            'digunakan' => $peminjaman > 0 || $pengembalian > 0 || $reservasi > 0,
        ];
    }

    protected function pesanBukuSedangDigunakan(Buku $book, array $pemakaian)
    {
        return 'Buku "' . $book->judul_buku . '" tidak dapat dihapus karena sudah digunakan pada '
            . $this->ringkasanPemakaianBuku($pemakaian)
            . '. Selesaikan atau periksa data terkait terlebih dahulu.';
    }

    protected function pesanBeberapaBukuSedangDigunakan($bukuDigunakan)
    {
        $detail = $bukuDigunakan
            ->take(3)
            ->map(function ($data) {
                return '"' . $data['book']->judul_buku . '" (' . $this->ringkasanPemakaianBuku($data['pemakaian']) . ')';
            })
            ->implode('; ');

        $sisa = $bukuDigunakan->count() - 3;
        $tambahan = $sisa > 0 ? '; dan ' . $sisa . ' buku lainnya' : '';

        return $bukuDigunakan->count()
            . ' buku tidak dapat dihapus karena sudah digunakan: '
            . $detail
            . $tambahan
            . '. Tidak ada data buku yang dihapus.';
    }

    protected function ringkasanPemakaianBuku(array $pemakaian)
    {
        $bagian = [];

        if ($pemakaian['peminjaman'] > 0) {
            $bagian[] = $pemakaian['peminjaman'] . ' data peminjaman'
                . ($pemakaian['peminjaman_aktif'] > 0 ? ' (' . $pemakaian['peminjaman_aktif'] . ' masih aktif)' : '');
        }

        if ($pemakaian['pengembalian'] > 0) {
            $bagian[] = $pemakaian['pengembalian'] . ' data pengembalian';
        }

        if ($pemakaian['reservasi'] > 0) {
            $bagian[] = $pemakaian['reservasi'] . ' data reservasi'
                . ($pemakaian['reservasi_aktif'] > 0 ? ' (' . $pemakaian['reservasi_aktif'] . ' masih aktif)' : '');
        }

        return implode(', ', $bagian);
    }

    protected function sinkronkanStatusItemBuku(Buku $book): void
    {
        $itemIds = $book->items()->pluck('id_item');

        if ($itemIds->isEmpty()) {
            return;
        }

        $itemDipinjam = Peminjaman::whereIn('id_item', $itemIds)
            ->where('status', 'Dipinjam')
            ->pluck('id_item');

        if ($itemDipinjam->isNotEmpty()) {
            ItemBuku::whereIn('id_item', $itemDipinjam)
                ->where('status_item', '!=', 'Dipinjam')
                ->update(['status_item' => 'Dipinjam']);
        }

        $itemDipesan = Reservasi::whereIn('id_item', $itemIds)
            ->whereIn('status', self::STATUS_RESERVASI_ITEM_AKTIF)
            ->pluck('id_item')
            ->diff($itemDipinjam)
            ->values();

        if ($itemDipesan->isNotEmpty()) {
            ItemBuku::whereIn('id_item', $itemDipesan)
                ->where('status_item', '!=', 'Dipesan')
                ->update(['status_item' => 'Dipesan']);
        }

        $itemBebas = $itemIds
            ->diff($itemDipinjam)
            ->diff($itemDipesan)
            ->values();

        if ($itemBebas->isEmpty()) {
            return;
        }

        ItemBuku::whereIn('id_item', $itemBebas)
            ->whereIn('status_item', ['Sedang Dipinjam', 'Dipinjam', 'Dipesan'])
            ->update(['status_item' => 'Tersedia']);

        ItemBuku::whereIn('id_item', $itemBebas)
            ->where('status_item', 'Tidak Aktif')
            ->update(['status_item' => 'Tidak Tersedia']);
    }

    protected function itemBukuSedangDipinjam(ItemBuku $itemBuku): bool
    {
        if (in_array($itemBuku->status_item, ['Dipinjam', 'Sedang Dipinjam'], true)) {
            return true;
        }

        return Peminjaman::where('id_item', $itemBuku->id_item)
            ->where('status', 'Dipinjam')
            ->exists();
    }

    protected function itemBukuSedangDipesan(ItemBuku $itemBuku): bool
    {
        if ($itemBuku->status_item === 'Dipesan') {
            return true;
        }

        return Reservasi::where('id_item', $itemBuku->id_item)
            ->whereIn('status', self::STATUS_RESERVASI_ITEM_AKTIF)
            ->exists();
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

    protected function validasiBuku(Request $request, ?Buku $book = null)
    {
        $isEdit = $book && $book->exists;

        $rules = [
            'id_tipe' => 'required|exists:tipe_koleksi,id_tipe',
            'judul_buku' => 'required|string|max:255',
            'no_rak' => 'required|string|max:255',
            'no_panggil' => 'required|string|max:255',
            'id_penerbit' => 'required|exists:penerbit,id_penerbit',
            // kode_1 / kode_2 are immutable on edit; we'll derive them from existing items
            'kode_1' => ($isEdit ? 'nullable' : 'required') . '|string|size:4',
            'kode_2' => ($isEdit ? 'nullable' : 'required') . '|string|size:4',
            'jumlah_buku' => 'required|integer|min:1',
            'kode_bahasa' => 'required|exists:dok_bahasa,kode_bahasa',
            'isbn' => 'required|string|max:13|unique:buku,isbn' . ($isEdit ? ',' . $book->id_buku . ',id_buku' : ''),
            'id_subjek' => 'required|array',
            'id_subjek.*' => 'integer|exists:subjek,id_subjek',
            'tanggal_terbit' => 'required|date',
            'deskripsi' => 'required|string',
            'edisi' => 'required|string|max:100',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
            'id_penulis' => 'nullable|array',
            'id_penulis.*' => 'integer|exists:penulis,id_penulis',
            'penulis_baru' => 'nullable|array',
            'penulis_baru.*' => 'string|max:255',
            'penulis_baru_tipe' => 'nullable|array',
            'penulis_baru_tipe.*' => 'in:Nama Orang,Badan Organisasi,Konferensi',
        ];

        $validator = Validator::make($request->all(), $rules, $this->pesanValidasiBuku());

        $validator->after(function ($validator) use ($request) {
            if (!$this->requestMemilikiPenulis($request)) {
                $validator->errors()->add('penulis_input', 'Penulis wajib dipilih atau ditambahkan.');
            }
        });

        return $validator->validate();
    }

    protected function pesanValidasiBuku()
    {
        return [
            'id_tipe.required' => 'Tipe koleksi wajib dipilih.',
            'id_tipe.exists' => 'Tipe koleksi yang dipilih tidak valid.',
            'judul_buku.required' => 'Judul wajib diisi.',
            'judul_buku.max' => 'Judul maksimal 255 karakter.',
            'no_rak.required' => 'Nomor rak wajib diisi.',
            'no_rak.max' => 'Nomor rak maksimal 255 karakter.',
            'no_panggil.required' => 'Nomor panggil wajib diisi.',
            'no_panggil.max' => 'Nomor panggil maksimal 255 karakter.',
            'id_penerbit.required' => 'Penerbit wajib dipilih.',
            'id_penerbit.exists' => 'Penerbit yang dipilih tidak valid.',
            'kode_1.required' => 'Kode unik wajib diisi.',
            'kode_2.required' => 'Kode unik wajib diisi.',
            'kode_1.size' => 'Kode unik harus terdiri dari 4 karakter.',
            'kode_2.size' => 'Kode unik harus terdiri dari 4 karakter.',
            'jumlah_buku.required' => 'Jumlah buku wajib diisi.',
            'jumlah_buku.integer' => 'Jumlah buku harus berupa angka.',
            'jumlah_buku.min' => 'Jumlah buku minimal 1.',
            'kode_bahasa.required' => 'Bahasa wajib dipilih.',
            'kode_bahasa.exists' => 'Bahasa yang dipilih tidak valid.',
            'isbn.required' => 'ISBN/ISSN wajib diisi.',
            'isbn.max' => 'ISBN/ISSN maksimal 13 karakter.',
            'isbn.unique' => 'ISBN/ISSN sudah digunakan.',
            'id_subjek.required' => 'Subjek wajib dipilih.',
            'id_subjek.array' => 'Subjek wajib dipilih.',
            'id_subjek.*.exists' => 'Subjek yang dipilih tidak valid.',
            'tanggal_terbit.required' => 'Tanggal terbit wajib diisi.',
            'tanggal_terbit.date' => 'Tanggal terbit tidak valid.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'edisi.required' => 'Edisi wajib diisi.',
            'edisi.max' => 'Edisi maksimal 100 karakter.',
            'cover.image' => 'Gambar sampul harus berupa gambar.',
            'cover.mimes' => 'Gambar sampul harus berformat JPG, JPEG, atau PNG.',
            'cover.max' => 'Ukuran gambar sampul maksimal 10MB.',
            'id_penulis.array' => 'Data penulis tidak valid.',
            'id_penulis.*.exists' => 'Penulis yang dipilih tidak valid.',
            'penulis_baru.*.max' => 'Nama penulis maksimal 255 karakter.',
            'penulis_baru_tipe.*.in' => 'Tipe penulis tidak valid.',
        ];
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
